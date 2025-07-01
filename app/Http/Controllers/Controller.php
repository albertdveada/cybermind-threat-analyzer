<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // API FUNCTION GET IP GEOLOCATION
    protected function IpAddressInfo(string $ipAddress): array
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            Log::channel('lookup_ip')->info("GeoIP Skipped | IP: {$ipAddress} | Reason: IP is private or invalid");
            return ['status' => 'IP_Local', 'message' => 'IP address is invalid for lookup Geolocation!'];
        }

        $baseUrl = "http://ip-api.com";
        $url = "{$baseUrl}/json/{$ipAddress}";

        try {
            $response = Http::timeout(5)->get($url);
            $ipInfo = $response->json();

            if (isset($ipInfo['status']) && $ipInfo['status'] === 'success') {

                return [
                    'country' => $ipInfo['country'] ?? 'N/A',
                    'countryCode' => $ipInfo['countryCode'] ?? 'N/A',
                    'regionName' => $ipInfo['regionName'] ?? 'N/A',
                    'city' => $ipInfo['city'] ?? 'N/A',
                    'zip' => $ipInfo['zip'] ?? 'N/A',
                    'lat' => $ipInfo['lat'] ?? null,
                    'lon' => $ipInfo['lon'] ?? null,
                    'timezone' => $ipInfo['timezone'] ?? 'N/A',
                    'isp' => $ipInfo['isp'] ?? 'N/A',
                    'org' => $ipInfo['org'] ?? 'N/A',
                    'as' => $ipInfo['as'] ?? 'N/A',
                ];

            } else {
                $failReason = $ipInfo['message'] ?? 'Unknown';
                Log::channel('lookup_ip')->warning("GeoIP Failed | IP: {$ipAddress} | Status: {$ipInfo['status']} | Reason: {$failReason}");
                return ['status' => 'failed', 'message' => "Failed to find IP geolocation: {$failReason}"];
            }

        } catch (\Exception $e) {
            Log::channel('lookup_ip')->error("GeoIP Exception | IP: {$ipAddress} | Error: " . $e->getMessage());
            return ['status' => 'exception', 'message' => 'An error occurred while searching for IP Address info.'];
        }
    }

    // API FUNCTION GET RESPON (GEMINI AI)
    protected function callGeminiApi(string $prompt): array
    {
        $ApiKey = env('AI_API_KEY');
        if (empty($ApiKey)) {
            throw new \Exception("Gemini API not found in file!");
        }

        $modelName = "gemini-2.0-flash";

        $baseUrl = "https://generativelanguage.googleapis.com";
        $url = "{$baseUrl}/v1beta/models/{$modelName}:generateContent?key={$ApiKey}";

        try {

            $response = Http::timeout(30)->post("{$url}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                $status = $response->status();
                $body = $response->body();
                $shortBody = strlen($body) > 100 ? substr($body, 0, 100) . '...' : $body;

                Log::channel('gemini_respon')->error("[GeminiAPI] Request Failed | Status: {$status} | Response: {$shortBody}");
                throw new \Exception("Request failed STATUS: {$status}");
            }

            $geminiResponse = $response->json();

            $alertLevel = 'unknow';
            $description = 'AI analysis is not available at this time.';
            $analysisText = 'AI analysis is not available in its entirety,';

            if (isset($geminiResponse['candidates'][0]['content']['parts'][0]['text'])) {
                $rawText = $geminiResponse['candidates'][0]['content']['parts'][0]['text'];
                $analysisText = $rawText;

                $alertLevel = 'unknown';
                $description = 'AI analysis is not available at this time.';

                if (preg_match('/LEVEL:\s*(none|low|medium|high|critical)/i', $rawText, $levelMatch)) {
                    $levelFound = strtolower($levelMatch[1]);
                    $validLevels = ['none', 'low', 'medium', 'high', 'critical'];

                    if (in_array($levelFound, $validLevels)) {
                        $alertLevel = $levelFound;
                        $analysisText = str_ireplace($levelMatch[0], '', $analysisText);
                    }
                }

                if (preg_match('/Description:\s*(.+?)(\r?\n|$)/i', $rawText, $descMatch)) {
                    $description = trim($descMatch[1]);
                    $analysisText = str_ireplace($descMatch[0], '', $analysisText);
                }

                $analysisText = trim($analysisText);

            } else {
                Log::channel('gemini_respon')->warning("[Gemini API] Response structure is not properly formatted.");
                $alertLevel = 'unknown';
                $description = 'AI response format invalid.';
                $analysisText = '';
            }

            return [
                'analysis_level' => $alertLevel,
                'description'    => $description,
                'analysis_text'  => $analysisText,
            ];

        } catch (\Exception $e) {
            Log::channel('gemini_respon')->error("[GeminiAPI] Exception | Message: " . $e->getMessage());
            throw $e;
        }
    }
}

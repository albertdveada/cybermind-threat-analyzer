<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AnalyzeLogin;
use App\Models\AnalyzeSecurityLog;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Endpoint API: POST
     * @param Request
     * @return \Illuminate\Http\JsonResponse Respon JSON terstruktur untuk klien
     */
    public function AnalyzeLogin(Request $request)
    {
        // Validasi input universal login
        $request->validate([
            'ip_address'    => 'required|ip',
            'username'      => 'required|string',
            'status'        => 'required|in:success,failed',
            'user_agent'    => 'nullable|string|max:500',
            'device'        => 'nullable|string|max:100',
            'platform'      => 'nullable|string|max:100',
            'browser'       => 'nullable|string|max:100',
            'login_method'  => 'nullable|string|max:50',
            'session_id'    => 'nullable|string|max:255',
        ]);

        // Autentikasi User
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Ambil data input
        $ipAddress = $request->ip_address;
        $ipDetails = $ipAddress ? $this->IpAddressInfo($ipAddress) : [];
        $username = $request->username;
        $status = $request->status;
        $userAgent = $request->input('user_agent');
        $device = $request->input('device');
        $platform = $request->input('platform');
        $browser = $request->input('browser');
        $loginMethod = $request->input('login_method');
        $sessionId = $request->input('session_id');

        // Simpan log login
        AnalyzeLogin::create([
            'client_id' => $user->client_id,
            'ip_address' => $ipAddress,
            'country' => $ipDetails['country'] ?? null,
            'city' => $ipDetails['city'] ?? null,
            'username' => $username,
            'status' => $status,
            'user_agent' => $userAgent,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'login_method' => $loginMethod,
            'session_id' => $sessionId,
        ]);


        if ($status === 'failed') {

            $failedAttempts = AnalyzeLogin::where('ip_address', $ipAddress)
                ->where('status', 'failed')
                ->where('created_at', '>', now()->subMinutes(5))
                ->count();

            $maxLogin = 5;

            if ($failedAttempts >= $maxLogin) {

                $typeAlerts = "Login Failed";

                $ipInfo = (is_array($ipDetails) && isset($ipDetails['city']) && isset($ipDetails['country']))
                    ? "From " . ($ipDetails['city'] ?? 'Unknown City') . ", " . ($ipDetails['country'] ?? 'Unknown Country') . " (ISP: " . ($ipDetails['isp'] ?? 'Unknown ISP') . ")."
                    : "No additional information is available about the IP address.";
                    
                $user_agentContents = !empty($userAgent) ? "'User-Agent:{$userAgent}.'" : "";

                $additionalInfo = "";
                if ($device) $additionalInfo .= "Device: {$device}. ";
                if ($platform) $additionalInfo .= "Platform: {$platform}. ";
                if ($browser) $additionalInfo .= "Browser: {$browser}. ";
                if ($ipInfo) $additionalInfo .= "Location: {$ipInfo}. ";
                if ($loginMethod) $additionalInfo .= "Login Method: {$loginMethod}. ";
                if ($sessionId) $additionalInfo .= "Session ID: {$sessionId}. ";
                $additionalInfo = trim($additionalInfo);

                $aiPrompt = "'IP Address:{$ipAddress}'\n";
                if ($user_agentContents !== "") $aiPrompt .= "{$user_agentContents}\n";
                if ($additionalInfo !== "") $aiPrompt .= "'Details: {$additionalInfo}'\n";
                $aiPrompt .= "Please analyze this User-Agent for common bot, crawler, or malicious activity patterns. It attempted to access the username '{$username}' 5 times unsuccessfully within 5 minutes. Does this indicate a potential threat or attack? Provide a brief description and recommend immediate actions.\nInclude the threat level and a very short description at the end of your response, formatted as:\nLEVEL: [none|low|medium|high|critical]'\nExample: LEVEL:high\nExample: Description:";

                try {

                    $aiResponse = $this->callGeminiApi($aiPrompt);
                    $aiLevel = $aiResponse['analysis_level'] ?? null;
                    $aiDescription = $aiResponse['description'] ?? null;

                } catch (\Exception $e) {

                    $aiLevel = "Important";
                    $aiDescription = "Failed to get AI analysis: " . $e->getMessage();

                    Log::channel('client_analyze_login')->error('[API Failure] AnalyzeLogin AI Analysis Failed', [
                        'error_message' => $e->getMessage(),
                        'ip_address' => $ipAddress,
                        'username' => $username,
                        'client_id' => $user->client_id,
                        'request_data' => [
                            'user_agent' => $userAgent,
                            'device' => $device,
                            'platform' => $platform,
                            'browser' => $browser,
                            'login_method' => $loginMethod,
                            'session_id' => $sessionId,
                        ],
                        'ai_prompt' => $aiPrompt,
                        'timestamp' => now()->toDateTimeString(),
                    ]);
                }

                $existingAlert = AnalyzeSecurityLog::where('client_id', $user->client_id)
                    ->where('type', $typeAlerts)
                    ->where('source_ip', $ipAddress)
                    ->where('status', 'triggered')
                    ->first();

                if (!$existingAlert) {

                    AnalyzeSecurityLog::create([
                        'client_id' => $user->client_id,
                        'type' => $typeAlerts,
                        'security_level' => $aiLevel,
                        'source_ip' => $ipAddress,
                        'country' => $ipDetails['country'] ?? null,
                        'city' => $ipDetails['city'] ?? null,
                        'log_message' => $aiDescription,
                    ]);

                } else {

                    $existingAlert->update([
                        'security_level' => $aiLevel,
                        'log_message' => $aiDescription,
                    ]);

                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Analysis completed.',
                    'timestamp' => now()->toIso8601String(),
                    'data' => [
                        'type' => $typeAlerts,
                        'security_level' => $aiLevel,
                        'failed_attempts' => $failedAttempts,
                        'ip_address' => $ipAddress,
                        'ip_info' => $ipDetails,
                        'user_agent' => $userAgent,
                        'username' => $username,
                        'ai_analysis' => $aiDescription,
                    ]
                ], 200);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login recorded',
            'timestamp' => now()->toIso8601String(),
            'data' => [
                'ip_address' => $ipAddress,
                'username' => $username,
                'ip_info' => $ipDetails,
                'status_recorded' => $status,
            ]
        ], 200);
    }

    /**
     * Endpoint API: POST
     */
    public function AnalyzeSecurity(Request $request)
    {
        // Validasi input
        $request->validate([
            'log_message' => 'required|string|max:5000',
            'source_ip'   => 'nullable|ip',
            'source'      => 'nullable|string|max:255',   // e.g. firewall, web_server, api_gateway
            'tag'         => 'nullable|string|max:100',   // e.g. error, suspicious, warning
            'platform'    => 'nullable|string|max:100',
            'user_agent'  => 'nullable|string|max:500',
            'metadata'    => 'nullable|array',            // additional custom info
        ]);

        // Autentikasi user
        $user = Auth::guard('sanctum')->user();
        if (!$user) {

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);

        }

        // Ambil data request
        $logMessage = strip_tags($request->log_message);
        $typeAlerts = "Log Analysis";
        $sourceIp   = $request->source_ip;
        $source     = $request->source ?? 'unknown';
        $tag        = $request->tag ?? 'unlabeled';
        $platform   = $request->platform;
        $userAgent  = $request->user_agent;
        $metadata   = $request->metadata ?? [];

        // Dapatkan info IP jika ada
        $ipDetails = $sourceIp ? $this->IpAddressInfo($sourceIp) : [];

        // Siapkan prompt AI
        $aiPrompt = "Security Log Analysis:\n";
        if ($sourceIp)    $aiPrompt .= "IP: {$sourceIp}\n";
        if ($source)      $aiPrompt .= "Source: {$source}\n";
        if ($tag)         $aiPrompt .= "Tag: {$tag}\n";
        if ($platform)    $aiPrompt .= "Platform: {$platform}\n";
        if ($userAgent)   $aiPrompt .= "User-Agent: {$userAgent}\n";
        if (!empty($metadata)) {
            $aiPrompt .= "Metadata: " . json_encode($metadata) . "\n";
        }

        $aiPrompt .= "\nLog:\n{$logMessage}\n\n";
        $aiPrompt .= "Please analyze this security log. Detect if it may contain signs of attack, abuse, or compromise. Recommend any action if necessary. Include threat level at the end of your response in the format:\nLEVEL: [none|low|medium|high|critical]\nDescription: [short summary]\n";

        // Panggil AI (fungsi sudah kamu buat)
        try {
            
            $aiResponse = $this->callGeminiApi($aiPrompt);
            $aiLevel = $aiResponse['analysis_level'];
            $aiDescription = $aiResponse['description'];

        } catch (\Exception $e) {

            $aiLevel = 'unknown';
            $aiDescription = 'AI analysis failed: ' . $e->getMessage();

            Log::channel('client_analyze_security')->error("[Gemini API Failure] AnalyzeSecurity AI Analysis Failed", [
                'Timestamp'     => now()->toDateTimeString(),
                'Client ID'     => $user->client_id,
                'Username'      => $user->email ?? 'unknown',
                'Source IP'     => $sourceIp ?? 'N/A',
                'Source'        => $source ?? 'N/A',
                'Tag'           => $tag ?? 'N/A',
                'Platform'      => $platform ?? 'N/A',
                'User Agent'    => $userAgent ?? 'N/A',
                'Error Message' => $e->getMessage(),
                'Metadata'      => $metadata,
                'AI Prompt'     => $aiPrompt,
            ]);
        }

        $existingAlert = AnalyzeSecurityLog::where('client_id', $user->client_id)
            ->where('status', 'triggered')
            ->where('type', $typeAlerts)
            ->where('source_ip', $sourceIp)
            ->where('security_level', $aiLevel)
        ->first();

        if (!$existingAlert) {

            // Simpan ke database
            AnalyzeSecurityLog::create([
                'client_id'      => $user->client_id,
                'type'           => $typeAlerts,
                'source_ip'      => $sourceIp,
                'country'        => $ipDetails['country'] ?? null,
                'city'           => $ipDetails['city'] ?? null,
                'security_level' => $aiLevel,
                'log_message'    => "[LOG:$logMessage]AI ANALYSIS: $aiDescription",
                'source'         => $source,
                'tag'            => $tag,
                'platform'       => $platform,
                'user_agent'     => $userAgent,
                'metadata'       => json_encode($metadata),
            ]);

        } else {

            $existingAlert->update([
                'security_level' => $aiLevel,
                'log_message' => "[LOG:$logMessage]AI ANALYSIS: $aiDescription",
            ]);

        }

        // Respon JSON
        return response()->json([
            'status'    => 'success',
            'message'   => 'Log analyzed successfully',
            'timestamp' => now()->toIso8601String(),
            'data'      => [
                'ip_address'    => $sourceIp,
                'ip_info'       => $ipDetails,
                'source'        => $source,
                'tag'           => $tag,
                'threat_level'  => $aiLevel,
                'ai_analysis'   => $aiDescription,
            ]
        ], 200);
    }
}

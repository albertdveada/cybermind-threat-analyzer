<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\AnalyzeLogin;
use App\Models\AnalyzeSecurityLog;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_id',
        'name',
        'email',
        'password',
        'status',
        'avatars',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'public_key',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'key_expires_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     * Digunakan untuk mendaftarkan event listener saat model di-boot.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->client_id)) {
                do {
                    $user->client_id = substr(str_shuffle('0123456789'), 0, 10);
                } while (static::where('client_id', $user->client_id)->exists());
            }
        });

        static::created(function ($user) {
            $user->generateApiKey();
        });
    }

    /**
     * The "booted" method of the model.
     * Dipanggil setelah model telah selesai di-boot.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($user) {
            AnalyzeLogin::where('client_id', $user->client_id)->delete();
            AnalyzeSecurityLog::where('client_id', $user->client_id)->delete();
        });
    }

    /**
     * @return string The newly generated public key.
     */
    public function generateApiKey(): array
    {
        $this->tokens()->delete();
        $sanctumTokenInstance = $this->createToken('client_api_token');
        $sanctumPlainTextToken = $sanctumTokenInstance->plainTextToken;
        $this->public_key = Str::random(30);
        $this->key_expires_at = now()->addDays(30);
        $this->saveQuietly();

        return [
            'public_key' => $this->public_key,
            'sanctum_token' => $sanctumPlainTextToken,
        ];
    }

    /**
     * Mendapatkan relasi ke model AnalyzeLogin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analyzelogins()
    {
        return $this->hasMany(AnalyzeLogin::class, 'client_id', 'client_id');
    }

    /**
     * Mendapatkan relasi ke model AnalyzeSecurityLog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analyzesecurity()
    {
        return $this->hasMany(AnalyzeSecurityLog::class, 'client_id', 'client_id');
    }

    /**
 * Menghapus semua data AnalyzeLogin dan AnalyzeSecurityLog milik user ini.
 *
 * @return void
 */
    public function resetAnalysisData(): void
    {
        $this->analyzelogins()->delete();
        $this->analyzesecurity()->delete();
    }

}

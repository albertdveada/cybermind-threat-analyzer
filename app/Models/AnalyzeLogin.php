<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalyzeLogin extends Model
{
    use HasFactory;
    protected $table = 'analyze_login';
    public $timestamps = true;
    protected $fillable = [
        'client_id',
        'ip_address',
        'country',
        'city',
        'username',
        'status',
        'user_agent',
        'device',
        'platform',
        'browser',
        'login_method',
        'session_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'client_id');
    }
}
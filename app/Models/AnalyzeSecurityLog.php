<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalyzeSecurityLog extends Model
{
    use HasFactory;
    protected $table = 'analyze_security';
    public $timestamps = true;
    protected $fillable = [
        'client_id',
        'status',
        'type',
        'source_ip',
        'country',
        'city',
        'security_level',
        'log_message',
        'source',
        'tag',
        'platform',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'client_id');
    }
}
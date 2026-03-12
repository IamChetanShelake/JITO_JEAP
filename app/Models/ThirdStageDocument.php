<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdStageDocument extends Model
{
    protected $guarded = [];

    protected $casts = [
        'documents' => 'array',
        'notification_sent_at' => 'datetime',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

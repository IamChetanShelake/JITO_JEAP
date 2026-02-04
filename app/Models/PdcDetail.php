<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdcDetail extends Model
{
    use HasFactory;



    protected $guarded = [];

    protected $casts = [
        'cheque_details' => 'array',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function processedBy()
    {
        return $this->hasOne(User::class, 'id', 'processed_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $connection = 'admin_panel';

    protected $fillable = [
        'pincode',
        'latitude',
        'longitude',
        'cached_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'cached_at' => 'datetime',
    ];

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class, 'chapter_pincodes');
    }
}

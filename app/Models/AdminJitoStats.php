<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminJitoStats extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_jito_stats';

    protected $fillable = [
        'number',
        'text',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'display_order' => 'integer',
    ];
}

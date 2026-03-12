<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyInstruction extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $table = 'key_instrctions';

    protected $fillable = [
        'icon',
        'icon_svg',
        'title',
        'description',
        'color',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}

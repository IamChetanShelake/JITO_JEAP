<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JeapWebsite extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_about_jeap_website';

    protected $fillable = [
        'title',
        'description',
        'small_titles',
        'small_descriptions',
        'image',
        'images',
        'display_order',
        'status',
    ];

    protected $casts = [
        'small_titles' => 'array',
        'small_descriptions' => 'array',
        'images' => 'array',
        'status' => 'boolean',
        'display_order' => 'integer',
    ];
}

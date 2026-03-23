<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAboutJitoWebsite extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_about_jito_website';

    protected $fillable = [
        'title',
        'paragraphs',
        'image',
        'number',
        'stat_text',
        'display_order',
        'status',
    ];

    protected $casts = [
        'paragraphs' => 'array',
        'status' => 'boolean',
        'display_order' => 'integer',
    ];
}

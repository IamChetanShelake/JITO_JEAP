<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminContact extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_contact_website';

    protected $fillable = [
        'title',
        'description',
        'small_titles',
        'small_descriptions',
        'is_active',
    ];

    protected $casts = [
        'small_titles' => 'array',
        'small_descriptions' => 'array',
        'is_active' => 'boolean',
    ];
}

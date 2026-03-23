<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityWebsite extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'universities_website_migration';

    protected $fillable = [
        'university_name',
        'university_type',
        'country',
        'city',
        'state',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}

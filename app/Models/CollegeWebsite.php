<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeWebsite extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'colleges_website';

    protected $fillable = [
        'college_name',
        'university_name',
        'college_type',
        'country',
        'state',
        'city',
        'courses',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'courses' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseWebsite extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'courses_website';

    protected $fillable = [
        'course_name',
        'duration',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}

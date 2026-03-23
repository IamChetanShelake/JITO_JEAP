<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTestimonial extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'our_testimonials';

    protected $fillable = [
        'title',
        'image',
        'about',
        'feedback',
        'name',
        'date',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'date' => 'date',
    ];
}
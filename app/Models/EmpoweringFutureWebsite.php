<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpoweringFutureWebsite extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'empowering_future_website';

    protected $fillable = [
        'title',
        'description',
        'image',
        'vision',
        'vision_description',
        'mission',
        'mission_description',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

}

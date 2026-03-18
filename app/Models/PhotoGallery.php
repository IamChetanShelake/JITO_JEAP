<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'photo_gallery';

    protected $fillable = [
        'images',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];


}

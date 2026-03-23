<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardOfDirectors extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_about_board_of_directors_website';

    protected $fillable = [
        'name',
        'post',
        'email',
        'image',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'display_order' => 'integer',
    ];
}

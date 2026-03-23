<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeDonorDetail extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'be_donor_website';

    protected $fillable = [
        'icon',
        'benefit',
        'description',
        'become_member_step',
        'what_to_do',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}

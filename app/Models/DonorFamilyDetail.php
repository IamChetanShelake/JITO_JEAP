<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorFamilyDetail extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $casts = [
        'children_details' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}

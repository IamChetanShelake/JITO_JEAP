<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorMembershipDetail extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $casts = [
        'payment_options' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}

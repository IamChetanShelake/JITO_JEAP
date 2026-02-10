<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorPaymentDetail extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $casts = [
        'payment_entries' => 'array',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorProfessionalDetail extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}

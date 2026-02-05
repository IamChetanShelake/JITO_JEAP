<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JitoJeapBank extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $fillable = [
        'account_name',
        'bank_name',
        'account_type',
        'account_number',
        'ifsc_code'
    ];
}

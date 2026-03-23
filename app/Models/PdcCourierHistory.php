<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdcCourierHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'action_at' => 'datetime',
        'data' => 'array',
    ];

    public function pdcDetail()
    {
        return $this->belongsTo(PdcDetail::class, 'pdc_detail_id');
    }

    public function actor()
    {
        return $this->belongsTo(AdminUser::class, 'action_by');
    }
}

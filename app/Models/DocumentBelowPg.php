<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentBelowPg extends Model
{
    protected $table = 'document_below_pgs';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

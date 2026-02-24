<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familydetail extends Model
{
    protected $fillable = [
        'donor_id',
        'spouse_title',
        'spouse_name',
        'spouse_birth_date',
        'spouse_blood_group',
        'jito_member',
        'number_of_kids',
        'children_details', // <--- MAKE SURE THIS IS HERE
    ];
    protected $casts = [
        'children_details' => 'array', // <--- THIS IS CRITICAL FOR SAVING JSON
        'spouse_birth_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}


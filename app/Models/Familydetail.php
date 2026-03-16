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
        'current_year_itr',
        'last_year_itr',
        'user_id',
        'number_family_members',
        'total_family_income',
        'total_students',
        'family_member_diksha',
        'diksha_member_name',
        'diksha_member_relation',
        'total_insurance_coverage',
        'total_premium_paid',
        'recent_electricity_amount',
        'total_monthly_emi',
        'mediclaim_insurance_amount',
        'additional_family_members',
        'paternal_uncle_name',
        'paternal_uncle_mobile',
        'paternal_uncle_email',
        'paternal_aunt_name',
        'paternal_aunt_mobile',
        'paternal_aunt_email',
        'maternal_uncle_name',
        'maternal_uncle_mobile',
        'maternal_uncle_email',
        'maternal_aunt_name',
        'maternal_aunt_mobile',
        'maternal_aunt_email',
        'submit_status',
        'admin_remark',
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

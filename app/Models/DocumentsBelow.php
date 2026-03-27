<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsBelow extends Model
{
    use HasFactory;

    protected $table = 'documents_below';

    protected $fillable = [
        'user_id',
        'status',
        'submit_status',
        'admin_remark',
        'ssc_cbse_icse_ib_igcse',
        'hsc_diploma_marksheet',
        'admission_letter_fees_structure',
        'pan_applicant',
        'aadhaar_applicant',
        'jain_sangh_certificate',
        'jito_group_recommendation',
        'electricity_bill',
        'aadhaar_father_mother',
        'pan_father_mother',
        'form16_salary_income_father',
        'bank_statement_father_12months',
        'student_bank_details_statement'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

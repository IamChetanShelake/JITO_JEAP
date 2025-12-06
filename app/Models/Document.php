<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'board',
        'board2',
        'graduation',
        'post_graduation',
        'fee_structure',
        'admission_letter',
        'statement',
        'visa',
        'passport',
        'applicant_aadhar',
        'applicant_pan',
        'birth_certificate',
        'electricity_bill',
        'father_itr',
        'father_balanceSheet_pr_lss_stmnt',
        'form16_salary_sleep',
        'father_mother_income',
        'loan_arrangement',
        'father_bank_stmnt',
        'mother_bank_stmnt',
        'student_main_bank_details',
        'jain_sangh_cert',
        'jatf_recommendation',
        'other_docs',
        'extra_curri',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

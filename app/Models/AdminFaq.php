<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFaq extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';
    protected $table = 'admin_faqs_website';

    protected $fillable = [
        'question',
        'answer',
        'question_hi',
        'answer_hi',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

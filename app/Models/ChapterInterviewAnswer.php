<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChapterInterviewAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'workflow_id',
        'question_no',
        'question_text',
        'answer_text',
        'answered_by',
    ];

    protected $casts = [
        'question_no' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(ApplicationWorkflowStatus::class, 'workflow_id');
    }
}

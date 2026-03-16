<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationWorkflowStatus extends Model
{
    protected $guarded = [];

    protected $casts = [
        'apex_1_updated_at' => 'datetime',
        'chapter_updated_at' => 'datetime',
        'working_committee_updated_at' => 'datetime',
        'apex_2_updated_at' => 'datetime',
        'third_stage_notification_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapterInterviewAnswers()
    {
        return $this->hasMany(ChapterInterviewAnswer::class, 'workflow_id');
    }
}

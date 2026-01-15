<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationWorkflowStatus extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapterInterviewAnswers()
    {
        return $this->hasMany(ChapterInterviewAnswer::class, 'workflow_id');
    }
}

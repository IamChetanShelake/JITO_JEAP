<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementImpact extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'achievement_impact';

    protected $fillable = [
        'description',
        'image',
        'numbers',
        'number_texts',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
        'numbers' => 'array',
        'number_texts' => 'array',
    ];

    /**
     * Get the numbers as an array
     */
    public function getNumbersArrayAttribute()
    {
        return json_decode($this->numbers, true) ?? [];
    }

    /**
     * Get the number texts as an array
     */
    public function getNumberTextsArrayAttribute()
    {
        return json_decode($this->number_texts, true) ?? [];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpoweringDream extends Model
{
    use HasFactory;
    
    protected $connection = 'admin_panel';
    protected $table = 'empowering_dreams';

    protected $fillable = [
        'title',
        'description',
        'vision',
        'vision_description',
        'mission',
        'mission_description',
        'features',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the features as an array
     */
    public function getFeaturesArrayAttribute()
    {
        return explode(',', $this->features);
    }

    /**
     * Set features as comma-separated string
     */
    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = implode(',', $value);
        } else {
            $this->attributes['features'] = $value;
        }
    }
}

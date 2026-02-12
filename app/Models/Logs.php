<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'admin_panel';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'process_type',
        'process_action',
        'process_description',
        'process_by_name',
        'process_by_role',
        'process_by_id',
        'module',
        'action_url',
        'old_values',
        'new_values',
        'additional_data',
        'process_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'additional_data' => 'array',
        'process_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the user that owns the log entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include logs for a specific user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include logs for a specific process type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $processType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForProcessType($query, $processType)
    {
        return $query->where('process_type', $processType);
    }

    /**
     * Scope a query to only include logs for a specific date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('process_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include logs processed by a specific user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $processById
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProcessedBy($query, $processById)
    {
        return $query->where('process_by_id', $processById);
    }
}

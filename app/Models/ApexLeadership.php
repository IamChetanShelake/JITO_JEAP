<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApexLeadership extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'admin_panel';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'apex_leadership';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'designation',
        'email',
        'contact',
        'status',
        'show_hide'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'show_hide' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

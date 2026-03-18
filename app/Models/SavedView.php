<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedView extends Model
{
    protected $connection = 'admin_panel';
    protected $guarded = [];

    protected $casts = [
        'columns_json' => 'array',
        'group_by_json' => 'array',
        'filters_json' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Chapter extends Authenticatable implements AuthenticatableContract
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
    protected $table = 'chapters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone_id',
        'chapter_head',
        'chapter_name',
        'city',
        'pincode',
        'state',
        'email',
        'contact',
        'password',
        'role',
        'status',
        'show_hide'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'show_hide' => 'boolean',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the zone that owns the chapter.
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the pincodes associated with the chapter.
     */
    public function pincodes()
    {
        return $this->belongsToMany(Pincode::class, 'chapter_pincodes');
    }
}

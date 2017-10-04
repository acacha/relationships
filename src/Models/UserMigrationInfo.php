<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMigrationInfo
 *
 * @package Acacha\Relationships\Models
 */
class UserMigrationInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'original_user_id'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = 'user_migration_info';
}

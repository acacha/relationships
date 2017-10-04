<?php

namespace Acacha\Relationships\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonMigrationInfo
 *
 * @package Acacha\Relationships\Models
 */
class PersonMigrationInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'original_person_id'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = 'person_migration_info';
}

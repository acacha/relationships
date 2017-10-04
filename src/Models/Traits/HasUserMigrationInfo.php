<?php

namespace Acacha\Relationships\Models\Traits;

use Acacha\Relationships\Models\UserMigrationInfo;

/**
 * Class HasUserMigrationInfo.
 *
 * @package Acacha\Relationships\Models\Traits
 */
trait HasUserMigrationInfo
{
    /**
     * Get the phone record associated with the user.
     */
    public function migration_info()
    {
        return $this->hasOne(UserMigrationInfo::class);
    }
}
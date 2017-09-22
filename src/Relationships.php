<?php

namespace Acacha\Relationships;

/**
 * Class RelationsShips.
 *
 * @package Acacha\Relationships
 */
class Relationships
{
    /**
     * Views copy path.
     *
     * @return array
     */
    public function views()
    {
        return [
            RELATIONSHIPS_PATH.'/resources/views/example.php' =>
                resource_path('views/vendor/acacha_relationships/example.blade.php')
        ];
    }
}
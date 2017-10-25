<?php

namespace Acacha\Relationships\Faker\Providers;

use Faker\Provider\Base;

/**
 * Class CatalanLocation.
 *
 * @package Acacha\Relationships\Faker\Providers
 */
class CatalanLocation extends Base
{
    protected $locations = [
        43500 => 'Tortosa',
        43895 => "L'Ampolla",
        43870 => 'Amposta',
        43580 => 'Deltebre',
        43570 => 'Santa Barbara',
        43896 => "L'Aldea",
        43591 => 'Aldover',
        43512 => 'Benifallet',
        43894 => 'Camarles',
        43592 => 'Xerta'
    ];

    /**
     * location provider
     */
    public function location()
    {
        $postalCode = array_rand($this->locations);
        return ['postalCode' => $postalCode , 'name' => $this->locations[$postalCode]];
    }
}
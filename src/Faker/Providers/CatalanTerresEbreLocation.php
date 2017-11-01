<?php

namespace Acacha\Relationships\Faker\Providers;

use Faker\Provider\Base;

/**
 * Class CatalanLocation.
 *
 * @package Acacha\Relationships\Faker\Providers
 */
class CatalanTerresEbreLocation extends Base
{
    protected $locations = [
        43530 => 'Alcanar',
        43597 => 'Arnes',
        43791 => 'Asco',
        43896 => "L'Aldea",
        43591 => 'Aldover',
        43528 => 'Alfara de Carles',
        43860 => "L'Ametlla de Mar",
        43895 => "L'Ampolla",
        43870 => 'Amposta',
        43786 => 'Batea',
        43512 => 'Benifallet',
        43747 => 'Benissanet',
        43785 => 'Bot',
        43894 => 'Camarles',
        43787 => 'Caseres',
        43784 => "Corbera d'Ebre",
        43580 => 'Deltebre',
        43781 => 'La Fatarella',
        43750 => 'Flix',
        43558 => 'Freginals',
        43515 => 'La Galera',
        43780 => 'Gandesa',
        43749 => 'Garcia',
        43748 => 'Ginestar',
        43516 => 'Godall',
        43596 => 'Horta de San Joan',
        43514 => 'Mas de Barberans',
        43878 => 'Masdenverge',
        43747 => 'Miravet',
        43740 => "Mora d'Ebre",
        43770 => "Mora la Nova",
        43593 => 'Paüls',
        43370 => "La Palma d'Ebre",
        43519 => 'El Perello',
        43594 => 'El Pinell de Brai',
        43783 => 'La Pobla de Massaluca',
        43595 => 'Prat de Compte',
        43513 => 'Rasquera',
        43790 => "Riba Roja d'Ebre",
        43520 => 'Roquetes',
        43540 => 'Sant Carles de la Ràpita',
        43877 => "Sant Jaume d'Enveja",
        43570 => 'Santa Barbara',
        43560 => 'La Senia',
        43511 => 'Tivenys',
        43746 => 'Tivissa',
        43792 => "La Torre de l'Espanyol",
        43500 => 'Tortosa',
        43550 => 'Ulldecona',
        43782 => 'Vilalba dels Arcs',
        43792 => 'Vinebre',
        43592 => 'Xerta',
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
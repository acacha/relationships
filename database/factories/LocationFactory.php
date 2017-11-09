<?php

use Acacha\Relationships\Models\Location;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    $faker->addProvider(new \Acacha\Relationships\Faker\Providers\CatalanTerresEbreLocation($faker));

    $location = $faker->unique()->location;

    return [
        'name' => $location['name'],
        'postalCode' => $location['postalCode']
    ];
});

$factory->state(Location::class,'en', function (Faker $faker) {
    return [
        'name' => $faker->city,
        'postalcode' => $faker->postcode
    ];
});

$factory->state(Location::class,'es', function (Faker $faker) {
    $faker = Factory::create('es_ES');

    return [
        'name' => $faker->city,
        'postalcode' => $faker->postcode
    ];
});


<?php

use Acacha\Relationships\Models\Identifier;
use Acacha\Relationships\Models\IdentifierType;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Identifier::class, function (Faker $faker) {
    return [
        'value' => $faker->unique()->numberBetween(0,99999),
        'type_id' => 1
    ];
});

$factory->state(Identifier::class, 'nif', function ($faker) {
    $faker = Factory::create('es_ES');
    return [
        'value' => $faker->unique()->dni,
        'type_id' => 1
    ];
});





<?php

use Acacha\Relationships\Models\IdentifierType;
use Faker\Generator as Faker;

$factory->define(IdentifierType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});

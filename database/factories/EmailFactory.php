<?php

use Acacha\Relationships\Models\Email;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
      'value' => $faker->email
    ];
});


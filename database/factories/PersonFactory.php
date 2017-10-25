<?php

use Acacha\Relationships\Models\Location;
use Acacha\Relationships\Models\Person;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {

    $gender = $faker->randomElements(['male', 'female']);
    $givenName = $faker->firstName($gender);
    $surname1 = $faker->lastName;

    return [
        'givenName' => $givenName,
        'surname1' => $surname1,
        'surname2' => '',
        'birthdate' => $faker->date,
        'birthplace_id' => factory(Location::class)->create()->id,
        'gender' => $gender[0],
        'civil_status' => $faker->randomElements(
            ['Soltero/a','Casado/a','Separado/a','Divorciado/a','Viudo/a']
        )[0],
        'notes' => $faker->sentence
    ];
});

$factory->state(Person::class, 'es', function ($faker) {
    $faker = Factory::create('es_ES');

    $gender = $faker->randomElements(['male', 'female']);
    $givenName = $faker->firstName($gender);
    $surname1 = $faker->lastName;
    $surname2 = $faker->lastName;


    return [
        'name' => $givenName . ' ' . $surname1 . ' ' . $surname2,
        'givenName' => $givenName,
        'surname' => $surname1,
        'surname1' => $surname1,
        'surname2' => $surname2,
        'birthdate' => $faker->date,
        'birthplace_id' => factory(Location::class)->create()->id,
        'gender' => $gender,
        'civil_status' => $faker->randomElements(
            ['Soltero/a','Casado/a','Separado/a','Divorciado/a','Viudo/a']
        ),
        'notes' => $faker->sentence
    ];
});

$factory->state(Person::class, 'ca', function ($faker) {

    $faker = Factory::create('es_ES');

    $gender = $faker->randomElements(['male', 'female']);
    $givenName = $faker->firstName($gender);
    $surname1 = $faker->lastName;
    $surname2 = $faker->lastName;

    $faker->addProvider(new \Acacha\Relationships\Faker\Providers\CatalanLocation($faker));

    $location = factory(Location::class)->create();

    return [
        'givenName' => $givenName,
        'surname1' => $surname1,
        'surname2' => $surname2,
        'birthdate' => Carbon::createFromTimestamp($faker->dateTimeInInterval('-80 years', '-14 years')->getTimestamp())->toDateString(),
        'birthplace_id' => $location->id,
        'gender' => $gender[0],
        'state' => 'valid'
    ];
});



<?php

use Acacha\Relationships\Models\Person;
use Acacha\Relationships\Models\Photo;
use App\User;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {
    if ( ! array_key_exists('person_id',$attributes = func_get_arg(1))) {
        $user = factory(User::class)->create();
        $person = factory(Person::class)->create();
        $user->persons()->attach($person->id);
    } else {
        $person = Person::findOrFail($attributes['person_id']);
    }

    return [
      'storage' => 'local',
      'origin' => $faker->unique()->word . '.png',
      'path' => "user_photos/" . str_random(32) . '-' . $person->id . '-' . snake_case($person->name) . '.png' ,
      'person_id' => $person->id
    ];
});


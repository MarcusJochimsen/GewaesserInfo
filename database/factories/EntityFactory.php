<?php

namespace Database\Factories;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entity;
use Faker\Generator as Faker;

$factory->define(Entity::class, function (Faker $faker) {
    return [
        'user_id' => $faker->uuid
    ];
});

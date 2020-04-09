<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Division;
use Faker\Generator as Faker;

$factory->define(Division::class, function (Faker $faker) {
    return [
        'name' => $faker->company
    ];
});

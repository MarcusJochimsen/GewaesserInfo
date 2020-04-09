<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tide;
use Faker\Generator as Faker;

$factory->define(Tide::class, function (Faker $faker) {
    return [
        'label' => $faker->word
    ];
});

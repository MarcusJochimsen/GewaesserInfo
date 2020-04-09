<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Current;
use Faker\Generator as Faker;

$factory->define(Current::class, function (Faker $faker) {
    return [
        'label' => $faker->word
    ];
});

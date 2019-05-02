<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'profile_id' => $faker->numberBetween($min = 11, $max = 40),
        'item_id' => $faker->numberBetween($min = 1, $max = 44),
    ];
});

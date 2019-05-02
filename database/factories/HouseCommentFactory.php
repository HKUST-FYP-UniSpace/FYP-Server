<?php

use Faker\Generator as Faker;

$factory->define(App\HouseComment::class, function (Faker $faker) {
    return [
        'house_id' => $faker->numberBetween($min = 1, $max = 16),
        'tenant_id' => $faker->numberBetween($min = 11, $max = 30),	// tenant only
        'details' => $faker->realText(),
    ];
});

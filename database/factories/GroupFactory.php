<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
	$faker->addProvider(new Bluemmb\Faker\PicsumPhotosProvider($faker));

    return [
        'title' => $faker->streetName,
        'image_url' => $faker->imageUrl(),
        'leader_user_id' => $faker->numberBetween($min = 11, $max = 30),    // tenant only
        'max_ppl' => $faker->numberBetween($min = 2, $max = 4),
        'description' => $faker->realText(),
        'duration' => $faker->numberBetween($min = 1, $max = 4),
        'is_rent' => $faker->numberBetween($min = 0, $max = 1),
        'house_id' => $faker->numberBetween($min = 1, $max = 16),
    ];
});

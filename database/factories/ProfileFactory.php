<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Profile::class, function (Faker $faker) {
	$faker->addProvider(new Bluemmb\Faker\PicsumPhotosProvider($faker));

    return [
        'gender' => $faker->randomElement(['M', 'F']),
        'contact' => $faker->numberBetween($min = 90000000, $max = 99999999),
        'self_intro' => $faker->realText() ,
        'icon_url' => $faker->imageUrl(),
        'user_id' => factory('App\User')->create()->id,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});

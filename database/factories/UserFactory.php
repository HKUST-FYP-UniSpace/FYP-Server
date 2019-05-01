<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        // 'name' => $faker->name,
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        // 'remember_token' => str_random(10),
        'username' => $faker->firstName,
        'name' => $faker->name,
        'email' => $faker->freeEmail,
        'password' => '$2y$10$C0.X5sRTqGNPXl3YlGiad.WX2TiWevIE3EnkEAAQ0jH/6YK5eOlEa',
        'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsImlzcyI6Imh0dHA6Ly9lYzItMTgtMjE5LTctMTM1LnVzLWVhc3QtMi5jb21wdXRlLmFtYXpvbmF3cy5jb20vYXBpL3VzZXJzL3JlZ2lzdGVyIiwiaWF0IjoxNTU0MjgyNjQ1LCJleHAiOjE1NTQyODYyNDUsIm5iZiI6MTU1NDI4MjY0NSwianRpIjoib1p6cVozemlyTnZJSmc4VyJ9.3EpHOQx4pd6K3GuPYU9fUAuvgPCeevsCU4RS20LUBk8',
        'is_verified' => 1,
        'is_deleted' => 0,
        'verification_code' => $faker->randomNumber($nbDigits = 6, $strict = false),
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});

<?php

use Illuminate\Database\Seeder;

class UsersAndProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Profile', 20)->create();
    }
}

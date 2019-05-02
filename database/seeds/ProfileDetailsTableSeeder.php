<?php

use Illuminate\Database\Seeder;

class ProfileDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Group', 30)->create();
    }
}

<?php

use Illuminate\Database\Seeder;

class HouseCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\HouseComment', 50)->create();
    }
}

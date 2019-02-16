<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('districts')->insert([
        	['name' => 'Islands',],
        	['name' => 'Kwai Tsing'],
        	['name' => 'North'],
        	['name' => 'Sai Kung'],
        	['name' => 'Shatin'],
        	['name' => 'Tai Po'],
        	['name' => 'Tsuen Wan'],
        	['name' => 'Tuen Mun'],
        	['name' => 'Yuen Long'],
        	['name' => 'Kowloon City'],
        	['name' => 'Kwun Tong'],
        	['name' => 'Sham Shui Po'],
        	['name' => 'Wong Tai Sin'],
        	['name' => 'Yau Tsim Mong'],
        	['name' => 'Central & Western'],
        	['name' => 'Eastern'],
        	['name' => 'Southern'],
        	['name' => 'Wan Chai'],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Triasrahman\JSONSeeder\JSONSeeder;

class HousesTableSeeder extends Seeder
{
	use JSONSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->JSONseed('houses', '\App\House', [
        	'detail' => [
        		'table' => 'house_details',
        		'class' => '\App\HouseDetail',
        		'foreign_key' => 'house_id',
        		'flush' => true,
        	],
        	
        	'image' => [
        		'table' => 'house_images',
        		'class' => '\App\HouseImage',
        		'foreign_key' => 'house_id',
        		'flush' => true,
        	],
        	
        ]);
    }
}

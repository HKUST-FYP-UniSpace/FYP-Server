<?php

use Illuminate\Database\Seeder;

class HouseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('house_statuses')->insert([
          //id: 1
        	['status' => 'hide'],	// soft delete

          //id: 2
        	['status' => 'reveal'],	// available or show

          //id: 3
        	['status' => 'archive'],

          //id: 4
        	['status' => 'rent'],
        ]);
    }
}

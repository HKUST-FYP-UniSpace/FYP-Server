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
        	['status' => 'hide'],	// soft delete
        	['status' => 'reveal'],	// available or show
        	['status' => 'archive'],
        	['status' => 'rent'],
        ]);
    }
}

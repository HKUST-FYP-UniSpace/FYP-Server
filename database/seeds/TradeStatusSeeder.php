<?php

use Illuminate\Database\Seeder;

class TradeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trade_statuses')->insert([
          // id: 1
        	['status' => 'reveal'],	// available or show
          // id: 2
        	['status' => 'archive'],
          //id: 3
        	['status' => 'sold'],
        ]);
    }
}

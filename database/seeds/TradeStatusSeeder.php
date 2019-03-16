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
        	['status' => 'reveal'],	// available or show
        	['status' => 'archive'],
        	['status' => 'sold'],
        ]);
    }
}

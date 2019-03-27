<?php

use Illuminate\Database\Seeder;

class TradeConditionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trade_condition_types')->insert([
          // id: 1
        	['type' => 'Perfect'],
          // id: 2
        	['type' => 'Almost Perfect'],
          // id: 3
        	['type' => 'Okay'],
          // id: 4
        	['type' => 'Worn']
        ]);
    }
}

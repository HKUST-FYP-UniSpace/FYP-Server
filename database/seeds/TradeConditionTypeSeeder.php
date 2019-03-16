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
        	['type' => 'Perfect'],
        	['type' => 'Almost Perfect'],
        	['type' => 'Okay'],
        	['type' => 'Worn'],
        ]);
    }
}

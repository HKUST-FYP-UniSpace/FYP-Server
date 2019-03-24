<?php

use Illuminate\Database\Seeder;

class TradeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trade_categories')->insert([
        	['category' => 'Electronics'],
        	['category' => 'Furniture'],
        	['category' => 'Health & Beauty'],
        	['category' => 'Toys & Games'],
        	['category' => 'Kitchenwares'],
        	['category' => 'Books & Stationery'],
        	['category' => 'Fashion'],
        	['category' => 'Sports'],
        ]);
    }
}

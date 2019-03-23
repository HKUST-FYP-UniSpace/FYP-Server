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
          // id: 1
        	['category' => 'Electronics'],
          // id: 2
        	['category' => 'Furniture'],
          // id: 3
        	['category' => 'Health & Beauty'],
          // id: 4
        	['category' => 'Toys & Games'],
          // id: 5
        	['category' => 'Kitchenwares'],
          // id: 6
        	['category' => 'Books & Stationery'],
          // id: 7
        	['category' => 'Fashion'],
          // id: 8
        	['category' => 'Sports'],
        ]);
    }
}

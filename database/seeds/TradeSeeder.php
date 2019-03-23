<?php

use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trades')->insert([
          [
            'title'=>'Trade 1',
            'price'=> 100,
            'description'=>'testing trade item 1',
            'quantity'=>1,
            'trade_category_id'=>1, //Electronics
            'trade_condition_type_id'=>1, //Perfect
            'trade_status_id'=>1,
            'is_deleted'=>0,
            'user_id'=>1
          ],

          [
            'title'=>'Trade 2',
            'price'=>200,
            'description'=>'testing trade item 2',
            'quantity'=>2,
            'trade_category_id'=>2, //Furniture
            'trade_condition_type_id'=>2, //Almost Perfect
            'trade_status_id'=>1,
            'is_deleted'=>0,
            'user_id'=>2
          ],

          [
            'title'=>'Trade 3',
            'price'=> 300,
            'description'=>'testing trade item 3',
            'quantity'=>3,
            'trade_category_id'=>3, //Health & Beauty
            'trade_condition_type_id'=>3, //Okay
            'trade_status_id'=>1,
            'is_deleted'=>0,
            'user_id'=>3
          ],

          [
            'title'=>'Trade 4',
            'price'=> 400,
            'description'=>'testing trade item 4',
            'quantity'=>4,
            'trade_category_id'=>4, //Toys & Games
            'trade_condition_type_id'=>4, //Worn
            'trade_status_id'=>1,
            'is_deleted'=>0,
            'user_id'=>4
          ]
        ]);
    }
}

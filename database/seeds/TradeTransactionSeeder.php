<?php

use Illuminate\Database\Seeder;

class TradeTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trade_transactions')->insert([
          [
            'trade_id'=>1,
            'user_id'=>2,
          ],
          [
            'trade_id'=>2,
            'user_id'=>3,
          ],
          [
            'trade_id'=>3,
            'user_id'=>4,
          ],
          [
            'trade_id'=>4,
            'user_id'=>2,
          ]

        ]);
    }
}

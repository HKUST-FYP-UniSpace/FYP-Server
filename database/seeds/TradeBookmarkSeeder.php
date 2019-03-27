<?php

use Illuminate\Database\Seeder;

class TradeBookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trade_bookmarks')->insert([
          // user 1 bookmarked trade 1, 2, 3
          [
            'trade_id'=>1,
            'user_id'=>1
          ],

          [
            'trade_id'=>2,
            'user_id'=>1
          ],

          [
            'trade_id'=>3,
            'user_id'=>1
          ],

          // user 2 bookmarked trade 1, 2
          [
            'trade_id'=>1,
            'user_id'=>2
          ],

          [
            'trade_id'=>2,
            'user_id'=>2
          ],

          //user 3 bookmarked trade 3
          [
            'trade_id'=>4,
            'user_id'=>3
          ],

          // trade 4 is not bookmarked by any users

        ]);

    }
}

<?php

use Illuminate\Database\Seeder;

class HousePostBookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('house_post_bookmarks')->insert([
          // tenant 1
          [
            'tenant_id'=>1,
            'house_id'=>1
          ],
          [
            'tenant_id'=>1,
            'house_id'=>2
          ],
          [
            'tenant_id'=>1,
            'house_id'=>3
          ],


          // tenant 2
          [
            'tenant_id'=>2,
            'house_id'=>2
          ],
          [
            'tenant_id'=>2,
            'house_id'=>4
          ],


          // tenant 3
          [
            'tenant_id'=>3,
            'house_id'=>3
          ]
        ]);
    }
}

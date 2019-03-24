<?php

use Illuminate\Database\Seeder;

class GroupDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('group_details')->insert([
          [
            'member_user_id'=>1,
            'status'=>1,
            'group_id'=>1
          ],
          [
            'member_user_id'=>2,
            'status'=>1,
            'group_id'=>2
          ],
          [
            'member_user_id'=>3,
            'status'=>1,
            'group_id'=>3
          ],
          [
            'member_user_id'=>4,
            'status'=>1,
            'group_id'=>4
          ]
        ]);
    }
}

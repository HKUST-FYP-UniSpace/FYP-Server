<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('groups')->insert([
          [
            'title'=>'Group 1',
            'image_url'=>'group1.jpg',
            'leader_user_id'=>1,
            'max_ppl'=>1,
            'description'=>'1 people group',
            'duration'=>1,
            'is_rent'=>0,
            'house_id'=>1
          ],
          [
            'title'=>'Group 2',
            'image_url'=>'group2.jpg',
            'leader_user_id'=>2,
            'max_ppl'=>2,
            'description'=>'2 people group',
            'duration'=>2,
            'is_rent'=>0,
            'house_id'=>2
          ],
          [
            'title'=>'Group 3',
            'image_url'=>'group3.jpg',
            'leader_user_id'=>3,
            'max_ppl'=>3,
            'description'=>'3 people group',
            'duration'=>3,
            'is_rent'=>1, // This is a rent house
            'house_id'=>3
          ],
          [
            'title'=>'Group 4',
            'image_url'=>'group4.jpg',
            'leader_user_id'=>4,
            'max_ppl'=>4,
            'description'=>'4 people group',
            'duration'=>4,
            'is_rent'=>0,
            'house_id'=>4
          ]
        ]);
    }
}

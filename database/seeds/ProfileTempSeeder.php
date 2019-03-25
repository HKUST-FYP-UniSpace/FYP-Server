<?php

use Illuminate\Database\Seeder;

class ProfileTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('profiles')->insert([
          [
            'gender'=>'M',
            'name'=>'KN',
            'contact'=>'98761001',
            'self_intro'=>'handsome boy 1',
            'icon_url'=>'profileURL1.jpg',
            'user_id'=>1
          ],
          [
            'gender'=>'M',
            'name'=>'KL',
            'contact'=>'98761002',
            'self_intro'=>'handsome boy 2',
            'icon_url'=>'profileURL2.jpg',
            'user_id'=>2
          ],
          [
            'gender'=>'F',
            'name'=>'GK',
            'contact'=>'98761003',
            'self_intro'=>'beautiful girl 3',
            'icon_url'=>'profileURL3.jpg',
            'user_id'=>3
          ],
          [
            'gender'=>'F',
            'name'=>'HC',
            'contact'=>'98761004',
            'self_intro'=>'beautiful girl 4',
            'icon_url'=>'profileURL4.jpg',
            'user_id'=>4
          ]
        ]);
    }
}

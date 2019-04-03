<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogs')->insert([
          [
            'title'=>'Blog 1',
            'subtitle'=>'subtitle 1',
            'detail'=>'travel is good',
            'status'=>1,
            'admin_id'=>1,
            'image_url'=>'blog_1.jpg'
          ],
          [
            'title'=>'Blog 2',
            'subtitle'=>'subtitle 2',
            'detail'=>'travel is good',
            'status'=>2,
            'admin_id'=>2,
            'image_url'=>'blog_2.jpg'
          ],
          [
            'title'=>'Blog 3',
            'subtitle'=>'subtitle 3',
            'detail'=>'travel is good',
            'status'=>3,
            'admin_id'=>3,
            'image_url'=>'blog_3.jpg'
          ],
          [
            'title'=>'Blog 4',
            'subtitle'=>'subtitle 4',
            'detail'=>'travel is good',
            'status'=>4,
            'admin_id'=>4,
            'image_url'=>'blog_4.jpg'
          ]
        ]);
    }
}

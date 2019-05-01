<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogs')->insert([
        	'title' => 'Welcome to UniSpace!',
        	'subtitle' => 'Your Greatest House Finder App',
        	'detail' => 'Welcome to UniSpace! In here, you can an apartment which suits you most!',
        	'status' => 0,
        	'admin_id' => 1,
        	'image_url' => '',
        	'is_deleted' => 0,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

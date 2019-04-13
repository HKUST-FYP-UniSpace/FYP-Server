<?php

use Illuminate\Database\Seeder;

class ChatroomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chatroom_types')->insert([
			// id: 1
        	['type' => 'Owner'],
			// id: 2
			['type' => 'Team'],
			//id: 3
        	['type' => 'Trade'],
			//id: 4
			['type' => 'Request'],
			//id: 5
			['type' => 'Admin'],
        ]);
    }
}

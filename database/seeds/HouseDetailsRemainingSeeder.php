<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HouseDetailsRemainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('house_details')->insert([
        	[
        		'house_id' => 3,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 4,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 5,
        		'toilet' => 1,
        		'bed' => 3,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 6,
        		'toilet' => 1,
        		'bed' => 3,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 8,
        		'toilet' => 1,
        		'bed' => 1,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 9,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 10,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 11,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 1,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 13,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 2,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 14,
        		'toilet' => 2,
        		'bed' => 3,
        		'room' => 2,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 15,
        		'toilet' => 2,
        		'bed' => 3,
        		'room' => 2,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        	[
        		'house_id' => 16,
        		'toilet' => 1,
        		'bed' => 2,
        		'room' => 2,
        		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        	],
        ]);
    }
}

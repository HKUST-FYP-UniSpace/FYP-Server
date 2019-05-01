<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
        	'name' => 'Master Admin',
        	'password' => '$2y$10$C0.X5sRTqGNPXl3YlGiad.WX2TiWevIE3EnkEAAQ0jH/6YK5eOlEa',
        	'email' => 'admin@unispace.com',
        	'is_deleted' => 0,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}

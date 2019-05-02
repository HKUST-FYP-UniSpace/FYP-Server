<?php

use Illuminate\Database\Seeder;

class OwnerTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('owners')->insert([
          'user_id' => 4
        ]);
    }
}

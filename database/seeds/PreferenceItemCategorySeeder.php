<?php

use Illuminate\Database\Seeder;

class PreferenceItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('preference_item_categories')->insert([
        	['category' => 'gender',],
        	['category' => 'petFree'],
        	['category' => 'timeInHouse'],
        	['category' => 'personalities'],
        	['category' => 'interests'],
        ]);
    }
}

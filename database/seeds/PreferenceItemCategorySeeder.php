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
        	['category' => 'Gender',],
        	['category' => 'Pet Free'],
        	['category' => 'Time staying in the Apartment'],
        	['category' => 'Personalities'],
        	['category' => 'Interests'],
        ]);
    }
}

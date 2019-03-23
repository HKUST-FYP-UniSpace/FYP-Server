<?php

use Illuminate\Database\Seeder;

class HouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // All houses are set to be revealed by default
        DB::table('houses')->insert([
        	[
            'title'=>'1st House Title',
            'subtitle'=>'1st house subtitle',
            'type'=>'type 1',
            'size'=>'100.0',
            'address'=>'HKUST, Clear Water Bay',
            'district_id'=>1,
            'description'=>'near ust',
            'max_ppl'=>1,
            'price'=>10000,
            'status'=>2,
            'owner_id'=>1,
            'is_deleted'=>0
          ],
          [
            'title'=>'2nd House Title',
            'subtitle'=>'2nd house subtitle',
            'type'=>'type 2',
            'size'=>'200.0',
            'address'=>'City U, Kowloon Tong',
            'district_id'=>2,
            'description'=>'near city',
            'max_ppl'=>2,
            'price'=>20000,
            'status'=>2,
            'owner_id'=>2,
            'is_deleted'=>0
          ],
          [
            'title'=>'3rd House Title',
            'subtitle'=>'3rd house subtitle',
            'type'=>'type 3',
            'size'=>'300.0',
            'address'=>'HKU, Kennedy Town',
            'district_id'=>3,
            'description'=>'near hku',
            'max_ppl'=>3,
            'price'=>30000,
            'status'=>2,
            'owner_id'=>3,
            'is_deleted'=>0
          ],
          [
            'title'=>'4th House Title',
            'subtitle'=>'4th house subtitle',
            'type'=>'type 4',
            'size'=>'400.0',
            'address'=>'Poly U, Hung Hom',
            'district_id'=>4,
            'description'=>'near polyu',
            'max_ppl'=>4,
            'price'=>40000,
            'status'=>2,
            'owner_id'=>3,
            'is_deleted'=>0
          ]
        ]);
    }
}

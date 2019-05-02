<?php

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('reviews')->insert([
          // house 1
          [
            'details'=>'Review of house 1 by tenant 1',
            'tenant_id'=>1,
            'value'=>5,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>4,
            'accuracy'=>5,
            'communication'=>4,
            'house_id'=>1
          ],
          [
            'details'=>'Review of house 1 by tenant 2',
            'tenant_id'=>2,
            'value'=>5,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>3,
            'accuracy'=>5,
            'communication'=>3,
            'house_id'=>1
          ],
          [
            'details'=>'Review of house 1 by tenant 3',
            'tenant_id'=>3,
            'value'=>4,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>4,
            'accuracy'=>4,
            'communication'=>2,
            'house_id'=>1
          ],


          //house 2
          [
            'details'=>'Review of house 2 by tenant 1',
            'tenant_id'=>1,
            'value'=>5,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>5,
            'accuracy'=>3,
            'communication'=>5,
            'house_id'=>2
          ],
          [
            'details'=>'Review of house 2 by tenant 2',
            'tenant_id'=>2,
            'value'=>3,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>3,
            'accuracy'=>4,
            'communication'=>5,
            'house_id'=>2
          ],

          //house 3
          [
            'details'=>'Review of house 3 by tenant 1',
            'tenant_id'=>1,
            'value'=>4,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>4,
            'accuracy'=>4,
            'communication'=>4,
            'house_id'=>4
          ],
          [
            'details'=>'Review of house 3 by tenant 3',
            'tenant_id'=>3,
            'value'=>5,
            //'cleanliness'=>5,//currently a typo in the migration
            'cleaniness'=>4,
            'accuracy'=>5,
            'communication'=>5,
            'house_id'=>3
          ]

        ]);
    }
}

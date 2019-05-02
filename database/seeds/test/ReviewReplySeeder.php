<?php

use Illuminate\Database\Seeder;

class ReviewReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('review_replies')->insert([
          [
            'review_id'=>1,
            'owner_id'=>4,
            'details'=>'Test Review Reply 1'
          ],
          [
            'review_id'=>2,
            'owner_id'=>4,
            'details'=>'Test Review Reply 2'
          ],
          [
            'review_id'=>3,
            'owner_id'=>4,
            'details'=>'Test Review Reply 3'
          ],
          [
            'review_id'=>4,
            'owner_id'=>4,
            'details'=>'Test Review Reply 4'
          ]
        ]);
    }
}

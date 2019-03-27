<?php

use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user_id in migration to be changed to group_id
        DB::table('preferences')->insert([
          // Group 1
          [
            'item_id'=>1, //Gender: Boys only
            'group_id'=>1
          ],
          [
            'item_id'=>4, //Pet free: TRUE
            'group_id'=>1
          ],
          [
            'item_id'=>6, //Time stay in apartment: Very Often
            'group_id'=>1
          ],
          [
            'item_id'=>9, //Personalities: Adaptable
            'group_id'=>1
          ],
          [
            'item_id'=>39, //Interest: Music
            'group_id'=>1
          ],


          // Group 2
          [
            'item_id'=>2, //Gender: Girls only
            'group_id'=>2
          ],
          [
            'item_id'=>5, //Pet free: FALSE
            'group_id'=>2
          ],
          [
            'item_id'=>7, //Time stay in apartment: Sometimes
            'group_id'=>2
          ],
          [
            'item_id'=>10, //Personalities: Adventurous
            'group_id'=>2
          ],
          [
            'item_id'=>40, //Interest: Sports
            'group_id'=>2
          ],


          // Group 3
          [
            'item_id'=>3, //Gender: No preference
            'group_id'=>3
          ],
          [
            'item_id'=>4, //Pet free: TRUE
            'group_id'=>3
          ],
          [
            'item_id'=>8, //Time stay in apartment: Rarely
            'group_id'=>3
          ],
          [
            'item_id'=>11, //Personalities: Affectionate
            'group_id'=>3
          ],
          [
            'item_id'=>41, //Interest: Video Games
            'group_id'=>3
          ],


          // Group 4
          [
            'item_id'=>1, //Gender: Boys only
            'group_id'=>4
          ],
          [
            'item_id'=>5, //Pet free: FALSE
            'group_id'=>4
          ],
          [
            'item_id'=>7, //Time stay in apartment: Sometimes
            'group_id'=>4
          ],
          [
            'item_id'=>12, //Personalities: Ambitious
            'group_id'=>4
          ],
          [
            'item_id'=>42, //Interest: Board Games
            'group_id'=>4
          ]


        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PreferenceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('preference_items')->insert([
          //id: 1
          [
        		'name' => 'M',
        		'category_id' => '1',	// Gender
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 2
        	[
        		'name' => 'F',
        		'category_id' => '1',	// Gender
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 3
        	[
        		'name' => 'Nil',
        		'category_id' => '1',	// Gender
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 4
        	[
        		'name' => 'true',
        		'category_id' => '2',	// Pet Free
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 5
        	[
        		'name' => 'false',
        		'category_id' => '2',	// Pet Free
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 6
        	[
        		'name' => 'Very Often',
        		'category_id' => '3',	// Time staying in the Apartment
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 7
        	[
        		'name' => 'Sometimes',
        		'category_id' => '3',	// Time staying in the Apartment
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 8
        	[
        		'name' => 'Rarely',
        		'category_id' => '3',	// Time staying in the Apartment
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
        	// --------- Personalities ---------
          //id: 9
        	[
        		'name' => 'Adaptable',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 10
        	[
        		'name' => 'Adventurous',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 11
        	[
        		'name' => 'Affectionate',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 12
        	[
        		'name' => 'Ambitious',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 13
        	[
        		'name' => 'Amiable',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 14
        	[
        		'name' => 'Compassionate',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 15
        	[
        		'name' => 'Considerate',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 16
        	[
        		'name' => 'Courageous',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 17
        	[
        		'name' => 'Courteous',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 18
        	[
        		'name' => 'Diligent',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 19
        	[
        		'name' => 'Empathetic',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 20
        	[
        		'name' => 'Exuberant',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 21
        	[
        		'name' => 'Frank',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 22
        	[
        		'name' => 'Generous',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 23
        	[
        		'name' => 'Gregarious',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 24
        	[
        		'name' => 'Impartial',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 25
        	[
        		'name' => 'Intuitive',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 26
        	[
        		'name' => 'Inventive',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 27
        	[
        		'name' => 'Passionate',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 28
        	[
        		'name' => 'Persistent',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 29
        	[
        		'name' => 'Philosophical',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 30
        	[
        		'name' => 'Practical',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 31
        	[
        		'name' => 'Rational',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 32
        	[
        		'name' => 'Reliable',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 33
        	[
        		'name' => 'Resourceful',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 34
        	[
        		'name' => 'Sensible',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 35
        	[
        		'name' => 'Sincere',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 36
        	[
        		'name' => 'Sympathetic',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 37
        	[
        		'name' => 'Unassuming',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 38
        	[
        		'name' => 'Witty',
        		'category_id' => '4',	// Personalities
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
        	// --------- Interests ---------
          //id: 39
        	[
        		'name' => 'Music',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 40
        	[
        		'name' => 'Sports',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 41
        	[
        		'name' => 'Video Games',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 42
        	[
        		'name' => 'Board Games',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 43
        	[
        		'name' => 'Party Goer',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
          //id: 44
        	[
        		'name' => 'Light Drinker',
        		'category_id' => '5',	// Interests
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        	],
        ]);
    }
}

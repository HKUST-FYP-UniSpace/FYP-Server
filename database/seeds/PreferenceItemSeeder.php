<?php

use Illuminate\Database\Seeder;

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
        		'name' => 'Boys Only',
        		'category_id' => '1',	// Gender
        	],
          //id: 2
        	[
        		'name' => 'Girls Only',
        		'category_id' => '1',	// Gender
        	],
          //id: 3
        	[
        		'name' => 'No Preference',
        		'category_id' => '1',	// Gender
        	],
          //id: 4
        	[
        		'name' => 'TRUE',
        		'category_id' => '2',	// Pet Free
        	],
          //id: 5
        	[
        		'name' => 'FALSE',
        		'category_id' => '2',	// Pet Free
        	],
          //id: 6
        	[
        		'name' => 'Very Often',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
          //id: 7
        	[
        		'name' => 'Sometimes',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
          //id: 8
        	[
        		'name' => 'Rarely',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
        	// --------- Personalities ---------
          //id: 9
        	[
        		'name' => 'Adaptable',
        		'category_id' => '4',	// Personalities
        	],
          //id: 10
        	[
        		'name' => 'Adventurous',
        		'category_id' => '4',	// Personalities
        	],
          //id: 11
        	[
        		'name' => 'Affectionate',
        		'category_id' => '4',	// Personalities
        	],
          //id: 12
        	[
        		'name' => 'Ambitious',
        		'category_id' => '4',	// Personalities
        	],
          //id: 13
        	[
        		'name' => 'Amiable',
        		'category_id' => '4',	// Personalities
        	],
          //id: 14
        	[
        		'name' => 'Compassionate',
        		'category_id' => '4',	// Personalities
        	],
          //id: 15
        	[
        		'name' => 'Considerate',
        		'category_id' => '4',	// Personalities
        	],
          //id: 16
        	[
        		'name' => 'Courageous',
        		'category_id' => '4',	// Personalities
        	],
          //id: 17
        	[
        		'name' => 'Courteous',
        		'category_id' => '4',	// Personalities
        	],
          //id: 18
        	[
        		'name' => 'Diligent',
        		'category_id' => '4',	// Personalities
        	],
          //id: 19
        	[
        		'name' => 'Empathetic',
        		'category_id' => '4',	// Personalities
        	],
          //id: 20
        	[
        		'name' => 'Exuberant',
        		'category_id' => '4',	// Personalities
        	],
          //id: 21
        	[
        		'name' => 'Frank',
        		'category_id' => '4',	// Personalities
        	],
          //id: 22
        	[
        		'name' => 'Generous',
        		'category_id' => '4',	// Personalities
        	],
          //id: 23
        	[
        		'name' => 'Gregarious',
        		'category_id' => '4',	// Personalities
        	],
          //id: 24
        	[
        		'name' => 'Impartial',
        		'category_id' => '4',	// Personalities
        	],
          //id: 25
        	[
        		'name' => 'Intuitive',
        		'category_id' => '4',	// Personalities
        	],
          //id: 26
        	[
        		'name' => 'Inventive',
        		'category_id' => '4',	// Personalities
        	],
          //id: 27
        	[
        		'name' => 'Passionate',
        		'category_id' => '4',	// Personalities
        	],
          //id: 28
        	[
        		'name' => 'Persistent',
        		'category_id' => '4',	// Personalities
        	],
          //id: 29
        	[
        		'name' => 'Philosophical',
        		'category_id' => '4',	// Personalities
        	],
          //id: 30
        	[
        		'name' => 'Practical',
        		'category_id' => '4',	// Personalities
        	],
          //id: 31
        	[
        		'name' => 'Rational',
        		'category_id' => '4',	// Personalities
        	],
          //id: 32
        	[
        		'name' => 'Reliable',
        		'category_id' => '4',	// Personalities
        	],
          //id: 33
        	[
        		'name' => 'Resourceful',
        		'category_id' => '4',	// Personalities
        	],
          //id: 34
        	[
        		'name' => 'Sensible',
        		'category_id' => '4',	// Personalities
        	],
          //id: 35
        	[
        		'name' => 'Sincere',
        		'category_id' => '4',	// Personalities
        	],
          //id: 36
        	[
        		'name' => 'Sympathetic',
        		'category_id' => '4',	// Personalities
        	],
          //id: 37
        	[
        		'name' => 'Unassuming',
        		'category_id' => '4',	// Personalities
        	],
          //id: 38
        	[
        		'name' => 'Witty',
        		'category_id' => '4',	// Personalities
        	],
        	// --------- Interests ---------
          //id: 39
        	[
        		'name' => 'Music',
        		'category_id' => '5',	// Interests
        	],
          //id: 40
        	[
        		'name' => 'Sports',
        		'category_id' => '5',	// Interests
        	],
          //id: 41
        	[
        		'name' => 'Video Games',
        		'category_id' => '5',	// Interests
        	],
          //id: 42
        	[
        		'name' => 'Board Games',
        		'category_id' => '5',	// Interests
        	],
          //id: 43
        	[
        		'name' => 'Party Goer',
        		'category_id' => '5',	// Interests
        	],
          //id: 44
        	[
        		'name' => 'Light Drinker',
        		'category_id' => '5',	// Interests
        	],
        ]);
    }
}

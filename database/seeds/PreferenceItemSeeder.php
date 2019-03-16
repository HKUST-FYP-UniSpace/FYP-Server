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
        	[
        		'name' => 'Boys Only',
        		'category_id' => '1',	// Gender
        	],
        	[
        		'name' => 'Girls Only',
        		'category_id' => '1',	// Gender
        	],
        	[
        		'name' => 'No Preference',
        		'category_id' => '1',	// Gender
        	],
        	[
        		'name' => 'TRUE',
        		'category_id' => '2',	// Pet Free
        	],
        	[
        		'name' => 'FALSE',
        		'category_id' => '2',	// Pet Free
        	],
        	[
        		'name' => 'Very Often',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
        	[
        		'name' => 'Sometimes',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
        	[
        		'name' => 'Rarely',
        		'category_id' => '3',	// Time staying in the Apartment
        	],
        	// --------- Personalities ---------
        	[
        		'name' => 'Adaptable',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Adventurous',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Affectionate',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Ambitious',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Amiable',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Compassionate',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Considerate',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Courageous',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Courteous',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Diligent',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Empathetic',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Exuberant',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Frank',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Generous',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Gregarious',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Impartial',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Intuitive',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Inventive',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Passionate',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Persistent',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Philosophical',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Practical',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Rational',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Reliable',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Resourceful',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Sensible',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Sincere',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Sympathetic',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Unassuming',
        		'category_id' => '4',	// Personalities
        	],
        	[
        		'name' => 'Witty',
        		'category_id' => '4',	// Personalities
        	],
        	// --------- Interests ---------
        	[
        		'name' => 'Music',
        		'category_id' => '5',	// Interests
        	],
        	[
        		'name' => 'Sports',
        		'category_id' => '5',	// Interests
        	],
        	[
        		'name' => 'Video Games',
        		'category_id' => '5',	// Interests
        	],
        	[
        		'name' => 'Board Games',
        		'category_id' => '5',	// Interests
        	],
        	[
        		'name' => 'Party Goer',
        		'category_id' => '5',	// Interests
        	],
        	[
        		'name' => 'Light Drinker',
        		'category_id' => '5',	// Interests
        	],
        ]);
    }
}

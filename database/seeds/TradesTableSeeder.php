<?php

use Illuminate\Database\Seeder;
use Triasrahman\JSONSeeder\JSONSeeder;

class TradesTableSeeder extends Seeder
{
	use JSONSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->JSONseed('trades', '\App\Trade', [
        	'image' => [
        		'table' => 'trade_images',
        		'class' => '\App\TradeImage',
        		'foreign_key' => 'trade_id',
        		'flush' => true,
        	],
        ]);
    }
}

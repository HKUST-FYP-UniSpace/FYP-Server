<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Profile;
use App\ProfileDetail;
use App\House;
use App\HouseComment;
use App\Trade;
use App\TradeTransaction;

class phaseTwoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// 2019-05-01 15:19:33

        // Disable all mass assignment restrictions
        User::unguard();
	    Profile::unguard();
	    ProfileDetail::unguard();
	    House::unguard();
	    HouseComment::unguard();
        Trade::unguard();
        TradeTransaction::unguard();

    	// custome
        $this->call(TenantsTableSeeder2::class);        // add 20 users as tenant
        $this->call(HouseDetailsRemainingSeeder::class) // add into house_details for all the missing records
		
		// custome: factory 
        $this->call(UsersAndProfilesSeeder::class);	    // create 20 tenants
        $this->call(HouseCommentsSeeder::class);	   // create 50 house comments
        $this->call(GroupsSeeder::class);               // create 30 groups
        $this->call(ProfileDetailsTableSeeder::class);  // create 60 preference items for 30 tenants

		// Re enable all mass assignment restrictions
		User::reguard();
	    Profile::reguard();
	    ProfileDetail::reguard();
	    House::reguard();
	    HouseComment::reguard();
        Trade::reguard();
        TradeTransaction::reguard();
    }
}

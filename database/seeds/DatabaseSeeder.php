<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Profile;
use App\ProfileDetail;
use App\PreferenceItemCategory;
use App\PreferenceItem;
use App\HouseStatus;
use App\ChatroomType;
use App\Admin;
use App\Blog;
use App\Tenant;
use App\Owner;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// ------------------- Phase 1 -------------------
        // $this->call(UsersTableSeeder::class);
        
        // Disable all mass assignment restrictions
	    User::unguard();
	    Profile::unguard();
	    ProfileDetail::unguard();
	    PreferenceItemCategory::unguard();
	    PreferenceItem::unguard();
	    HouseStatus::unguard();
	    ChatroomType::unguard();
	    Admin::unguard();
	    Blog::unguard();
	    Tenant::unguard();
	    Owner::unguard();
	 	
	 	// custome
	 	$this->call(AdminsTableSeeder::class);
	 	$this->call(BlogsTableSeeder::class);
	 	$this->call(TenantsTableSeeder::class);
	    $this->call(OwnersTableSeeder::class);

		// custome: factory 
	    $this->call(UsersAndProfilesSeeder::class);

	    // custome: json
	    $this->call(HousesTableSeeder::class);
	    $this->call(TradesTableSeeder::class);
	    
	    // types
	    $this->call(DistrictsTableSeeder::class);
	    $this->call(TradeCategorySeeder::class);
	    $this->call(TradeConditionTypeSeeder::class);
	    $this->call(TradeStatusSeeder::class);
	    $this->call(PreferenceItemCategorySeeder::class);
	    $this->call(PreferenceItemSeeder::class);
	    $this->call(HouseStatusSeeder::class);
	    $this->call(ChatroomTypesTableSeeder::class);
	 
	    // Re enable all mass assignment restrictions
	    User::reguard();
	    Profile::reguard();
	    ProfileDetail::reguard();
	    PreferenceItemCategory::reguard();
	    PreferenceItem::reguard();
	    HouseStatus::reguard();
	    ChatroomType::reguard();
	    Admin::reguard();
	    Blog::reguard();
	    Tenant::reguard();
	    Owner::reguard();
    }
}

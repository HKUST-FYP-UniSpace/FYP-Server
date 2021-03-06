<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Owner;
use App\Tenant;
use App\Profile;
use App\House;
use App\Trade;
use App\Blog;
use App\HouseVisitor;
use App\TradeVisitor;
use Maatwebsite\Excel\Facades\Excel;
use App\Export;



class StatisticsController extends Controller
{
    //
    public function show_popularity() {
      $users = User::get()->count();
      $owners = Owner::get()->count();
      $tenants = Tenant::get()->count();
      $houses = House::get()->count();
      $trades = Trade::get()->count();
      $blogs = Blog::get()->count();
      $house_visitors = HouseVisitor::get()->count();
      $trade_visitors = TradeVisitor::get()->count();

      $males = Profile::select('gender')
                  ->join('tenants','profiles.user_id','=','tenants.user_id')
                  ->where(['gender' => 'M'])
                  ->get()
                  ->count();

      if($tenants == 0) {
        $males_percent = 0;
      }
      else {
        $males_percent = number_format($males/$tenants * 100, 1);
      }

      $females = Profile::select('gender')
                  ->join('tenants','profiles.user_id','=','tenants.user_id')
                  ->where(['gender' => 'F'])
                  ->get()
                  ->count();

      if($tenants == 0) {
        $females_percent = 0;
      }
      else {
        $females_percent = number_format($females/$tenants * 100, 1);
      }

    	return view('statistics.view-statistics',compact('users','owners','tenants','males_percent','females_percent','houses','trades','blogs','house_visitors','trade_visitors'));
    }

    public function export_excel(){

        $excel = new Export;
        $timezone  = 8;
        $filename = "Statistics of UniSpace ".date("Y-m-d H:i:s", time() + 3600 * ( $timezone + date("I"))).".xlsx";

      return Excel::download($excel, $filename);
    }

}

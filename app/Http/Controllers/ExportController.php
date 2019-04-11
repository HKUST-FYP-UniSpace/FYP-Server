<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Export;
use App\House;
use App\District;
use App\HouseStatus;
use App\HouseComment;
use App\Group;
use App\Preference;
use App\GroupDetail;


class ExportController extends Controller
{
    public function export()
  {
    $excel = Export::make('excel');

    $excel->users = User::get()->count();
    $excel->owners = Owner::get()->count();
    $excel->tenants = Tenant::get()->count();
    $excel->houses = House::get()->count();
    $excel->trades = Trade::get()->count();
    $excel->blogs = Blog::get()->count();

    $excel->males = Profile::select('gender')
                ->join('tenants','profiles.user_id','=','tenants.user_id')
                ->where(['gender' => 'M'])
                ->get()
                ->count();

    $excel->males_percent = number_format($excel->males/$excel->tenants  * 100, 1);

    $excel->females = Profile::select('gender')
                ->join('tenants','profiles.user_id','=','tenants.user_id')
                ->where(['gender' => 'F'])
                ->get()
                ->count();

    $excel->females_percent = number_format($excel->females/$excel->tenants  * 100, 1);
  }
}

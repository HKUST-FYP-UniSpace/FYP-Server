<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\District;
use App\TradeCategory;
use App\TradeConditionType;
use App\PreferenceItem;
use App\PreferenceItemCategory;
use App\HouseStatus;
use App\TradeStatus;
use Illuminate\Support\Facades\DB;


class SelectController extends Controller
{
  public function select() {
    return view('select.select');
  }

  //handle district
  public function show_district(){
    $districts = District::get();
    return view('select.add-district', compact('districts'));

  }
  public function add_district(Request $request) {
    // validation
    // dd($request);
    $this->validate($request, [
            'add-district' => 'required|max:255'
        ],
        [
            'add-district.required' => 'Input new district',
            'add-district.max' => 'District cannot be too long'
        ]
    );
    $district = new District();
    $district->name = $request->input('add-district');
    $district->save();

    return redirect()->route('district');
  }

  //handle trade_category
  public function show_trade_category(){
    $trade_categorys = TradeCategory::get();
    return view('select.add-trade_category', compact('trade_categorys'));

  }
  public function add_trade_category(Request $request) {
    // validation
    // dd($request);
    $this->validate($request, [
            'add-trade_category' => 'required|max:255'
        ],
        [
            'add-trade_category.required' => 'Input new trade_category',
            'add-trade_category.max' => 'Trade Category cannot be too long'
        ]
    );
    $trade_category = new TradeCategory();
    $trade_category->category = $request->input('add-trade_category');
    $trade_category->save();

    return redirect()->route('trade_category');
  }

  //handle trade_condition
  public function show_trade_condition(){
    $trade_conditions = TradeConditionType::get();
    return view('select.add-trade_condition', compact('trade_conditions'));

  }
  public function add_trade_condition(Request $request) {
    // validation
    // dd($request);
    $this->validate($request, [
            'add-trade_condition' => 'required|max:255'
        ],
        [
            'add-trade_condition.required' => 'Input new trade condition',
            'add-trade_condition.max' => 'Trade Condition cannot be too long'
        ]
    );
    $trade_condition = new TradeConditionType();
    $trade_condition->type = $request->input('add-trade_condition');
    $trade_condition->save();

    return redirect()->route('trade_condition');
  }

  //handle preference_item
  public function show_preference_item(){
    $preference_items  = PreferenceItemCategory::join('preference_items','preference_item_categories.id','=','preference_items.category_id')->get();

    return view('select.add-preference_item', compact('preference_items'));

  }
  public function add_preference_item(Request $request) {
    // validation
    // dd($request);
    $this->validate($request, [
            'add-preference_item' => 'required|max:255'
        ],
        [
            'add-preference_item.required' => 'Input new preference',
            'add-preference_item.max' => 'Preference cannot be too long'
        ]
    );
    $preference_item = new PreferenceItem();
    $preference_item->name = $request->input('add-preference_item');
    $preference_item->category_id = PreferenceItem::latest()->first()->category_id + 1;
    $preference_item->save();

    return redirect()->route('preference_item');
  }

  //handle preference_item_category
  public function show_preference_item_category(){
    $preference_item_categorys =PreferenceItemCategory::get();
    return view('select.add-preference_item_category', compact('preference_item_categorys'));

  }
  public function add_preference_item_category(Request $request) {
    // validation
    // dd($request);
    $this->validate($request, [
            'add-preference_item_category' => 'required|max:255'
        ],
        [
            'add-preference_item_category.required' => 'Input new preference category',
            'add-preference_item_category.max' => 'Preference category cannot be too long'
        ]
    );
    $preference_item_category = new PreferenceItemCategory();
    $preference_item_category->category = $request->input('add-preference_item_category');
    $preference_item_category->save();

    return redirect()->route('preference_item_category');
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GroupDetail;

class GroupDetailController extends Controller
{
  public function list_all_group_details() {
     $group_details = array();
     $stacks = GroupDetail::get();
     foreach($stacks as $stack) {
         $group_detail = array();
         $group_detail['id'] = $stack->id;
         $group_detail['member_user_id'] = $stack->member_user_id;
         $group_detail['status'] = $stack->status;
         $group_detail['group_id'] = $stack->group_id;
     }
     return $group_details;
   }
}

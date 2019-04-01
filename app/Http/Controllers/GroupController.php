<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Group;

class GroupController extends Controller
{
  public function list_all_groups() {
     $groups = array();
     $stacks = Group::get();
     foreach($stacks as $stack) {
         $group = array();
         $group['id'] = $stack->id;
         $group['title'] = $stack->title;
         $group['image_url'] = $stack->image_url;
         $group['leader_user_id'] = $stack->leader_user_id;
         $group['max_ppl'] = $stack->max_ppl;
         $group['description'] = $stack->description;
         $group['duration'] = $stack->duration;
         $group['is_rent'] = $stack->is_rent;
         $group['house_id'] = $stack->house_id;
     }
     return $groups;
   }
}

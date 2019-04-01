<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use HouseComment;


class HouseCommentController extends Controller
{
 public function list_all_comments() {
    $house_comments = array();
    $stacks = HouseComment::get();
    foreach($stacks as $stack) {
        $house_comment = array();
        $house_comment['id'] = $stack->id;
        $house_comment['house_id'] = $stack->house_id;
        $house_comment['details'] = $stack->details;
        $house_comment['tenant_id'] = $stack->tenant_id;
        $house_comment['created_at'] = $stack->created_at;
    }
    return $house_comments;
  }
}

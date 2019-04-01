<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BlogComment;

class BlogCommentController extends Controller
{
 public function list_all_comments() {
     $blog_comments = array();
    $stacks = BlogComment::get();
    foreach($stacks as $stack) {
        $blog_comment = array();
        $blog_comment['id'] = $stack->id;
        $blog_comment['blog_id'] = $stack->blog_id;
        $blog_comment['details'] = $stack->details;
        $blog_comment['user_id'] = $stack->user_id;
        $blog_comment['created_at'] = $stack->created_at;
    }
    return $blog_comments;
  }
}

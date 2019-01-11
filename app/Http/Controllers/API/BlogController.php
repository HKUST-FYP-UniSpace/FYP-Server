<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
    //
    public function create_Blog(Request $request){
      $blog = new Blog();

      $blog->title = $request->input('title');
      $blog->description = $request->input('title');
      $blog->status = 1;
      $blog->admin_id = $request->input('admin_id');
      $blog->image_url = isset($request->input('image_url')) ? "" : $request->input('image_url');

      $blog->save();

    }

    public function edit_Blog(){

    }

    public function delete_Blog(){

    }

    public function comment_Blog(){

    }

    public function list_Blogs(){

    }

}

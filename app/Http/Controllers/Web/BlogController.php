<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    //
      public function show_blog() {
    	return view('blog.list-blog');
    }

        public function show_blog_details() {
    	return view('blog.view-blog');
    }

        public function add_blog() {
    	return view('blog.add-blog');
    }
    


}

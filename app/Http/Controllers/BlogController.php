<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Blog;
class BlogController extends Controller
{
    //
    public function list_all_blogs() {
        $blogs = array();
        $stacks = Blog::get();
        foreach($stacks as $stack) {
            $blog = array();
            $blog['id'] = $stack->id;
            $blog['title'] = $stack->title;
            $blog['description'] = $stack->description;
            $blog['email'] = $stack->email; 
            $blog['admin_id'] = $stack->admin_id;
            $blog['image_url'] = $stack->image_url;
            $blog['created_at'] = $stack->created_at;
        }
        return $blogs;
    }

    //
    public function show_blog() {
        $blogs = Blog::paginate(2);
        
        return view('blog.list-blog', compact('blogs'));  
    }  

    public function show_blog_details($id) {
        $blog = Blog::where('id', $id)->first();
        

    	return view('blog.view-blog',compact('blog'));
    }

        public function add_blog() {
    	return view('blog.add-blog');
    }

 public function edit_blog_form($id) { // $id is user id
        $blog = Blog::where('id', $id)->first();
          
        return view('blog.edit-blog', compact('blog'));
                
    }


    public function update_blog($id, Request $request) {
        
        $this->validate($request, [
            'edit-blog-title' => 'required|max:255',
            'edit-blog-status' => 'required|max:255',
            'edit-blog-admin_id' => 'required|max:255',
            'edit-blog-image_url' => 'required|max:255',
            'edit-blog-description' => 'nullable|max:255'
            ], 

           [
            'edit-blog-title' => 'Input title',
            'edit-blog-status' => 'Input status',
            'edit-blog-admin_id' => 'Input Price',
            'edit-blog-image_url' => 'Input Status',
            'edit-blog-description' => 'Input Owner ID'
            ]);


        // get targeted data
        $blog = Blog::where('id', $id)->first();
        

        $blog->title = $request->input('edit-blog-title');
        $blog->status = $request->input('edit-blog-status');
        $blog->admin_id = $request->input('edit-blog-admin_id');
        $blog->image_url= $request->input('edit-blog-image_url');
        $blog->description = $request->input('edit-blog-description');


        $blog->save();


        // redirect to edit success page
        return view('blog.edit-blog-success', ['id'=> $id]);
    }


}


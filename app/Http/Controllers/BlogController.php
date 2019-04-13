<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\BlogComment;
use Illuminate\Http\UploadedFile;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    //list all blogs
    public function list_all_blogs() {
        $blogs = array();
        $stacks = Blog::get();
        foreach($stacks as $stack) {
            $blog = array();
            $blog['id'] = $stack->id;
            $blog['title'] = $stack->title;
            $blog['subtitle'] = $stack->subtitle;
            $blog['detail'] = $stack->detail;
            $blog['admin_id'] = $stack->admin_id;
            $blog['image_url'] = $stack->image_url;
            $blog['created_at'] = $stack->created_at;
        }
        return $blogs;
    }


    //
    public function show_blog() {
        $blogs = Blog::paginate(5);

        return view('blog.list-blog', compact('blogs'));
    }

    public function show_blog_details($id) {
        $blog = Blog::where('id', $id)->first();
    	  return view('blog.view-blog',compact('blog'));
    }

      // show list of comments according to the blog_id
    public function show_comments($id){
      // get targeted data
      $blog = Blog::where('id', $id)->first();
      $blog_comments = BlogComment::where('blog_id', $id)->latest()->get();

      return view('blog.comment-blog', compact('blog_comments'));
    }


    public function add_blog_form() {
        return view('blog.add-blog');
    }


    public function edit_blog_form($id) { // $id is user id
        $blog = Blog::where('id', $id)->first();

        return view('blog.edit-blog', compact('blog'));
    }


    public function update_blog($id, Request $request) {

        // dd($request);
        $this->validate($request, [
            'edit-blog-title' => 'required|max:255',
            'edit-blog-subtitle' => 'required|max:255',
            'edit-blog-status' => 'required|max:255',
            'edit-blog-admin_id' => 'required|max:255',
            'edit-blog-detail' => 'nullable|max:255',
            'edit-file' => 'image|mimes:jpeg,png,jpg|max:2048'
            ],

           [
            'edit-blog-title' => 'Input title',
            'edit-blog-subtitle' => 'Input subtitle',
            'edit-blog-status' => 'Input status',
            'edit-blog-admin_id' => 'Input Price',
            'edit-blog-detail' => 'Input detail',
            'edit-file.image' => 'Choose image',
            'edit-file.mimes' => 'Image format .jpeg/.png/.jpg',
            'edit-file.max' => 'Image should not exceed 2MB '
            ]);


        // get targeted data
        $blog = Blog::where('id', $id)->first();


        $blog->title = $request->input('edit-blog-title');
        $blog->subtitle = $request->input('edit-blog-subtitle');
        $blog->status = $request->input('edit-blog-status');
        $blog->admin_id = $request->input('edit-blog-admin_id');
        $blog->detail = $request->input('edit-blog-detail');

        if($request->input('hidden-flag') == 'new') {
          $blog->image_url ="www.google.com";
          $blog->save();
          // handle image upload
          $image = $request->file('edit-file');
          $extension = $image->getClientOriginalExtension();

          $now = strtotime(Carbon::now());
          $url = $blog->id. '_' . $now . '_' . $extension;
          Storage::disk('public')->put($url,  File::get($image));

          $blog->image_url = url('uploads/'.$url);
        }
        // save in database
        $blog->save();
        // redirect to edit success page
        return view('blog.edit-blog-success', ['id'=> $id]);
    }

    // process POST request
    public function add_blog(Request $request) {
          // dd($request);
        // validation
        // dd($request);
        $this->validate($request, [
                'add-blog-title' => 'required|max:255',
                'add-blog-subtitle' => 'required|max:255',
                'add-blog-status' => 'required',
                'add-blog-admin_id' => 'required|max:255',
                'add-blog-detail' => 'required|max:255',
                'add-file' => 'image|mimes:jpeg,png,jpg|max:2048'
            ],
            [
                'add-blog-title.required' => 'Input blog title', //blog title
                'add-blog-title.max' => 'Title cannot be too long',
                'add-blog-subtitle.required' => 'Input blog subtitle', //blog subtitle
                'add-blog-subtitle.max' => 'Subtitle cannot be too long',
                'add-blog-status.required' => 'Select Blog Status', //select hard code status options
                'add-blog-admin_id.required' => 'Input blog admin_id', //admin_id
                'add-blog-admin_id.max' => 'Admin ID cannot be too long',
                'add-blog-detail.required' => 'Input detail', //description
                'add-blog-detail.max' => 'Detail cannot be too long',
                // 'add-file.required' => 'Choose File', //image
                'add-file.image' => 'Choose image',
                'add-file.mimes' => 'Image format .jpeg/.png/.jpg',
                'add-file.max' => 'Image should not exceed 2MB '
            ]
        );

        // form information filled by users
        $blog= new Blog();
        $blog->is_deleted = 0;
        // title
        $blog->title = $request->input('add-blog-title');
        // subtitle
        $blog->subtitle = $request->input('add-blog-subtitle');
        // blog status
        $blog->status = intval($request->input('add-blog-status'));
        // description
        $blog->detail = $request->input('add-blog-detail');
        // owner_id
        $blog->admin_id = $request->input('add-blog-admin_id');
        $blog->image_url ="www.google.com";
        $blog->save();
        // image
        // handle image upload
        $image = $request->file('add-file');
        $extension = $image->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = $blog->id. '_' . $now . '_' . $extension;
        Storage::disk('public')->put($url,  File::get($image));

        $blog->image_url = url('uploads/'.$url);
        // save in database
        $blog->save();


        // redirect to add success page
        return view('blog.add-blog-success', ['id'=> $blog->id]);
    }

    public function search(Request $request){
      if ( $request->has('search') ){
          // get profiles
          $blogs = Blog::where('title', "LIKE", "%".$request->search."%")
                              ->orWhere('subtitle', "LIKE", "%".$request->search."%")
                              ->orWhere('detail', "LIKE", "%".$request->search."%")
                              ->orWhere('status', "LIKE", "%".$request->search."%")
                              ->orWhere('admin_id', "LIKE", "%".$request->search."%")
                              ->orWhere('id', "LIKE", "%".$request->search."%");
      }else{
        $blogs = Blog::get();
      }
      $searchPhrase = $request->search;
      return view('blog.list-blog', compact('blogs','searchPhrase'));
    }

    public function delete($delete_id, Request $request) {
      //dd($request);
      $blog= Blog::where('id', $delete_id)->first();
      $blog->is_deleted = 1;
      $blog->save();

      return back();
    }

}

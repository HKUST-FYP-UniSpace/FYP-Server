<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\BlogComment;
use Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
    // Delete Blog
    public function delete_blog($id){
      // First check if the blog does not exit,
      // immediately terminate the method with exit message
      $blog = Blog::where('id',$id)->first();
      if($blog == null){
        return "Blog with respective ID numebr does not exist";
      }

      // Retrieve the id of the related blog comments' id
      // for later successful message checking
      $blog_comments_position = BlogComment::where('blog_id', $id);
      $blog_comments = $blog_comments_position->get();
      $blog_comments_count = $blog_comments_position->count();

      $i = 0;
      $comments_id_str = '';
      foreach ($blog_comments as $blog_comment) {
        if($i < $blog_comments_count - 1){
          $comments_id_str .= ($blog_comment->id . ', ');
          $i++;
        }else{
          $comments_id_str .= ($blog_comment->id . '.');
        }
      }

      // Delete the related blog comments
      $blog_comments_position->delete();

      // Delete blog
      $blog->delete();

      // Create success message
      $success_msg = "Successfully deleted blog with ID = {$id}";
      if(trim($comments_id_str) !== ''){
        $success_msg .= " and blog comments with ID = {$comments_id_str}";
      }

      return $success_msg;
    }


    // Create Comment on Blog
    public function comment_blog($id, Request $request){
      $blog_comment = new BlogComment();

      $blog_comment->comment = $request->input('comment'); //need to be added into the db later
      $blog_comment->blog_id = $id;
      $blog_comment->user_id = $request->input('user_id');

      $blog_comment->save();

      $success_msg = "Successfully comment on blog {$id} with comment ID = {$blog_comment->id}";
      return $success_msg;
    }


    //-----------------------------------------------------------------------
    //The following functions are not on the api list (a good to have?)

    // Delete Single Blog Comment
    public function delete_blog_comment($id, $comment_id){
      $blog_comment = BlogComment::where('blog_id', $id)->where('id', $comment_id)->delete();

      $success_msg = "Successfully deleted blog comment with ID = {$comment_id} on blog {$id}";
      return $success_msg;
    }


    // Create Blog
    public function store_blog(Request $request){
      $blog = new Blog();

      $blog->title = $request->input('title');
      $blog->description = $request->input('description');
      $blog->status = '1';
      $blog->admin_id = $request->input('admin_id');
      $blog->image_url = $request->input('image_url')==null ? '' : $request->input('image_url');

      $blog->save();

      //
      $success_msg = "New Blog Stored Successfully! (Blog ID = {$blog->id})";
      return $success_msg;
    }


    // View Blog (Get Blog Detail)
    public function show_blog($id){
      $blog = Blog::where('id', $id)->first();
      // Terminate the method and return exit message if the respective blog does not exist
      if($blog == null){
        return "Blog with respective ID numebr does not exist";
      }

      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$result['errors'] = array();

      $result_blog = [
        'id' = $blog->id;
        'title' = $blog->title;
        //$result_blog['subtitle'] = $blog->subtitle;
        //$result_blog['detail'] = $blog->detail;
        'time' = $blog->created_at; //create time maybe?
        'photoURL' = $blog->image_url;
      ];


      // $result['blog'] = $result_blog;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';
      //
      // return $result_all;
      return $result_blog;
    }

    public function show_blogComments($id){
      $result_blog_comments = array();
      $blog_comments = BlogComment::where('blog_id', $id)->get();
      foreach ($blog_comments as $blog_comment) {
        $result_blog_comment = [
          'id' => $blog_comment->id,
          'comment' => $blog_comment->comment,
          'user_id' => $blog_comment->user_id,
          'created_at' => $blog_comment->created_at,
          'updated_at' => $blog_comment->updated_at
        ];
        array_push($result_blog_comments, $result_blog_comment);
      }
      return $result_blog_comments;
    }


    // Update Blog
    public function update_blog($id, Request $request){
      $blog = Blog::where('id', $id)->first();

      // Terminate the method if the blog does not exist
      if($blog == null){
        return "Blog with respective ID numebr does not exist";
      }

      $blog->title = ($request->input('title')==null ? "" : $request->input('title'));
      $blog->description = ($request->input('description')==null ? "" : $request->input('description'));
      $blog->status = (int)($request->input('status')==null ? "" : $request->input('status'));
      $blog->admin_id = (int)($request->input('admin_id')==null ? "" : $request->input('admin_id'));
      $blog->image_url = ($request->input('image_url')==null ? "" : $request->input('image_url'));

      // $request->input('title')==null ? $blog->update(['title' => ""]) : $blog->update(['title' => $request->input('description')]);
      // $request->input('description')==null ? $blog->update(['description' => ""]) : $blog->update(['description' => $request->input('description')]);
      // $request->input('status')==null ? $blog->update(['status' => ""]) : $blog->update(['status' => $request->input('status')]);
      // $request->input('admin_id')==null ? $blog->update(['admin_id' => ""]) : $blog->update(['admin_id' => $request->input('admin_id')]);
      // $request->input('image_url')==null ? $blog->update(['image_url' => ""]) : $blog->update(['image_url' =>$request->input('image_url')]);

      $blog->save();

      $success_msg = "Blog Updated Successfully (ID = {$id})";
      return $success_msg;
    }


    // List Blog
    public function index_blog(){
      //return Blog::get();

      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$errors = array();

      $result_blogs = array();
      $blogs = Blog::get();
      foreach ($blogs as $blog) {
        $result_blog = [
          'id' => $blog->id,
          'title' => $blog->title,
          'description' => $blog->description,
          'status' => $blog->status,
          'admin_id' => $blog->admin_id,
          'image_url' => $blog->image_url,
          'created_at' => $blog->created_at,
          'updated_at' => $blog->updated_at
        ];

        array_push($result_blogs, $result_blog);
      }

      // $result['blogs'] = $result_blogs;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      return $result_blogs;

    }

    // Should return an array of objects instead?
    public function index_blogSummary(){
      $result_blogs = array();
      $blogs = Blog::get();
      foreach ($blogs as $blog) {
        // $result_blog = [
        //   'id' => $blog->id,
        //   'title' => $blog->title,
        //   'description' => $blog->description, //may not consist of this if description is considered as "detail", which should be only displayed in the detail part
        //   'status' => $blog->status,
        //   'admin_id' => $blog->admin_id,
        //   'image_url' => $blog->image_url,
        //   'created_at' => $blog->created_at,
        //   'updated_at' => $blog->updated_at
        // ];

        $result_blog = [
          'id' = $blog->id;
          'title' = $blog->title;
          //$result_blog['subtitle'] = $blog->subtitle;
          //$result_blog['detail'] = null;
          'time' = $blog->created_at; //create time maybe?
          'photoURL' = $blog->image_url;
        ];

        array_push($result_blogs, $result_blog);
      }

      return $result_blogs;
    }


}

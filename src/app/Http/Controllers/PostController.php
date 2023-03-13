<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //show all posts
    public function index(Request $request)
    {
        $obj_post = new Post();
        $allPosts = $obj_post->allPosts();
        return view('all-post',compact('allPosts'));
    }


    //send post
    public function savePost()
    {
        try {
            $obj_post = new Post();
            $obj_post->addPost();
            return redirect()->route('posts')->with('success','Send the post successfully!');
        }catch (\Exception $e){
            return view('send-post')->with('Error','Do not Send the post ');
        }
    }

    public function deletePost($postId)
    {
        $obj_post = new Post();
        try {
             $obj_post->deletePost($postId);
            return redirect()->route('posts')->with('success','Delete the post successfully!');
        }catch (\Exception $e){
            return redirect()->route('posts')->with('Error','Do not delete the post ');
        }
    }

    public function restoreAllPost()
    {
        $obj_post = new Post();
        $obj_post->restoreAllPosts();
        return redirect()->route('posts')->with('success','Delete the post successfully!');
    }

    public function restorePost($postId)
    {
        $obj_post = new Post();
        $obj_post->restorePostGet($postId);
        return redirect()->route('posts')->with('success','Delete the post successfully!');
    }



}

<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'title',
        'email',
        'body',
        'author'
    ];

    public function allPosts()
    {
        $request = \request();
        if($request->has('trashed')){
            $allPosts = Post::onlyTrashed()->orderBy('id','desc')->paginate(2);
        }else{
            $allPosts = Post::orderBy('id','desc')->paginate(5);
        }
        return $allPosts;
    }

    public function addPost()
    {
        $request = \request();
        $request->validate([
            'title'=>'required|min:5',
            'email'=>'required|email',
            'body'=>'required|min:5'
        ]);
        $posts = $request->all();

        Post::create([
            'title'=> request('title'),
            'email'=>request('email'),
            'body'=>request('body'),
            'author'=>request('author')

        ]);

    }

    public function deletePost($id)
    {
       return Post::find($id)->delete();
    }

    public function restorePostGet($postId)
    {
        Post::withTrashed()->find($postId)->restore();
        return redirect()->back();
    }
    public function restoreAllPosts()
    {
        Post::onlyTrashed()->restore();
        return redirect()->back();
    }


}

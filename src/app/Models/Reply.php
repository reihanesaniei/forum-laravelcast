<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'thread_id',
        'body',
        'best_flag'
    ];



    public function getAll()
    {
       return $this->get();
    }

    public function getByThreads($threadId)
    {
        $replies = $this->where('thread_id',$threadId)->get();

        $result = [];
        $index = 0;
        foreach ($replies as $reply){
                $user['name']= 'id';
                $user['value'] = $reply['user_id'];


                $result[$index]['reply_id'] = $reply['id'];
                $result[$index]['best_flag'] = $reply['best_flag'];
                $result[$index]['like_flag'] = $reply['like_flag'];
                $result[$index]['reply'] = $reply['body'];
                $result[$index]['updated_at'] = ($reply['updated_at'])->format('Y M d');
                $result[$index]['user'] = (new User())->get($user);
            $index++;
        }
        return ($result);
    }

    public function set(Request $request)
    {
        $validator = $request->validate([
            'user_id'=>'required',
            'thread_id'=>'required',
            'body'=>'required|min:3'
        ],[
            'user_id' =>'This field is necessary',
            'thread_id' =>'This field is necessary',
            'body' =>'This field is necessary and you need to send longer reply',
        ]);

        $replies = $request->all();
        Reply::create([
            'user_id'=> request('user_id'),
            'thread_id'=>request('thread_id'),
            'body'=>request('body')

        ]);




    }

    public static function updateBestFlag($replyId)
    {
        Reply::where('best_flag',1)->update(['best_flag'=>0]);
        Reply::where('id',$replyId)->update(['best_flag'=>1]);


    }

}

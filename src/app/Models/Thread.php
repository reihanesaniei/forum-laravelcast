<?php

namespace App\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * App\Thread
 *
 * @property int $id
 * @property int $user_id
 * @property int $channel_id
 * @property-read int|null $replies_count
 * @property string $title
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Channel $channel
 * @property-read \App\Models\User $creator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereRepliesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereUserId($value)
 * */
class Thread extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAll()
    {
        return $this->paginate(10);
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function get($id)
    {
        return $this->where('id',$id)->get();
    }
    public static function getAllByChannel($channelId) {
      return self::where('channel_id',$channelId)->paginate(10);
    }

    public function updateThread($var)
    {
        $this->update($var['name'],$var['value']);
    }
    public function incrementReplyCount($threadId)
    {
        return $this->find($threadId)->increment('replies_count');
    }

    public static function set()
    {
        $request = \request();
        $request->validate([
            'title'=>'required|min:5',
            'body'=>'required|min:5',
        ]);
        $threads = $request->all();

        Thread::create([
            'user_id'=>request('user_id'),
            'channel_id'=>request('channel_id'),
            'title'=> request('title'),
            'body'=>request('body'),
            'slug'=>Str::slug(request('title'))

        ]);
    }

    public function setSolvedFlag($thread)
    {
        return $this->where('id',$thread->id)->update(['solved_flag'=>1]);
    }

    public function setFlag($value,$thread,$flag_increase,$type=null)
    {
        if ($value['value'] == 'like_flag' && $flag_increase == 1){
            $setVal  = $thread->like_flag + 1;
        }elseif ($value['value'] == 'like_flag' && $flag_increase == 0){
            $setVal  = $thread->like_flag - 1;
        }
        if($type == 'thread'){
            if($value['value'] == 'solved_flag' && $flag_increase == 1){
                $setVal  = $thread->solved_flag + 1;
            }elseif ($value['value'] == 'solved_flag' && $flag_increase == 0) {
                $setVal  = $thread->solved_flag - 1;
            }
            return $this->where('id',$value['id'])->update([$value['value']=>$setVal]);
        }

        return (new Reply())->where('id',$value['id'])->update([$value['value']=>$setVal]);



    }



}

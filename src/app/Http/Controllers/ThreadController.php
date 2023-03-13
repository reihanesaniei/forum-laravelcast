<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;


class ThreadController extends Controller
{

    public function index()
    {
        $threads =  (new Thread())->getAll();
        $channels =  Channel::getAll();
        return view('threads.index',['channels'=>$channels,'threads'=>$threads]);
    }


    public function getThreadDetail(Thread $thread)
    {
        $channel = (new Channel())->getName($thread->channel_id);
        $others = (new Reply())->getByThreads($thread->id);
        $userThread = (new User())->get(['name'=>'id','value'=>$thread->user_id]);
        $thread['user'] = $userThread;
        $thread['solved'] = ['solved_flag'=>$thread->solved_flag];
        $thread['liked'] = ['like_flag'=>$thread->like_flag];

        return view('threads._listdetail', ['channel'=>$channel["name"],'thread'=>$thread,'others'=> $others]);
    }

    public function getThreadDetailBest(Thread $thread)
    {
        if(isset($_POST['replyId'])){
            Reply::updateBestFlag($_POST['replyId']);
        }

        $channel = (new Channel())->getName($thread->channel_id);
        $others = (new Reply())->getByThreads($thread->id);
        return view('threads._listdetail', ['channel'=>$channel["name"],'thread'=>$thread,'others'=> $others]);

     // return (new Reply())->find($request->id);
    }
    /**
     * @param Channel $channel
     * @return mixed
     */
    public function getThreads(Channel $channel)
    {
        if ($channel->exists) {
            $threads = Thread::whereChannelId($channel->id);
        }else{
            $threads = $this->getAll();
        }
        return $threads->latest()->paginate(25);
    }

    public function replyThread(Request $request,Thread $thread)
    {
        try {
            (new Reply())->set($request);
            //increment replies count
            $thread->incrementReplyCount($request->thread_id);
            return redirect()->route("threads");
        }catch (\Exception $e){
            return redirect()->route("threads");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($channel, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $channel
     * @param \App\Models\Thread $thread
     * @return Thread
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->update(request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]));

        return $thread;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->replies->each->delete();
        $thread->delete();

        return redirect('threads');
    }

    public function sendReply()
    {

        try {
            (new Reply())->set();
            return redirect()->route('threads')->with('success','Send the reply successfully!');
        }catch (\Exception $e){
            return redirect()->route('threads')->with('Error','Do not Send the reply');
        }
    }

    public function addThread(Channel $channel)
    {
        try {
            Thread::set();
            return redirect("/discuss/channels/$channel->slug")->with('channel',$channel);
        }catch (\Exception $e){
            return redirect("/discuss/channels/$channel->slug")->with('channel',$channel);
        }
    }

    public function solvedThread(Thread $thread)
    {

        $value = ['id'=>$thread->id,'value'=>'solved_flag'];
        try {
            (new Thread())->setFlag( $value,$thread);
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }catch (\Exception $e){
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }
    }

    public function likeThread(Thread $thread)
    {
        $value = ['id'=>$thread->id,'value'=>'like_flag'];
        try {
            (new Thread())->setFlag($value,$thread,1,'thread');
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }catch (\Exception $e){
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }
    }
    public function unlikeThread(Thread $thread)
    {
        $value = ['id'=>$thread->id,'value'=>'like_flag'];
        try {
            (new Thread())->setFlag($value,$thread,0,'thread');
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }catch (\Exception $e){
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }
    }

    public function likeReply(Thread $thread,Reply $reply)
    {

        $value = ['id'=>$reply->id,'value'=>'like_flag'];

        try {
            (new Thread())->setFlag($value,$reply,1);
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }catch (\Exception $e){
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }
    }
    public function unlikeReply(Thread $thread,Reply $reply)
    {
        $value = ['id'=>$reply->id,'value'=>'like_flag'];
        try {
            (new Thread())->setFlag($value,$reply,0);
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }catch (\Exception $e){
            return redirect("/discuss/$thread->slug")->with('thread',$thread);
        }
    }


}

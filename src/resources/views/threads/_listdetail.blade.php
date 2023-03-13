@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="card mb-2 no-padd">
                        <div class="card-header">
                            <div class="card-title mb-2 channel">{{$channel}}</div>
                            <div class="card-title title-ajax" alt="{!! $thread->slug !!}">
                                <h4>{!! $thread->title !!}</h4>
                                <div class="user-info card-title row">
                                    <a href="#">{{($thread["user"])['name']}}</a>
                                    <a href="#">{{($thread["user"])['email']}}</a>
                                </div>
                            </div>
                            <?php

                            ?>
                            <div class="card-title mb-2 channel">
                                <span class="btn btn-outline-primary"><i class="fa fa-comments-o">{{$thread->replies_count}}</i></span>
                                @if($thread->like_flag == 0) <a  class="btn btn-outline-primary" href="/discuss/{{$thread->slug}}/liked"><i class="fa fa-heart-o">@else<a  class="btn btn-outline-primary" href="/discuss/{{$thread->slug}}/unliked"><i class="fa fa-heart"> {{$thread->like_flag}}@endif</i></a>
                               @if($thread->solved_flag == 1) <span class="btn btn-success thread-solved">solved</span> @endif
                               @if($thread->solved_flag != 1)
                                    @if(\Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::id() == $thread->user_id )) <a href="/discuss/{{$thread->slug}}/solved" class="btn btn-primary">My problem is solved.</a>@endif
                               @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="body">{!! $thread->body !!}</div>
                        </div>
                        @if(count($others) > 0)
                            @foreach($others as $reply)
                                <div class="card m-3">
                                    <div class="card-header">
                                        <div class="row mb-2">
                                            <div class="col-xs-12 col-sm-9">
                                                <h4> @if($reply["best_flag"] == 1) <i class="fa fa-check best-color" title="this reply is the best"></i> @endif {!! ($reply["user"])['name'] !!}</h4>
                                                <a class="link-info" href="#">{{($reply["user"])['email']}}</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 d-flex">
                                                @if(\Illuminate\Support\Facades\Auth::check() && $reply["reply_id"] && $reply["best_flag"] != 1)
                                                    <form id="select-best-answer"  class=" justify-content-start mt-3"  action="/discuss/{{$thread->slug}}" method="post" >
                                                        @csrf
                                                        <input type="hidden" value="{{$reply["reply_id"]}}" name="replyId" >
                                                        <input type="hidden" value="{{$thread->slug}}" name="replySlug" >
                                                        <button type="submit"  class="btn btn-outline-primary" title="Select Best Answer"><i class="fa fa-check"></i></button>
                                                    </form>
                                                @endif
                                                @if($reply["like_flag"] == 0) <a  class="btn btn-outline-primary justify-content-end m-3" href="/discuss/{{$thread->slug}}/{{$reply["reply_id"]}}/liked"><i class="fa fa-heart-o">@else<a  class="btn btn-outline-primary justify-content-end m-3" href="/discuss/{{$thread->slug}}/{{$reply["reply_id"]}}/unliked"><i class="fa fa-heart"> {{$reply["like_flag"]}}@endif</i></a>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="body">{!! $reply["reply"] !!}</div>
                                    </div>
                                    <div class="card-footer">{!! $reply["updated_at"] !!}</div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
                @if(\Illuminate\Support\Facades\Auth::check())
                    <div class="row mb-3">
                        <div class="card parent-reply-thread md-3 ">
                            <div class="card-title md-3 show-reply-thread mt-2" ><div class="btn btn-outline-primary">Click for Reply</div></div>
                            <div class="card2 md-3 visually-hidden">
                                <div class="card-body">
                                    <form action="/discuss" method="post" >
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{ Auth::user()->id}}" name="user_id" >
                                        <input type="hidden" value="{{$thread->id}}" name="thread_id"/>
                                        <div class="form-group mb-3">
                                            <label for="InputPost" class="p-2">Reply</label>
                                            <textarea name="body" class="form-control" id="InputPost" aria-describedby="postHelp" placeholder="Enter reply" cols="20" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Post Reply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="card parent-reply-thread md-3 ">
                            <div class="card-title md-3 mt-2" ><a href="{{ route('login') }}" class="btn btn-outline-primary">Click for Reply</a></div>

                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-header">
                        Search
                    </div>
                    <div class="card-body">
                        <form method="GET" action="">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Search for something..." name="q" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).on('submit','#select-best-answer',function(){
            var slug = $("input[name = 'replySlug']").val();
            var replyId = $("input[name = 'replyId']").val();
            $.ajax({
                method:"POST",
                url: "/discuss/"+slug,
                data:{
                    replyId:replyId
                },
                success: function(data){
                }});
        });
        $(document).ready(function (){
            $(".show-reply-thread").click(function (){
                $(this).parent().find(".card2.md-3.visually-hidden").removeClass("visually-hidden");
                $(this).parent().find(".card-title.md-3.show-reply-thread").addClass("visually-hidden");
            });
        });
    </script>
@endsection

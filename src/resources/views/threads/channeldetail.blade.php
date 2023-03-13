@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="card mb-2 no-padd">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>{!! $channel->name !!}</h4>
                            </div>
                        </div>

                        @if(count($threads) > 0)
                            <div class="card-body mb-3">
                                @foreach($threads as $thread)
                                    <div class="card m-3">
                                        <div class="card-header">
                                            <div class="justify-content-between align-items-center mb-2">
                                                <a href="/discuss/{{ $thread["slug"]}}">
                                                    <h4> {!! $thread["title"] !!}</h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="body">{!! Illuminate\Support\Str::limit($thread["body"]) !!}</div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="card-body mb-3">{{$threads->render()}}</div>
                        @else
                            <div class="card-body mb-3">
                                This channel don't have thread.
                            </div>
                        @endif
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::check() && $channel->id)
                    <div class="row mb-3">
                        <div class="card parent-reply-thread md-3 ">
                            <div class="card-title md-3 show-reply-thread mt-2" >
                                <div class="card-body">
                                    <form action="/discuss/channels/{{$channel->slug}}" method="post" >
                                        {!! csrf_field() !!}
                                        <input type="hidden" value="{{ Auth::user()->id}}" name="user_id" >
                                        <input type="hidden" value="{{$channel->id}}" name="channel_id"/>
                                        <div class="form-group mb-3">
                                            <h3 class="card-title mt-3">New Discussion</h3>
                                            <div class="form-group mtg-3">
                                                <input name="title" class="form-control" id="InputTitle" aria-describedby="titleHelp" placeholder="Enter title" required>
                                            </div>
                                            <div class="form-group mt-3">
                                                <textarea name="body" class="form-control" id="InputBody" aria-describedby="BodyHelp" placeholder="What's on your mind?" cols="5" rows="10" required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </form>
                                </div>
                            </div>
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
@endsection





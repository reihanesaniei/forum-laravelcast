@extends('layouts.app')
@section('content')
<div class="container" id="posts">
    @if($errors)
        <div class="row mb-3">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger"> {{$error}}</div>
            @endforeach
        </div>
    @endif
    <div class="row mb-3">
        @if(\Illuminate\Support\Facades\Auth::check())
            <div class="card-deck">
                <div class="card">
                    <div class="card-body">
                        @if(request()->has('trashed'))
                            <a href="{{ route('posts') }}" class="btn btn-info">View All posts</a>
                            <a href="{{ route('posts.allRestore') }}" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
                                    <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8z"/>
                                    <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352h1.141zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324h-1.6z"/>
                                </svg>
                                Restore All Deleted Posts
                            </a>
                        @else
                            <a href="{{ route('posts', ['trashed' => 'post']) }}" class="btn btn-primary">View Deleted posts</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @foreach($allPosts as $post)
            <div class="card-deck">
                <div class="card">
                    <div class="card-header">
                        @if(request()->has('trashed'))
                            <a href="{{ route('posts.restore',$post->id)}}" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
                                    <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8z"/>
                                    <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352h1.141zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324h-1.6z"/>
                                </svg>Restore</a>
                        @else
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-danger delete" title='Delete'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg> Delete Post</button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <data value="{{$post->created_at}}"></data>
                        <p class="card-text">{{$post->body}}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">author: {{$post->author}} - contact author: {{$post->email}}</small>
                    </div>
                </div>

            </div>
        @endforeach
        <div>{{ $allPosts->render()}}</div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $('.delete').click(function(e) {
            if(!confirm('Are you sure you want to delete this post?')) {
                e.preventDefault();
            }
        });
    });
</script>

@endsection

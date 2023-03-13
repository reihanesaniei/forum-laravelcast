@extends('layouts.app')
@section('content')
    <div class="container">
        @if($errors)
            <div class="row">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger"> {{$error}}</div>
                @endforeach
            </div>
        @endif
        <div class="row">
            <form action="{{route('send.post')}}" method="post" >
               {!! csrf_field() !!}
                <div class="form-group">
                    <label for="InputAuthor">Author</label>
                    <input name="author" type="text" class="form-control" id="InputAuthor" aria-describedby="authorHelp" placeholder="Enter Author">
                    <small id="authorHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="InputTitle">Title</label>
                    <input name="title" type="text" class="form-control" id="InputTitle" aria-describedby="titleHelp" placeholder="Enter Title" required>
                    <small id="titleHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                @if(\Illuminate\Support\Facades\Auth::check())
                    <div class="form-group">
                        <label for="InputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp"  value="{{ Auth::user()->email}}">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                @else
                    <div class="form-group">
                        <label for="InputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                @endif

                <div class="form-group">
                    <label for="InputPost">Post</label>
                    <textarea name="body" class="form-control" id="InputPost" aria-describedby="postHelp" placeholder="Enter post" cols="20" required></textarea>
                    <small id="postHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>

    </div>

@endsection

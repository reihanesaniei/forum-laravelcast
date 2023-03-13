<div class="row mb-3 rw3">
    @if($errors)
        <div class="">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger"> {{$error}}</div>
            @endforeach
        </div>
    @endif
</div>
@foreach($threads as $thread)
    <div class="row mb-3">
        @if($thread)
            <div class="card mb-2 no-padd">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <a href="discuss/{{$thread->slug}}" class="card-title">{!! $thread->title !!}</a>
                        </div>
                      @if($thread->replies_count > 0)
                            <div class="card-title mb-2 channel">{{$thread->replies_count}} conversations</div>
                      @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="body">{{ Illuminate\Support\Str::limit($thread->body)}}</div>
                </div>
            </div>
        @else
            <div class="card mb-2 no-padd">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h4> List is empty</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach
<div class="row mb-3">{{$threads->render()}}</div>




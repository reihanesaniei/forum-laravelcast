<div class="row mb-3">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                Channels
            </div>
            <div class="card-body">
                @if(count($channels) > 0)
                    @foreach($channels as $channel)
                        @if($channel)
                           <a href="/discuss/channels/{{$channel->slug}}" class="card-title" style="display: block">{!! $channel->name !!}</a>
                        @else
                            <div class="card-link">
                                <h4> Channel is empty</h4>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="card-link">
                        <h4>There are no Channels</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>





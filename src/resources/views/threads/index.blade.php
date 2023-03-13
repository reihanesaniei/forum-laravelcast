@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include ('threads._list')

{{--                {{ $threads->links() }}--}}
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

               @include ('threads.channels')




            </div>
        </div>
    </div>
@endsection


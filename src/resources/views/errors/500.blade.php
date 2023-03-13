@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-xs-12">
            <div class="error-page">
                <div class="mt-error">
                    <h1 data-h1="500">500</h1>
                    <p data-p="SERVER ERROR">SERVER ERROR</p>
                </div>
            </div>
            <a href="/home" class="back">GO BACK</a>

            <div id="tsparticles"></div>
        </div>
    </div>
@endsection

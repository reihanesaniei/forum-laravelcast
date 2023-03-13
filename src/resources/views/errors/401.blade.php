@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-xs-12">
            <div class="error-page">
                <div class="mt-error">
                    <h1 data-h1="401">401</h1>
            <p data-p="UNAUTHORIZED">UNAUTHORIZED</p>
                </div>
            </div>
            <a href="/home" class="back">GO BACK</a>

            <div id="tsparticles"></div>
        </div>
    </div>
@endsection

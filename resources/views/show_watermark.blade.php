@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1>Laravel Add Watermark</h1>

                    <img src="{{$new_image}}" alt="Watermark">

                </div>
            </div>
        </div>
    </div>
@endsection

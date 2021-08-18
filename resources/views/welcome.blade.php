@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="/home" class="btn btn-warning">Upload</a>
    </div>
    <div class="container mt-2">
        <div class="row">

            @forelse($images as $image)
{{--                @dd($image->$image)--}}
                <div class="col-xl-4 col-lg-4 col-md-6 col-xs-12">
                    <div class="card">
                        <img src="{{asset($image['image'])}}" class="card-img-top" alt="Broken" height="220">
                        <div class="card-body">
                            <form action="">
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <h1 class="text-danger"></h1>
            @endforelse
        </div>
    </div>
@endsection

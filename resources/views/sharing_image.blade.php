@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="/home" class="btn btn-warning">Upload</a>
        <a data-pin-do="buttonBookmark" data-pin-tall="true" href="https://www.pinterest.com/pin/create/button/"></a>

    </div>
    <form action="{{route('sharingImage')}}" method="post" id="form-1">
        @method('post')
        @csrf
        <div class="container mt-2">

            <div class="row">

                @foreach($images as $image)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card mb-4">
                            <a href="{{route('showImage',$image['id'])}}"> <img src="{{asset($image['image'])}}"
                                                                                class="card-img-top" alt="Broken" title="Сlick on the photo to work with the photo"></a>

                        <div class="card-body">
                            <a href="{{route('showImage',$image['id'])}}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">add watermark</a>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
@endsection

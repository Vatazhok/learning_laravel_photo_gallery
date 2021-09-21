@extends('app')
@section('content')
    <div class="container">
        <a href="/home" class="btn btn-warning">Upload</a>
        <a data-pin-do="buttonBookmark" data-pin-tall="true" href="https://www.pinterest.com/pin/create/button/"></a>
        <label class="btn btn-dark mb-0" for="submit-form" tabindex="0">Share selected</label>

    </div>
    <form action="{{route('sharingImage')}}" method="post" id="form-1">
        @method('post')
        @csrf
        <div class="container mt-2">
            <div class="row">

                @foreach($images as $image)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="card mb-4">
                            <label class="m-0"><input type="checkbox" name="checkbox[]" class="form-check-input mb-0"
                                                      value="{{$image->id}}" form="form-1"></label>
                            <input type="submit" value="" id="submit-form" class="hidden" style="display:none">
                            <a href="{{asset($image['image'])}}"> <img src="{{asset($image['image'])}}"
                                                                       class="card-img-top" alt="Broken"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
    <div class="row justify-content-center">
{{--        @dd($image)--}}
        {{$images->links('vendor.pagination.bootstrap-4')}}
    </div>


    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
@endsection

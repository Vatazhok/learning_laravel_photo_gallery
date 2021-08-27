@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="/home" class="btn btn-warning">Upload</a>
        <a data-pin-do="buttonBookmark" data-pin-tall="true" href="https://www.pinterest.com/pin/create/button/"></a>
{{--                <label for="submit-form" tabindex="0">Додати вод знак</label>--}}
        <label class="btn btn-dark mb-0" for="submit-form" tabindex="0">Delete image and image with watermark</label>
    </div>
    {{--    <form action="{{route('sharingImage')}}" method="post" id="form-1" >--}}
    {{--        @method('post')--}}
    {{--        @csrf--}}
    <div class="container mt-2">

        <div class="row">
            {{--                @foreach($images as $image)--}}
            {{--                                        @dd($images[0])--}}
            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                <div class="card mb-4">
                    <form action="/image/{{$images[0]['id']}}" method="post" id="form-1" >
                                @method('DELETE')
                                @csrf
                    <a href="{{asset($images[0]['image'])}}"> <img src="{{asset($images[0]['image'])}}"
                                                                   class="card-img-top" alt="Broken" height="350"></a>
                    <input type="submit" value="" id="submit-form" class="hidden" style="display:none">
                    </form>
                </div>
            </div>

            {{--                @endforeach--}}
            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                <div class="col-xl-4">
                    <form action="/watermark/{{$images[0]['id']}}" method="post" id="form-2">
                        @method('GET')
                        @csrf
                        <input type="checkbox" name="checkbox" class="form-check-input mb-0"
                               value="images/adguard-watermark.png" form="form-2">
                        <img src="/images/adguard-watermark.png"
                             class="card-img-top" alt="Broken">
                        <input type="checkbox" name="checkbox" class="form-check-input mb-0"
                               value="images/draft-watermark.png" form="form-2">
                        <img src="/images/draft-watermark.png"
                             class="card-img-top" alt="Broken">
                        <input type="checkbox" name="checkbox" class="form-check-input mb-0"
                               value="images/icon-documents.png" form="form-2">
                        <img src="/images/icon-documents.png"
                             class="card-img-top" alt="Broken">

                        <button type="submit" class="btn btn-primary">add watermark</button>
                    </form>
                </div>
            </div>

            @foreach($watermarkImage as $watImg)
                <a href="{{asset($watImg['image'])}}"> <img src="{{asset($watImg['image'])}}" class="card-img-top"
                                                           alt="Broken" height="220"></a>

                <form action="/delete-watermark/{{$watImg['id']}}" method="post" id="form-3">
                    @method('delete')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-danger" form="form-3">
                </form>
            @endforeach
        </div>


    </div>
    {{--    </form>--}}





    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form action="/image" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="file" name="image[]" class="form-control-image" multiple accept="image/*">
                            </div>
                            <input type="submit" value="Upload" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <hr>
        <h3>Them moi Blog</h3>
        <hr>
        <form action="{{ route('blogs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="">
                        <div class="error">
                            @if ($errors->any())
                                <p style="color: red">{{ $errors->first('title') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control" id="">
                        <div class="error">
                            @if ($errors->any())
                                <p style="color: red">{{ $errors->first('image') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea name="content" class="form-control" style="height: 98px" id="description">{{ old('content') }}</textarea>
                        <div class="error">
                            @if ($errors->any())
                                <p style="color: red">{{ $errors->first('content') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="button" style="text-align: center">
                <button type="submit" class="btn btn-success">Them moi</button>
                <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Huy</a>
            </div>
        </form>
    </div>
@endsection

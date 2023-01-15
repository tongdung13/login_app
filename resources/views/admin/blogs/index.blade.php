@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-6">
                <h3>Danh sach Blog</h3>
            </div>
            <div class="col-6" style="text-align: right">
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">Them moi</a>
            </div>
        </div>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Title</td>
                    <td>Content</td>
                    <td>Image</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @if($blogs->isEmpty())
                    <tr>
                        <td colspan="12" style="color: red">
                            <p>Khong co du lieu</p>
                        </td>
                    </tr>
                @else
                    @foreach ($blogs as $key => $blog)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>
                                <textarea cols="30" rows="2">{{ $blog->content }}</textarea>
                            </td>
                            <td>
                                <img src="{{ $blog->image }}" alt="" srcset="{{ $blog->image }}" style="width: 100px">
                            </td>
                            <td>
                                <a href="" class="btn btn-warning">Edit</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

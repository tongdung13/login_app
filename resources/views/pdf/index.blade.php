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
                    <td>File name</td>

                </tr>
            </thead>
            <tbody>
                @if($pdf->isEmpty())
                    <tr>
                        <td colspan="12" style="color: red">
                            <p>Khong co du lieu</p>
                        </td>
                    </tr>
                @else
                    @foreach ($pdf as $key => $blog)
                        <tr>
                            <td>{{ ++$key }}</td>

                            <td>
                                <a href="{{ $blog->file_name }}">File Pdf</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

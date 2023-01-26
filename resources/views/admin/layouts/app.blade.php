<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        nav a {
            text-decoration: none;
            font-size: 22px;
        }
    </style>
    @yield('style')
</head>

<body>
    <nav class="navbar bg-dark" data-bs-theme="dark">
        <div class="container">
            <a href="">Home</a>
        </div>
    </nav>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" style="margin: 0;word-wrap: break-word;">
                <p>{!! session('success') !!}</p>
            </div>
        @endif
        {{-- @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p id="error" style="color: red">{!! $error !!}</p>
            @endforeach
        @endif --}}
    </div>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="{{ asset('ckeditor4/ckeditor/ckeditor.js') }}"></script>
    <script>
       CKEDITOR.replace( 'content' );
    </script>
</body>

</html>

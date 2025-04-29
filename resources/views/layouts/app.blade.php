<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tambahkan link CSS jika ada --}}
</head>
<body>

    {{-- Panggil navbar dari folder template --}}
    @include('templates.navbar')

    <div class="content">
        @yield('content')
    </div>

    @include('templates.footer')

    {{-- Tambahkan script JS jika perlu --}}
</body>
</html>

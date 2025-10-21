<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="bdCalling IT Ltd.">
    <meta name="keywords" content="pure_water_innovation">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @include('frontend.partials.styles')
</head>

<body>
{{-- Header --}}
@include('frontend.partials.header')
{{-- Header --}}

@yield('content')


{{-- Header --}}
@include('frontend.partials.footer')
{{-- Header --}}

@include('frontend.partials.scripts')
</body>

</html>

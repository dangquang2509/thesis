<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    @yield('meta')
    <title>@yield('title')</title>
    <!-- Head CSS -->
    
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/ionicons.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/jquery.fancybox.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/jquery.bxslider.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/owl.carousel.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/owl.theme.default.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/select2.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/style.css') !!}">
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery-3.2.1.min.js') !!}"></script>
    @yield('css')
</head>
<body>
    @yield('header')

    <!-- Content  START -->
    @yield('content')
    <!-- Content END -->

    @include('layout-user.footer')
</body>
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery.SmoothScroll.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/bootbox.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery.fancybox.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery.bxslider.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/owl.carousel.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/script.js') !!}"></script>
    @yield('js')
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#scroll-top").click(function(){
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    </script>
</html>


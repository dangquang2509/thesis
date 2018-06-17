<!DOCTYPE html>
<html lang="en">
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

	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/common-sphone.css') !!}" media="screen and (max-width: 767px)" />
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/common-tablet.css') !!}" media="screen and (min-width: 768px) and (max-width: 1023px)" />
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/common.css') !!}" media="screen and (min-width: 1024px)" />

    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/top-sphone.css') !!}" media="screen and (max-width: 767px)" />
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/top-tablet.css') !!}" media="screen and (min-width: 768px) and (max-width: 1023px)" />
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/top.css') !!}" media="screen and (min-width: 1024px)" />
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/fontawesome-all.css') !!}">
    
	@yield('css')
</head>
<body>
	@yield('header')

	<!-- Content  START -->
	<div class="ot-container">
			@yield('content')

			@include('layout.menu')
	</div>
	<!-- Content END -->

	@yield('popup')

	@include('layout.footer')
</body>
	<script src="{!! asset('resource/js/lib/jquery-1.12.4.min.js') !!}"></script>
	<script src="{!! asset('resource/js/lib/bootstrap.min.js') !!}"></script>
	<script src="{!! asset('resource/js/lib/datatables/datatables.min.js') !!}"></script>
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


@extends('layout.main')

@section('title', $title)

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/bootstrap.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/ionicons.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/jquery.fancybox.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/jquery.bxslider.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/owl.carousel.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/owl.theme.default.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/select2.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/style.css') !!}">
    <style>
    	.ot-footer {
    		display: none;
    	}
    	footer {
    		margin-top: 24px;
    	}
    	body {
    		background-color: #edf2f5;
    	}
    	#main-menu {
    		background-color: #0c244c;
    	}
    	.ot-container {
    		margin-top: 72px;
    		width: 100%;
    	}
    	.menu-padding {
    		margin-top: 0;
    		padding-top: 0;
    	}
    	.section-title {
    		margin-left: 134px;
    		font-weight: bold;
    		padding: 8px 0;
    	}
    	.property, .properties , .property-content, .ot-content {
    		margin: 0 auto;
    		width: 80%;
    	}
    	section.property .base-infos-container .base-infos {
    		width: 100%;
    		background: white;
    	}
    	section.property .base-infos .list-info {
    		color: black;
    	}
    	.description {
    		color: black;
    	}
    </style>
@stop

@section('header')
	<header>
	    <nav class="navbar navbar-inverse" id="main-menu">
	        <div class="container">
	            <a class="navbar-brand" href="#">
	            </a>
	            <div class="navbar-header pull-right">
	                <a class="phone-number" href="tel:0922 11 39 30">
	                    <i class="icon ion-ios-telephone-outline"></i> <span>0908 41 64 84</span>
	                </a>
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span> 
	                </button>
	            </div>
	            <div class="collapse navbar-collapse pull-right" id="myNavbar">
	                <ul class="nav navbar-nav navbar-right">
	                    <li><a href="/user/home">Home</a></li>
	                    <li><a href="/user/all">Rent</a></li>
	                    <li><a href="/user/contact">Contact</a></li>
	                    <li><a href="#">Log In</a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	</header>
@stop

@section('content')
	@foreach($house as $house)
	<div class="ot-image-detail-content">
		<div class="pano-area">
			<!-- <blockquote data-width="1000" data-height="400" class="ricoh-theta-tour-image" ><a href="https://onetech.theta360.biz/t/d15eca62-8895-11e7-bed7-0a4f4743bc83-1"></a></blockquote><script async src="https://onetech.theta360.biz/t_widgets.js" charset="utf-8"></script> -->
			<div id="pano" style="width:100%;height:100%;">
				<noscript>
					<table style="width:100%;height:100%;">
						<tr style="vertical-align:middle;">
							<td>
								<div style="text-align:center;">ERROR:
									<br/>
									<br/>
									Javascript not activated
									<br/>
									<br/>
								</div>
							</td>
						</tr>
					</table>
				</noscript>
			</div>
		</div>
		<section class="property menu-padding sub-menu-padding">
			<div class="base-infos-container">
				<div class="base-infos">
					<div class="left-container">
						<h1 class="title yellow-text-gradient line-bottom">{{ $house->title }}</h1>
						<div class="description">
							<p>{{ $house->description }}</p>
						</div>
						<div class="list-info">
							<div class="property-type">{{ $house->category_name }}</div>
							<div class="property-price"><big>$600</big> / month</div>
							<ul class="more-info">
								<li><big>3</big> Bedrooms</li>
								<li><big>3</big> Toilets</li>
								<li><big>108</big> m<sup>2</sup></li>
							</ul>
						</div>
						<div class="text-right"><a href="#" class="btn-yellow">Contact Agent</a></div>
					</div>
				</div>
			</div>
		</section>
		<h3 class="section-title">About this house</h3>
		<div class="ot-content">
			<input type="hidden" value="{{ $house->id }}" class="tour_id" name="tour_key">
			<div class="ot-image-detail-row">
				<div><a href="/house/full/{{ $house->id }}" target="_blank" class="btn-yellow">View house with full screen</a></div>
			</div>
			<div class="ot-image-detail-row">
				<!-- <div class="ot-image-detail-label"><a href="javascript:void(0)" class="embed-code js-embed-code ot-embed-link">Embeded</a></div> -->
				<div class="ot-image-detail-label">Iframe</div>
				<div class="ot-image-detail-value">
					<textarea rows="4" readonly class="js-embed-code select"></textarea>
				</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Amenities</div>
				<div class="ot-image-detail-value">large double beds, big wardrobes, microwave, chimney, big refrigerator, washing machine</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Project Facility</div>
				<div class="ot-image-detail-value">parking lot, Vincom Center, Vinmec, Vinschool, fitness centers, resort-style pool, children's playground, convenient stores</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Traffic</div>
				<div class="ot-image-detail-value">located in the Tan Cang area, stretches over 1km on the banks of the Saigon River and is one of the stops of the Ben Thanh - Suoi Tien subway system</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Notice</div>
				<div class="ot-image-detail-value">The rental price excludes management fee</div>
			</div>
			<input type="text" name="tour_id" value="{{ $house->id }}" style="display:none">
		</div>
	</div>
	@endforeach
	<section class="property-content bg-smooth blur">
		<div class="block">
			<div class="map">
				<div class="container">
					<div class="content">
						<h2>Location</h2>
						<p>Masteri Thao Dien, District 2</p>
					</div>
				</div>
				<div id="map-1" class="ggmap"></div>
				
			</div>
		</div>
	</section>
	<h3 class="section-title">You may also like</h3>
	<section class="properties">
		@foreach($houseSimilar as $house)
		<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/{{ $house->image_thumbnail }});">
			<div class="overlay"></div>
			<div class="center-position">
				<div class="property-container">
					<h2 class="title">{{ $house->title }}</h2>
					<div class="price-tag"><span class="price">$1,000</span> <span class="tag">- 2 Bedrooms</span></div>
					<div class="description">
						<p>{{ $house->description }}</p>
					</div>
					<a href="/user/detail/{{ $house->id }}" class="btn-white viewmore">View Details</a>
				</div>
			</div>
		</div>
		@endforeach
	</section>
	<footer>
	    <div class="top-footer">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-3 col-sm-6 col-xs-12">
	                    <div class="box-item">
	                        <div class="title-footer title-footer-1">
	                            <h3 class="yellow-text-gradient">Address</h3>
	                        </div>
	                        <div class="box-info">
	                            <p>18/11 Phu Dong Thien Vuong Street, District 5, Ho Chi Minh City</p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12">
	                    <div class="box-item">
	                        <div class="title-footer title-footer-2">
	                            <h3 class="yellow-text-gradient">Customer Service</h3>
	                        </div>
	                        <div class="box-info">
	                            <p><a href="tel:0908.41.64.84">0908.41.64.84</a></p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12">
	                    <div class="box-item">
	                        <div class="title-footer title-footer-3">
	                            <h3 class="yellow-text-gradient">Email</h3>
	                        </div>
	                        <div class="box-info">
	                            <p><a href="mailto:hello@munkas.com">hello@gmail.com</a></p>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12">
	                    <div class="box-item">
	                        <div class="title-footer title-footer-4">
	                            <h3 class="yellow-text-gradient">Connect with us</h3>
	                        </div>
	                        <div class="box-info">
	                            <ul class="list-social">
	                                <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
	                                <li><a href="#"><i class="icon ion-social-youtube"></i></a></li>
	                                <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="bot-footer">
	        <p>Copyright © 2018. All Rights Reserved.</p>
	    </div>
	</footer>
	<div id="scroll-top">
	    <i class="icon ion-ios-arrow-up"></i>
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('vtour/tour.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/user/jquery.SmoothScroll.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/select2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/bootbox.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery.fancybox.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/jquery.bxslider.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/owl.carousel.min.js') !!}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>

	<script type="text/javascript">

	 	$(document).ready(function() {
			var locationCompany = {lat: -31.563910, lng: 147.154312};
			if ($("#map-1").length > 0){
				var map = new google.maps.Map(document.getElementById('map-1'), {
					zoom: 10,
					center: locationCompany
				});
				var marker = new google.maps.Marker({
					map: map,
					draggable: true,
					position: new google.maps.LatLng(locationCompany.lat, locationCompany.lng),
					visible: true,
					icon: "images/map-marker.png"
				});
			}
			
			embedpano({swf:"/vtour/tour.swf", xml:"/{{ $house->xml_url }}", target:"pano", consolelog: "false"});
			var width = 600;
			var height = 400;
			var krpano = document.getElementById("krpanoSWFObject");
			var scene = krpano.get("xml.scene");
			var link = "&start_scene=" + scene;
			link = window.location.href.replace("admincp/house", "house/full").replace("detail/", "") + link;
			var leftPosition, topPosition;
			leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
			topPosition = (window.screen.height / 2) - ((height / 2) + 50);
			var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
			u = link;
			t = document.title;
			var embed_code = '<iframe src="' + link + '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="0" width="100%" height="100%"></iframe>';
			$(".js-embed-code").text(embed_code);
			$(".js-view-url").text(link);

		});

	</script>
@stop

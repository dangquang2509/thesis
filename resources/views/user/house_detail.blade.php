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
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/fontawesome-all.css') !!}">
	<style>
		.ot-footer {
			display: none;
		}
		footer {
			margin-top: 24px;
		}
		body {
			background-color: #fff;
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
		.ot-content {
			padding: 12px;
		}
		section.property .base-infos-container .base-infos {
			width: 100%;
			background: white;
			padding: 32px;
		}
		section.property .base-infos .list-info {
			color: black;
		}
		.description {
			color: black;
		}

		.pac-card {
			margin: 10px 10px 0 0;
			border-radius: 2px 0 0 2px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			outline: none;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
			background-color: #fff;
			font-family: Roboto;
		}

		#pac-container {
			padding-bottom: 12px;
			margin-right: 12px;
		}

		.pac-controls {
			display: inline-block;
			padding: 5px 11px;
		}

		.pac-controls label {
			font-family: Roboto;
			font-size: 13px;
			font-weight: 300;
		}

		#pac-input {
			background-color: #fff;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			margin-left: 12px;
			padding: 0 11px 0 13px;
			text-overflow: ellipsis;
			width: 400px;
		}

		#pac-input:focus {
			border-color: #4d90fe;
		}

		.icon-favorite {
			font-size: 30px;
			cursor: pointer;
			color: #947054;
		}
		#collapseExample {
			margin-top: 12px;
		}
		.single-featured-property {
		    position: relative;
		    z-index: 1;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		    overflow: hidden;
		}
		.single-featured-property .property-thumb {
			position: relative;
			z-index: 1;
		}
		.single-featured-property .property-content {
		    padding: 14px;
    		border: 1px solid #e1dddd;
    		width: 100%;
    		background: #fff;
		}
		.single-featured-property .property-thumb .tag span {
			height: 35px;
		    padding: 0 20px;
		    background-color: #947054;
		    color: #ffffff;
		    text-transform: uppercase;
		    font-size: 12px;
		    font-weight: 600;
		    display: inline-block;
		    line-height: 35px;
		    position: absolute;
		    top: 20px;
		    left: 20px;
		    z-index: 10;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		}
		.single-featured-property .property-thumb .list-price p {
			background-color: #ffffff;
		    padding: 10px 20px;
		    color: #947054;
		    font-size: 24px;
		    font-weight: 600;
		    display: inline-block;
		    position: absolute;
		    bottom: 20px;
		    left: 20px;
		    z-index: 10;
		    margin-bottom: 0;
		    line-height: 1;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		}
		.single-featured-property .property-content h5 {
			font-size: 18px;
			width: 100%;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.single-featured-property .property-content .location {
			color: #947054;
		    margin-bottom: 25px;
		    font-size: 14px;
		    font-weight: 600;
		}
		.single-featured-property .property-content .location img {
		    margin-right: 10px;
		    display: inline-block !important;
		    width: auto !important;
		}
		.single-featured-property .property-content p {
			margin-bottom: 30px;
			width: 100%;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.single-featured-property .property-content .property-meta-data img {
			margin-right: 0;
		    display: inline-block !important;
		    width: auto !important;
		}
		.single-featured-property .property-content .property-meta-data span {
		    font-size: 12px;
		    font-weight: 600;
		    margin-left: 5px;
		    color: #838383;
		}
		.justify-content-between {
		    -webkit-box-pack: justify;
		    -ms-flex-pack: justify;
		    justify-content: space-between;
		    display: inline-block;
		}
		.justify-content-between div {
			display: inline-block;
			margin-right: 16px;
		}
		.listings-content-wrapper {
			margin-top: 16px;
			padding: 0;
		}
	</style>
@stop

@section('header')
	<header>
	    <nav class="navbar navbar-inverse sticky" id="main-menu">
	        <div class="container">
	            <a class="navbar-brand" href="#">
	                <!-- <img src="images/logo-cong-thong-tin-bds.png" alt=""> -->
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
	                    <li>
	                        <a href="/">Home</a>
	                    </li>
	                    <li>
	                        <a href="/all">Rent</a>
	                    </li>
	                    <li>
	                        <a href="/wishlist">Wishlist</a>
	                    </li>
	                    <li>
	                        <a href="/contact">Contact</a>
	                    </li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	</header>

@stop

@section('content')
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
					<div class="">
						<div>
							<h5><i class="fa fa-eye"></i> {{ $house->num_views }} views</h5>
						</div>
						<div class="text-right">
							@if($house->fav)
								<span class="glyphicon glyphicon-heart js-add-wishlist icon-favorite"></span>
							@else
								<span class="glyphicon glyphicon-heart-empty js-add-wishlist icon-favorite"></span>
							@endif
						</div>
						<h1 class="title line-bottom">{{ $house->title }}</h1>

						<div class="description">
							<p>{{ $house->description }}</p>
						</div>
						<div class="list-info">
							<div class="property-type">{{ $house->category_name }}</div>
							<div class="property-price"><big>${{ $house->price }}</big> / month</div>
							<ul class="more-info">
								<li><big><i class="fa fa-bed"></i> {{ $house->num_bedrooms }}</big> bedroom(s)</li>
								<li><big><i class="fa fa-bath"></i> {{ $house->num_toilets }}</big> bathroom(s)</li>
								<li><big><i class="fa fa-chart-area"></i> {{ $house->area }}</big> m<sup>2</sup></li>
							</ul>
						</div>
						<div class="text-right"><a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="btn-yellow">Contact Agent</a></div>
						<div class="collapse" id="collapseExample">
							<!-- <form class="form-contact-agent" method="POST" action="/contactAgent"> -->
								<div class="form-group">
									<input type="text" class="form-control js-input-name" name="name" placeholder="Name">
								</div>
								<div class="form-group">
									<input type="text" class="form-control js-input-phone" name="phone" placeholder="Phone">
								</div>
								<div class="form-group">
									<input type="email" class="form-control js-input-email" name="email" placeholder="Email">
								</div>
								<div class="form-group">
									<textarea class="form-control js-input-message" name="message" placeholder="Message" rows="3"></textarea>
								</div>
								<input type="hidden" class="js-house-id" value="{{ $house->id }}">
								<input type="hidden" class="js-house-xml" value="{{ $house->xml_url }}">
							<button type="submit" class="btn-yellow js-contact-agent">Submit</button>
							<!-- </form> -->
						</div>
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
			<!-- <div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Iframe</div>
				<div class="ot-image-detail-value">
					<textarea rows="4" readonly class="js-embed-code select"></textarea>
				</div>
			</div> -->
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Amenities</div>
				<div class="ot-image-detail-value">{{ $house->amenities }}</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Project Facility</div>
				<div class="ot-image-detail-value">{{ $house->project_facility }}</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Traffic</div>
				<div class="ot-image-detail-value">{{ $house->traffic }}</div>
			</div>
			<div class="ot-image-detail-row">
				<div class="ot-image-detail-label">Notice</div>
				<div class="ot-image-detail-value">{{ $house->notice }}</div>
			</div>
			<input type="text" name="tour_id" value="{{ $house->id }}" style="display:none">
		</div>
	</div>
	<section class="property-content bg-smooth blur">
		<div class="block">
			<div class="map">
				<div class="container">
					<div class="content">
						<h2>Location</h2>
						<p class="js-address">{{ $house->address }}</p>
					</div>
				</div>
				<div id="map-1" class="ggmap"></div>
			</div>
		</div>
	</section>
	<h3 class="section-title">Similar Listings</h3>
	<section class="listings-content-wrapper ot-content">
		<div class="container">
			<div class="row">
				@foreach($houseSimilar as $house)
				<!-- Single Featured Property -->
	                <div class="col-md-4 col-sm-12">
	                    <div class="single-featured-property mb-50">
	                        <!-- Property Thumbnail -->
	                        <div class="property-thumb">
	                            <a href="/detail/{{ $house->id }}">
	                            	<img class="img-responsive" src="/uploads/images/{{ $house->image_thumbnail }}" alt="">
	                            </a>
	                            <div class="tag">
	                                <span>For Rent</span>
	                            </div>
	                            <div class="list-price">
	                                <p>${{ $house->price }}</p>
	                            </div>
	                        </div>
	                        <!-- Property Content -->
	                        <div class="property-content">
	                            <h5>{{ $house->title }}</h5>
	                            <p class="location"><img src="resource/img/icon/location.png" alt="">District {{ $house->district }}</p>
	                            <p>{{ $house->description }}</p>
	                            <div class="property-meta-data d-flex align-items-end justify-content-between">
	                                <div class="bathroom">
	                                    <img src="resource/img/icon/bathtub.png" alt="">
	                                    <span>{{ $house->num_toilets }} bath</span>
	                                </div>
	                                <div class="garage">
	                                    <img src="resource/img/icon/garage.png" alt="">
	                                    <span>{{ $house->num_bedrooms }} bed</span>
	                                </div>
	                                <div class="space">
	                                    <img src="resource/img/icon/space.png" alt="">
	                                    <span>{{ $house->area }} m<sup>2</sup></span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
				@endforeach
			</div>
		</div>
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

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c&libraries=places"></script>
	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
	<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
    <script type="text/javascript" src="{!! asset('resource/js/user/script.js') !!}"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			var lat = parseFloat('{{ $house->latitude }}');
			var lng = parseFloat('{{ $house->longitude }}');
			
			var locationHouse = {lat: lat, lng: lng};
			
			if ($("#map-1").length > 0) {
				var map = new google.maps.Map(document.getElementById('map-1'), {
					zoom: 15,
					center: locationHouse
				});
				var marker = new google.maps.Marker({
					map: map,
					draggable: false,
					position: new google.maps.LatLng(locationHouse.lat, locationHouse.lng),
					visible: true,
					icon: "images/map-marker.png"
				});
			}
			var house_xml = $(".js-house-xml").val();
			var house_id = $(".tour_id").val();
			embedpano({swf:"/vtour/tour.swf", xml:"/" + house_xml, target:"pano", consolelog: "false"});
			var width = 600;
			var height = 400;
			var krpano = document.getElementById("krpanoSWFObject");
			var scene = krpano.get("xml.scene");
			var link = "&start_scene=" + scene;
			link = window.location.origin + "/house/full/" + house_id + link;
			var leftPosition, topPosition;
			leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
			topPosition = (window.screen.height / 2) - ((height / 2) + 50);
			var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
			u = link;
			t = document.title;
			// var embed_code = '<iframe src="' + link + '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="0" width="100%" height="100%"></iframe>';
			// $(".js-embed-code").text(embed_code);
			$(".js-view-url").text(link);
		});

	</script>
@stop

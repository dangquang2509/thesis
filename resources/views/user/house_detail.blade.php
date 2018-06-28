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
			margin-left: 62px;
			font-weight: bold;
			padding: 8px 0;
		}
		.property, .properties , .property-content, .ot-content {
			margin: 0 auto;
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

		/*new layout*/
		.listings-content {
			margin-top: 42px;
		}
		.listings-content .list-price p {
			margin-bottom: 0;
		    font-size: 28px;
		    font-weight: 600;
		    color: #947054;
		}
		.listings-content h5 {
			font-size: 30px;
    		margin-bottom: 10px;
    		font-weight: bold;
		}
		.listings-content .location {
			margin-bottom: 40px;
		}
		.listings-content p {
			margin-bottom: 30px;
		}
		.property-meta-data div {
			display: inline-block;
			margin-right: 24px;
		}
		.property-meta-data img {
			margin-right: 6px;
		}
		.contact-realtor-wrapper {
			background-color: #f5f5f5;
		    margin-top: 42px;
		    position: relative;
		    z-index: 1;
		}
		.contact-realtor-wrapper .realtor-info > img {
			width: 100%;
		}
		.contact-realtor-wrapper .realtor---info {
			padding: 20px 36px;
		}
		.contact-realtor-wrapper .realtor---info h2 {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 32px;
		}
		.contact-realtor-wrapper .realtor---info h6 {
			font-size: 14px;
			margin-bottom: 8px;
		}
		.contact-realtor-wrapper .realtor--contact-form {
			padding: 0 36px 32px;
		}
		.realtor--contact-form form {
			background: #f5f5f5;
		}
		.realtor--contact-form form textarea {
			resize: none;
		}
		.south-btn {
			position: relative;
		    z-index: 1;
		    min-width: 150px;
		    color: #ffffff;
		    font-size: 14px;
		    font-weight: 600;
		    background-color: #947054;
		    border-radius: 0;
		    padding: 10px 20px;
		}
		.black-btn {
			background: #000;
		}
		.span-view {
			font-size: 14px;
		}
		.listings-btn-groups {
			margin-top: 18px;
		}
		.other-info {
			margin-top: 36px;
		}

		/*image slider*/

		/* Slideshow container */
		.slideshow-container {
		  max-width: 1000px;
		  position: relative;
		  margin: auto;
		}

		/* Next & previous buttons */
		.prev, .next {
		  cursor: pointer;
		  position: absolute;
		  top: 50%;
		  width: auto;
		  padding: 16px;
		  margin-top: -22px;
		  color: white;
		  font-weight: bold;
		  font-size: 18px;
		  transition: 0.6s ease;
		  border-radius: 0 3px 3px 0;
		}

		/* Position the "next button" to the right */
		.next {
		  right: 0;
		  border-radius: 3px 0 0 3px;
		}

		/* On hover, add a black background color with a little bit see-through */
		.prev:hover, .next:hover {
		  background-color: rgba(0,0,0,0.6);
		}

		/* Caption text */
		.text {
		  color: #f2f2f2;
		  font-size: 15px;
		  padding: 8px 12px;
		  position: absolute;
		  bottom: 8px;
		  width: 100%;
		  text-align: center;
		}

		/* Number text (1/3 etc) */
		.numbertext {
		  color: #f2f2f2;
		  font-size: 12px;
		  padding: 8px 12px;
		  position: absolute;
		  top: 0;
		}

		/* The dots/bullets/indicators */
		.dot {
		  cursor: pointer;
		  height: 12px;
		  width: 12px;
		  margin: 0 2px;
		  background-color: #bbb;
		  border-radius: 50%;
		  display: inline-block;
		  transition: background-color 0.6s ease;
		}

		.active, .dot:hover {
		  background-color: #717171;
		}

		.modal {
			background: rgba(0,0,0,.6);
		}
		.gallery-house {
			list-style-type: none;
			margin: 18px 0;
		}
		.gallery-house img {
			cursor: pointer;
			max-height: 65px;
		}
		.gallery-house li {
			margin: 4px 0;
		}
		.single-accordion.panel {
			background-color: #ffffff;
		    border: 0 solid transparent;
		    border-radius: 4px;
		    box-shadow: 0 0 0 transparent;
		    margin-bottom: 15px;
		}
		.single-accordion h6 {
		    margin-bottom: 0;
    		text-transform: uppercase;
		}
		.single-accordion h6 a.collapsed {
			border: 2px solid #947054;
    		background-color: transparent;
    		color: #000000;
    		font-size: 16px;
		}
		.single-accordion h6 a {
			background-color: #947054;
		    border-radius: 0;
		    color: #ffffff;
		    display: block;
		    margin: 0;
		    padding: 15px 60px 15px 15px;
		    position: relative;
		    font-size: 16px;
		    text-transform: capitalize;
		    font-weight: 500;
		    border: 2px solid transparent;
		}
		.single-accordion h6 a span {
			font-size: 10px;
		    position: absolute;
		    right: 20px;
		    text-align: center;
		    top: 18px;
		}
		.single-accordion .accordion-content {
		    border-top: 0 solid transparent;
    		box-shadow: none;
		}
		.single-accordion .accordion-content p {
		    padding: 20px 15px 5px;
    		margin-bottom: 0;
    		font-size: 15px;
		}
		.amenities-list, .facilities-list {
			list-style-type: none;
			margin: 24px 0 0 0;
		}
		.amenities-list li, .facilities-list li {
			width: 30%;
			display: inline-block;
		    color: #323232;
		    font-size: 15px;
		    margin-bottom: 25px;
		}
		.amenities-list li i,
		.facilities-list li i {
			width: 27px;
		    height: 27px;
		    background-color: #947054;
		    color: #ffffff;
		    border-radius: 50%;
		    text-align: center;
		    line-height: 27px;
		    font-size: 12px;
		    margin-right: 10px;
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
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="listings-btn-groups">
                            <a href="/house/full/{{ $house->id }}" target="_blank" class="btn south-btn">VIEW FULL SCREEN</a>
                            <a class="btn south-btn black-btn" data-toggle="modal" data-target="#exampleModal" style="margin-left: 12px;">VIEW PHOTO</a>
                            <!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel"></h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <div class="slideshow-container">
							        	@if(count($photos) > 0) 
											@foreach($photos as $key => $value)
											<div class="mySlides">
											  <div class="numbertext">{{ $key + 1 }} / {{ count($photos) }}</div>
											  <img src="/uploads/images/{{ $value->image_url }}" style="width:100%">
											  <div class="text"></div>
											</div>
											@endforeach
										@endif
										<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
										<a class="next" onclick="plusSlides(1)">&#10095;</a>
									</div>
									<br>

									<div style="text-align:center">
									  @for ($i = 1; $i <= count($photos); $i++)
									  	<span class="dot" onclick="currentSlide({{ $i }})"></span> 
									  @endfor
									</div>
							      </div>
							    </div>
							  </div>
							</div>
                        </div>
					<div class="listings-content">
							<span class="span-view"><i class="fa fa-eye"></i> {{ $house->num_views }} views</span>
							@if($house->fav)
								<span class="pull-right glyphicon glyphicon-heart js-add-wishlist icon-favorite"></span>
							@else
								<span class="pull-right glyphicon glyphicon-heart-empty js-add-wishlist icon-favorite"></span>
							@endif
                        <!-- Price -->
                        <div class="list-price">
                            <p>${{ $house->price }}</p>
                        </div>
                        <h5>{{ $house->title }}</h5>
                        <p class="location"><img src="resource/img/icon/location.png" style="margin-right: 6px;" alt="">District {{ $house->district }}</p>
                        <p>{{ $house->description }}</p>
                        <!-- Meta -->
                        <div class="property-meta-data d-flex align-items-end">
                            <div class="bathroom">
                                <img src="resource/img/icon/bathtub.png" alt="">
                                <span>{{ $house->num_toilets }} bathroom(s)</span>
                            </div>
                            <div class="garage">
                                <img src="resource/img/icon/garage.png" alt="">
                                <span>{{ $house->num_bedrooms }} bedroom(s)</span>
                            </div>
                            <div class="space">
                                <img src="resource/img/icon/space.png" alt="">
                                <span>{{ $house->area }} m<sup>2</sup></span>
                            </div>
                        </div>
                        <ul class="gallery-house row">
                        	@foreach($photos as $photo)
                        		<li class="col-md-2">
                        			<a data-toggle="modal" data-target="#exampleModal"><img class="img-responsive" src="/uploads/images/{{ $photo->image_url }}"></a>
                        		</li>
                        	@endforeach
                        </ul>
                        <div class="other-info">
	                        <div class="panel single-accordion">
	                            <h6>
	                                <a role="button" aria-expanded="true" aria-controls="collapseAmenities" data-parent="#accordion" data-toggle="collapse" href="#collapseAmenities">AMENITIES
	                                <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
	                                </a>
	                            </h6>
	                            <div id="collapseAmenities" class="accordion-content collapse in">
	                                <ul class="amenities-list">

	                    			</ul>
	                            </div>
	                        </div>
	                        <div class="panel single-accordion">
	                            <h6>
	                                <a role="button" aria-expanded="true" aria-controls="collapseFacilities" data-parent="#accordion" data-toggle="collapse" href="#collapseFacilities">FACILITIES
	                                <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
	                                </a>
	                            </h6>
	                            <div id="collapseFacilities" class="accordion-content collapse in">
	                                <ul class="facilities-list">

	                    			</ul>
	                            </div>
	                        </div>
	                        <div class="panel single-accordion">
	                            <h6>
	                                <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTraffic" data-parent="#accordion" data-toggle="collapse" href="#collapseTraffic">TRAFFIC
	                                <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
	                                </a>
	                            </h6>
	                            <div id="collapseTraffic" class="accordion-content collapse">
	                                <p>{{ $house->traffic }}</p>
	                            </div>
	                        </div>
	                        <div class="panel single-accordion">
	                            <h6>
	                                <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseNotice" data-parent="#accordion" data-toggle="collapse" href="#collapseNotice">NOTICE
	                                <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
	                                </a>
	                            </h6>
	                            <div id="collapseNotice" class="accordion-content collapse">
	                                <p>{{ $house->notice }}</p>
	                            </div>
	                        </div>
	                    </div>
						<input type="hidden" class="js-house-facilities" value="{{ $house->facilities }}">
						<input type="hidden" class="js-house-amenities-c" value="{{ $house->amenities_c }}">
                    </div>
				</div>
				<div class="col-md-4">
					<div class="contact-realtor-wrapper">
                        <div class="realtor-info">
                            <img src="/{{ $user->avatar }}" alt="">
                            <div class="realtor---info">
                                <h2>{{ $user->name }}</h2>
                                <!-- <h6><img src="resource/img/icon/phone-call.png" alt="" style="margin-right: 8px"><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></h6> -->
                                <h6><img src="resource/img/icon/envelope.png" alt="" style="margin-right: 8px"><a href="mailto:{{ $user->email }}?Subject=" target="_top" >{{ $user->email }}</a></h6>
                            </div>
                            <div class="realtor--contact-form">
                                <div class="form-group">
                                    <input type="text" class="form-control js-input-name" name="name" placeholder="Your Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control js-input-phone" name="phone" placeholder="Your Number">
                                </div>
                                <div class="form-group">
                                    <input type="enumber" class="form-control js-input-email" placeholder="Your Email">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" class="form-control js-input-message" cols="30" rows="10" placeholder="Your Message"></textarea>
                                </div>
								<input type="hidden" class="js-house-id" value="{{ $house->id }}">
								<input type="hidden" class="js-house-xml" value="{{ $house->xml_url }}">
                                <button type="submit" class="btn south-btn js-contact-agent">Contact Agent</button>
                            </div>
                        </div>
                    </div>
				</div>	
			</div>
		</div>
	</div>
	<section class="property-content bg-smooth blur">
		<div class="container">
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
								<h3>Address</h3>
							</div>
							<div class="box-info">
								<p>18/11 Phu Dong Thien Vuong Street, District 5, Ho Chi Minh City</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="box-item">
							<div class="title-footer title-footer-2">
								<h3>Customer Service</h3>
							</div>
							<div class="box-info">
								<p><a href="tel:0908.41.64.84">0908.41.64.84</a></p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="box-item">
							<div class="title-footer title-footer-3">
								<h3>Email</h3>
							</div>
							<div class="box-info">
								<p><a href="mailto:hello@munkas.com">hello@gmail.com</a></p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="box-item">
							<div class="title-footer title-footer-4">
								<h3>Connect with us</h3>
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
			var embed_code = '<iframe src="' + link + '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="0" width="100%" height="100%"></iframe>';
			// $(".js-embed-code").text(embed_code);
			// $(".js-view-url").text(link);
		});


		// image slider
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
		  showSlides(slideIndex += n);
		}

		function currentSlide(n) {
		  showSlides(slideIndex = n);
		}

		function showSlides(n) {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("dot");
		  if (n > slides.length) {slideIndex = 1}    
		  if (n < 1) {slideIndex = slides.length}
		  for (i = 0; i < slides.length; i++) {
		      slides[i].style.display = "none";  
		  }
		  for (i = 0; i < dots.length; i++) {
		      dots[i].className = dots[i].className.replace(" active", "");
		  }
		  slides[slideIndex-1].style.display = "block";  
		  dots[slideIndex-1].className += " active";
		}

		// amenities section 
		if ($(".js-house-amenities-c").val()) {
			var amenities = JSON.parse($(".js-house-amenities-c").val());
			for (var k in amenities) {
				if (amenities[k] && k === "tv") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>TV</li>");
				}
				if (amenities[k] && k === "microwave") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Microwave</li>");
				}
				if (amenities[k] && k === "air") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Air Conditioner</li>");
				}
				if (amenities[k] && k === "smoke") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Smoke Detector</li>");
				}
				if (amenities[k] && k === "balcony") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Balcony</li>");
				}
				if (amenities[k] && k === "bath") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Bathtub</li>");
				}
				if (amenities[k] && k === "dish") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Dishwasher</li>");
				}
				if (amenities[k] && k === "wash") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Washing Machine</li>");
				}
				if (amenities[k] && k === "heater") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Room Heater</li>");
				}
				if (amenities[k] && k === "kitchen") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Kitchen</i>");
				}
				if (amenities[k] && k === "wifi") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Wifi</li>");
				}
				if (amenities[k] && k === "refrigerator") {
					$(".amenities-list").append("<li><i class='fa fa-check'></i>Refrigerator</li>");
				}
			}
		}

			// amenities section 
		if ($(".js-house-facilities").val()) {
			var facilities = JSON.parse($(".js-house-facilities").val());
			for (var k in facilities) {
				if (facilities[k] && k === "bank") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Banking/ATM</li>");
				}
				if (facilities[k] && k === "restaurant") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Restaurant</li>");
				}
				if (facilities[k] && k === "supermarket") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Supermarket</li>");
				}
				if (facilities[k] && k === "pharmacy") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Pharmacy</li>");
				}
				if (facilities[k] && k === "pool") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Pool</li>");
				}
				if (facilities[k] && k === "gym") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Gymnasium</li>");
				}
				if (facilities[k] && k === "mall") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Shopping Mall</li>");
				}
				if (facilities[k] && k === "parking") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Parking</li>");
				}
				if (facilities[k] && k === "school") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>School</li>");
				}
				if (facilities[k] && k === "playground") {
					$(".facilities-list").append("<li><i class='fa fa-check'></i>Playground</li>");
				}
			}
		}
	</script>
@stop

@extends('layout-user.main')

@section('title', 'Contact Us')

@section('content')
	<main id="contact">
		<section class="contact menu-padding">
			<div class="container">
				<!-- <div class="breadcrumb"><a href="">Trang chủ</a> / Tin tức</div> -->
			</div>
			<div class="infos">
				<div class="contact-info bg-smooth">
					<div class="left-container">
						<h1 class="title line-bottom line-yellow">Contact Information</h1>
						<h3>Find apartment for rent in Ho Chi Minh City</h3>
						<p><img src="resource/img/icon/location.png"> Address: 18/11 Phu Dong Thien Vuong, District 5, Ho Chi Minh City</p>
						<p><img src="resource/img/icon/phone-call.png">Hotline: 0908.41.64.84</p>
						<p><img src="resource/img/icon/envelope.png">Email: hello@gmail.com</p>
					</div>
				</div>
				<div class="contact-form">
					<div class="right-container">
						<form class="form-submit" action="/sendRequest" method="POST">
							{{ csrf_field() }}
							<div class="container-form">
								<h2 class="title line-bottom">Send Request</h2>
								<div class="submit-type-2">
									<div class="group-input">
										<label for="name">Name (*)</label>
										<input type="text" name="name" id="txt_name">
									</div>
									<div class="group-input">
										<label for="email">Email (*)</label>
										<input type="email" name="email">
									</div>
									<div class="group-input">
										<label for="phone">Phone Number (*)</label>
										<input type="text" name="phone">
									</div>
									<div class="group-input">
										<label for="address">Address</label>
										<input type="text" name="address">
									</div>
									<div class="group-input full">
										<label for="content">Content</label>
										<textarea rows="3" name="content"></textarea>
									</div>
									<div class="group-input full">
										<button class="btn-yellow submit js-send-request">Send</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<input type="hidden" value="{{ $houses }}" class="js-all-houses">
		<section class="map">
			<div id="mapCompany"></div>
		</section>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var locationCompany = {lat: 10.753369, lng: 106.662945}; 
				if ($("#mapCompany").length > 0){
					var map = new google.maps.Map(document.getElementById('mapCompany'), {
						zoom: 12,
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
			});
		</script>
	</main>
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
@stop

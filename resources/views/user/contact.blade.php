@extends('layout-user.main')

@section('title', 'Contact Us')

@section('header') 
	<header>
	    <nav class="navbar navbar-inverse" id="main-menu">
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
	                    <li><a href="/">Home</a></li>
	                    <li><a href="/all">Rent</a></li>
	                    <li class="active"><a href="#">Contact</a></li>
	                    <!-- <li><a href="#">Log In</a></li> -->
	                </ul>
	            </div>
	        </div>
	    </nav>
	</header>
@stop

@section('content')
	<main id="contact">
		<section class="contact menu-padding">
			<div class="container">
				<!-- <div class="breadcrumb"><a href="">Trang chủ</a> / Tin tức</div> -->
			</div>
			<div class="infos">
				<div class="contact-info bg-smooth">
					<div class="left-container">
						<h1 class="yellow-text-gradient title line-bottom line-yellow">Contact Information</h1>
						<h3>Find apartment for rent in Ho Chi Minh City</h3>
						<p>Address: 18/11 Phu Dong Thien Vuong, District 5, Ho Chi Minh City</p>
						<p>Hotline: 0908.41.64.84</p>
						<p>Email: hello@gmail.com</p>
					</div>
				</div>
				<div class="contact-form">
					<div class="right-container">
						<form class="form-submit" action="/sendRequest" method="POST">
							{{ csrf_field() }}
							<div class="container-form">
								<h2 class="title blue-text-gradient line-bottom">Send Request</h2>
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
				var locationCompany = {lat: -31.563910, lng: 147.154312};
				var locations = [];
				
				var houses = JSON.parse($(".js-all-houses").val());
				for (var i = 0; i <  houses.length; i++) {
					var location = {};
					location.lat = houses[i].latitude;
					location.lng = houses[i].longitude;
					
					var property = {};
					property.url = "/detail/" + houses[i].id;
					// property.thumb = "images/bg-form-home.jpg";
					property.thumb = "/uploads/images/" + houses[i].image_thumbnail;
					property.title = houses[i].title;
					property.price = "$600"
					
					location.property = property;
					
					locations.push(location);
				}
				var setupMap = {
					zoom: 10,
					icon_marker: "images/map-marker.png",
					icon_cluster: "images/cluster-icon.png"
				}

				if ($("#mapCompany").length > 0) {
					var map = new google.maps.Map(document.getElementById('mapCompany'), {
						zoom: setupMap['zoom'],
						center: centerMap()
					});
					var markers = [];
					locations.forEach(function(location){
						var marker = new google.maps.Marker({
							map: map,
							draggable: true,
							position: new google.maps.LatLng(location.lat, location.lng),
							visible: true,
							icon: setupMap['icon_marker']
						});
						markers.push(marker);

						setEventMarkerInfo(marker, map, location.property);
					})

					var markerClustererOptions = {
						ignoreHidden: true,
						maxZoom: 14,
						styles: [{
							textColor: '#ffffff',
							url: setupMap['icon_cluster'],
							height: 48,
							width: 48
						}]
					};

					var markerCluster = new MarkerClusterer(map, markers, markerClustererOptions);
				}
				function centerMap(){
					var centerMap = {lat: 0, lng: 0};
					locations.forEach(function(item){
						centerMap.lat += item.lat;
						centerMap.lng += item.lng;
					})
					centerMap.lat = centerMap.lat / locations.length;
					centerMap.lng = centerMap.lng / locations.length;
					return centerMap;
				}
				function setEventMarkerInfo(marker, map, property){
					var boxText = document.createElement("div");
					boxText.className = 'map-info-window';
					var innerHTML = "";
					if ( property.thumb ) {
						innerHTML += '<a class="thumb-link" href="' + property.url + '">' +
						'<img class="prop-thumb" src="' + property.thumb + '" alt="' + property.title + '"/>' +
						'</a>';
					}
					innerHTML += '<h5 class="prop-title"><a class="title-link" href="' + property.url + '">' + property.title + '</a></h5>';
					if ( property.price ) {
						innerHTML += '<p><span class="price">' + property.price + '</span></p>';
					}
					innerHTML += '<div class="arrow-down"></div>';
					boxText.innerHTML = innerHTML;

					var myOptions = {
						content: boxText
						,disableAutoPan: false
						,maxWidth: 0
						,boxStyle: { width: '240px' }
						,pixelOffset: new google.maps.Size(-120, -45)
						,zIndex: null
						,alignBottom: true
						,closeBoxMargin: "0 0 -16px -16px"
						,closeBoxURL: "images/close.png"
						,infoBoxClearance: new google.maps.Size(1, 1)
						,isHidden: false
						,pane: "floatPane"
						,enableEventPropagation: false
					};

					var ib = new InfoBox(myOptions);
					marker.addListener("click", function(){
						ib.open(map, marker);
					})
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

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
	                    <li><a href="#">Log In</a></li>
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
						<div class="container-form">
							<h2 class="title blue-text-gradient line-bottom">Send Request</h2>
							<div class="form-submit submit-type-2">
								<div class="group-input">
									<label for="txt_name">Name (*)</label>
									<input type="text" name="name" id="txt_name">
								</div>
								<div class="group-input">
									<label for="txt_name">Email (*)</label>
									<input type="text" name="">
								</div>
								<div class="group-input">
									<label for="txt_name">Phone Number (*)</label>
									<input type="text" name="">
								</div>
								<div class="group-input">
									<label for="txt_name">Address</label>
									<input type="text" name="">
								</div>
								<div class="group-input full">
									<label for="txt_name">Content</label>
									<textarea rows="3"></textarea>
								</div>
								<div class="group-input full">
									<button class="btn-yellow submit">Send</button>
								</div>
							</div>
						</div>
						.
					</div>
				</div>
			</div>
		</section>
		<section class="map">
			<div id="mapCompany"></div>
		</section>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var locationCompany = {lat: -31.563910, lng: 147.154312};
				if ($("#mapCompany").length > 0){
					var map = new google.maps.Map(document.getElementById('mapCompany'), {
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
			});
		</script>
	</main>
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>

    <script>
		$(document).ready(function() {
			var propertyDefault = {
				url: "",
				thumb: "images/bg-form-home.jpg",
				title: "Dự án bac",
				price: "124 Triệu/m<sup>2</sup>"
			};
			var locations = [
				{lat: -31.563910, lng: 147.154312, property: propertyDefault},
				{lat: -33.718234, lng: 150.363181, property: propertyDefault},
				{lat: -33.727111, lng: 150.371124, property: propertyDefault},
				{lat: -33.848588, lng: 151.209834, property: propertyDefault},
				{lat: -33.851702, lng: 151.216968, property: propertyDefault},
				{lat: -34.671264, lng: 150.863657, property: propertyDefault},
				{lat: -35.304724, lng: 148.662905, property: propertyDefault}
			]
			var setupMap = {
				zoom: 6,
				icon_marker: "images/map-marker.png",
				icon_cluster: "images/cluster-icon.png"
			}

			function initMap() {

				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: setupMap['zoom'],
					center: centerMap()
				});

				// var markers = locations.map(function(location, i) {
				// 	return new google.maps.Marker({
				// 		position: location,
				// 		icon: "images/map-marker.png"
				// 	});
				// });
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
			if ($("#map").length > 0)
				initMap();
		});
    </script>
@stop

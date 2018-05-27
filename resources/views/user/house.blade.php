@extends('layout-user.main')

@section('title', 'All Houses')

@section('css')
	<style>
		section.map .filter-map .input {
			color: #fff;
		}
		section.map .filter-map .input input {
			color: #000;
		}
	</style>
@stop

@section('content')
	<main id="products">
		<section class="map">
			<div id="map"></div>
			<form class="filter-map" method="post" action="/search">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="container">
					<div class="gutter-10">
						<div class="col-lg-2 col-sm-4 input">
							Area :
							<select class="select2" name="district">
								<option value="1">District 1</option>
								<option value="3">District 3</option>
								<option value="4">District 4</option>
								<option value="5">District 5</option>
								<option value="7">District 7</option>
								<option value="Tan Binh">Tan Binh District</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							Type :
							<select class="select2" name="category">
								<option value="1">Apartment</option>
								<option value="2">Villa</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							Number of bedroom(s) : <input type="number" value="1" min="1" max="10" step="1" name="num_bedrooms">
						</div>
						<div class="col-lg-2 col-sm-4 input">
							Price Min ($) : <input type="number" value="100" min="100" max="4000" step="10" name="price_min">
						</div>
						<div class="col-lg-2 col-sm-4 input">
							Price Max ($) : <input type="number" value="1000" min="100" max="4000" step="10" name="price_max">
						</div>
						<div class="col-lg-2 col-sm-4 input text-right">
							<button class="btn-yellow submit">SEARCH</button>
						</div>
					</div>
				</div>
			</form>
		</section>
		<section class="properties bg-smooth">
			<div class="page-title">
				<div class="container">
					@if($search)
						<h1>Search Result</h1>
					@else
						<h1>All Properties</h1>
					@endif
				</div>
			</div>
			@foreach ($houses as $house)
				<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/{{ $house->image_thumbnail }});">
					<div class="overlay"></div>
					<div class="center-position">
						<div class="property-container">
							<h2 class="title">{{ $house->title }}</h2>
							<div class="price-tag"><span class="price">${{ $house->price }}</span> <span class="tag">- {{ $house->num_bedrooms }} Bedrooms</span></div>
							<div class="description">
								<p>{{ $house->description }}</p>
							</div>
							<a href="/detail/{{ $house->id }}" class="btn-white viewmore">View Details</a>
						</div>
					</div>
				</div>
			@endforeach
			<!-- <nav class="navigation pagination" role="navigation">
				<div class="nav-links">
					<a class="next page-numbers" href="#"><i class="icon ion-chevron-left" aria-hidden="true"></i></a>
					<span class="page-numbers current"><span class="meta-nav screen-reader-text"> </span>1</span>
					<a class="page-numbers" href="#"><span class="meta-nav screen-reader-text"> </span>2</a>
					<span class="page-numbers dots">...</span>
					<a class="page-numbers" href="#"><span class="meta-nav screen-reader-text"> </span>20</a>
					<a class="next page-numbers" href="#"><i class="icon ion-chevron-right" aria-hidden="true"></i></a>
				</div>
			</nav> -->
		</section>
		<section class="form-submit form-hasBg submit-type-1">
			<div class="bg-form">
				<div class="img" style="background-image: url(images/bg-form-home.jpg);"></div>
				<img src="images/icon-logo.svg" class="icon-logo">
			</div>
			<div class="container position-relative">
				<h2 class="form-title yellow-text-gradient">Register now</h2>
				<!-- <div class="description"> -->
					<!-- <p>"An cư lạc nghiệp"</p> -->
					<!-- <p>Hãy tìm cho gia đình bạn một tổ ấm, bằng cách đơn gian nhất!</p> -->
				<!-- </div> -->
				<div class="group-input">
					<input type="text" name="" placeholder="Name">
				</div>
				<div class="group-input">
					<input type="text" name="" placeholder="Email">
				</div>
				<div class="group-input">
					<input type="text" name="" placeholder="Phone Number">
				</div>
				<button class="btn-yellow submit">Send</button>
			</div>
		</section>
	</main>
	<input type="hidden" value="{{ $allHouse }}" class="js-all-house">
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
	
	<script>
		$(document).ready(function() {
			var locations = [];
			var houses = JSON.parse($(".js-all-house").val());
			for (var i = 0; i <  houses.length; i++) {
				var location = {};
				location.lat = houses[i].latitude;
				location.lng = houses[i].longitude;
				
				var property = {};
				property.url = "/detail/" + houses[i].id;
				// property.thumb = "images/bg-form-home.jpg";
				property.thumb = "/uploads/images/" + houses[i].image_thumbnail;
				property.title = houses[i].title;
				property.price = '$' + houses[i].price;
				
				location.property = property;
				
				locations.push(location);
			}
			var setupMap = {
				zoom: 10,
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
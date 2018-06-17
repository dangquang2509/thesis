@extends('layout-user.main')

@section('title', 'All Houses')

@section('css')
	<style>
		section.map .filter-map .input {
			color: #000;
		}
		section.map .filter-map .input input {
			color: #000;
		}
		.sort-label {
			font-size: 16px;
		}
		.sort-select {
			padding: 4px;
			border: 1px solid #d9d9d9;
			margin-left: 6px;
			outline: none;
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
		    padding: 30px;
    		border: 1px solid #e1dddd;
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
		}
		.mb-50 {
			margin-bottom: 50px;
		}
		.page-title {
			margin: 16px 0;
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
							<label>Area :</label>
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
							<label>Type :</label>
							<select class="select2" name="category">
								<option value="1">Apartment</option>
								<option value="2">Villa</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<label>Number of bedroom(s) :</label> 
							<input type="number" value="1" min="1" max="10" step="1" name="num_bedrooms">
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<label>Price Min ($) :</label> 
							<input type="number" value="100" min="100" max="4000" step="50" name="price_min">
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<label>Price Max ($) :</label> 
							<input type="number" value="1000" min="100" max="4000" step="50" name="price_max">
						</div>
						<div class="col-lg-2 col-sm-4 input text-right">
							<button class="btn-yellow submit">SEARCH</button>
						</div>
					</div>
				</div>
			</form>
		</section>
		<section class="listings-content-wrapper section-padding-100">
			<div class="container">
				<div class="page-title">
					<div class="container">
						@if($search)
							<h1>Search Result</h1>
							@if (count($houses) === 0) 
								<h5>No results found</h5>
							@else
								<h5><strong>{{ count($houses) }} Listing</strong></h5>
							@endif
						@else
							<h1>All Properties</h1>
							<h5><strong>{{ count($houses) }} Listing</strong></h5>
							<div class="pull-right">
								<label class="sort-label">SORT BY : </label>
								<select class="sort-select" onchange="window.location.href = this.value;">
									<option value="" disabled selected style="display:none;"></option>
				                    <option value="" class="js-sort-desc-price">Sort by Price (high to low)</option>
				                    <option value="" class="js-sort-asc-price">Sort by Price (low to high)</option>
				                    <option value="" class="js-sort-desc-time">Newest</option>
				                    <option value="" class="js-sort-desc-view">Most views</option>
				            	</select>
							</div>
						@endif
					</div>
				</div>
				@foreach ($houses->chunk(3) as $houses_row)
					<div class="row">
						@foreach($houses_row as $house)
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
					
				@endforeach
			</div>
		</section>
		<section class="properties bg-smooth">
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
	</main>
	<input type="hidden" value="{{ $allHouse }}" class="js-all-house">
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
	
	<script>
		$(document).ready(function() {
			// sort function 
			$(".js-sort-desc-price").val(window.location.origin + "/all?order=price_desc");
			$(".js-sort-asc-price").val(window.location.origin + "/all?order=price_asc");
			$(".js-sort-desc-time").val(window.location.origin + "/all?order=time_desc");
			$(".js-sort-desc-view").val(window.location.origin + "/all?order=view_desc");

			var order = '{{ $order }}';
			if (order === 'price_desc') {
				$('.sort-select').val(window.location.origin + "/all?order=price_desc");
			} else if (order === 'price_asc') {
				$('.sort-select').val(window.location.origin + "/all?order=price_asc");
			} else if (order === 'time_desc') {
				$('.sort-select').val(window.location.origin + "/all?order=time_desc");
			} else if (order === 'view_desc') {
				$('.sort-select').val(window.location.origin + "/all?order=view_desc");
			}

			var locations = [];
			var houses = JSON.parse($(".js-all-house").val());
			for (var i = 0; i <  houses.length; i++) {
				var location = {};
				location.lat = houses[i].latitude;
				location.lng = houses[i].longitude;
				
				var property = {};
				property.url = "/detail/" + houses[i].id;
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

				if (houses.length == 0){
					var map = new google.maps.Map(document.getElementById('map'), {
						zoom: setupMap['zoom'],
						center: {lat: 10.762743, lng: 106.681233}
					});
				} else {
					var map = new google.maps.Map(document.getElementById('map'), {
						zoom: setupMap['zoom'],
						center: centerMap()
					});
				}

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
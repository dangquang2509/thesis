@extends('layout.main')

@section('title', 'House Edit')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/style.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/fontawesome-all.css') !!}">

	<style>
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
    	.bg-smooth {
    		margin-top: 24px;
    	}
    	.map {
    		height: 100%;
    	}

    	section.property-content .block {
    		padding: 0;
    	}

    	.ot-container {
    		display: block;
    		font-size: 13px;
    	}

    	section.property-content .block .map .content {
    		background-color: none;
    		border: none;
    		z-index: 0;
    		padding: 120px;
    		margin-top: 50px;
    		margin-bottom: 0;
    	}

    	/* switch */
		.switch {
		  position: relative;
		  display: inline-block;
		  width: 44px;
		  height: 22px;
		}

		.switch input {display:none;}

		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #ccc;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 16px;
		  width: 14px;
		  left: 3px;
		  bottom: 3px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}

		ul {
			list-style-type: none;
		}
		li {
			width: 20%;
			display: inline-block;
			margin-bottom: 8px;
		}

		li span {
			vertical-align: top;
		}
		.section-header {
			margin-left: 12px;
			font-size: 14px;
		}
	</style>
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	@foreach($tour as $tour)
		<div class="ot-page-title-area">
			<h2 class="ot-page-title">Edit House</h2>
			<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('tour', '{{ $tour->id }}'); return false;">Save</a>
			<a class="ot-page-title-btn" href="/admincp/house/detail/{{ $tour->id }}">Cancel</a>
		</div>
		<form id="postTour" action="#" method="post" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="ot-form-row">
				<label class="ot-form-row-label">Title</label>
				<input type="text" id="tour-title" class="ot-form-row-input js-tour-title" name="tour_title" value="{{ $tour->title }}">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Description</label>
				<input type="text" class="ot-form-row-input" name="tour_description" value="{{ $tour->description }}" >
				<input id="tour-key" name="tour_key" type="text" class="js-tour-key ot-form-row-input" style="display:none">
				<input id="floormapImage" name="floormapImage" value="" style="display:none" type="text">
				<input class="ot-xml-url" type="hidden" value="{{ $tour->xml_url }}" name="xml_url">
				<!-- <input type="text" class="ot-form-row-input" value="{{ $tour->description }}"> -->
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Category</label>
				<select class="ot-input-category" name="tour_category">
					@foreach($categories as $index => $category)
						@if ($tour->category_id === $index + 1)
							<option value="{{ $index + 1 }}" selected>{{ $category->name }}</option>
						@else
							<option value="{{ $index + 1 }}">{{ $category->name }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">District</label>
				<select class="ot-input-category option-district" name="house_district">
					<option value="1">1</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="7">7</option>
				</select>
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Traffic</label>
				<input type="text" class="ot-form-row-input" name="house_traffic" value="{{ $tour->traffic }}">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Notice</label>
				<input type="text" class="ot-form-row-input" name="house_notice" value="{{ $tour->notice }}">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Price</label>
				<input type="number" class="ot-form-row-input-number" name="house_price" value="{{ $tour->price }}" min="10" max="4000" step="10">
				<span>$</span>
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Area</label>
				<input type="number" class="ot-form-row-input-number" name="house_area" value="{{ $tour->area }}" min="10" max="1000" step="1">
				<span>m<sup>2</sup></span>
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Bedroom(s)</label>
				<input type="number" class="ot-form-row-input-number" name="house_num_bedroom" value="{{ $tour->num_bedrooms }}" min="1" max="10" step="1">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Bathroom(s)</label>
				<input type="number" class="ot-form-row-input-number" name="house_num_toilet" value="{{ $tour->num_toilets }}" min="1" max="10" step="1">
			</div>
			<div class="section-header">AMENITIES</div>
			<ul class="amenities-section">
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_tv">
						<span class="slider round"></span>
					</label>
					<span>TV</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_microwave">
						<span class="slider round"></span>
					</label>
					<span>Microwave</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_air">
						<span class="slider round"></span>
					</label>
					<span>Air Conditioner</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_smoke">
						<span class="slider round"></span>
					</label>
					<span>Smoke Detector</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_balcony">
						<span class="slider round"></span>
					</label>
					<span>Balcony</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_bath">
						<span class="slider round"></span>
					</label>
					<span>Bathtub</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_dish">
						<span class="slider round"></span>
					</label>
					<span>Dish Washer</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_wash">
						<span class="slider round"></span>
					</label>
					<span>Washing Machine</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_heater">
						<span class="slider round"></span>
					</label>
					<span>Heater</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_kitchen">
						<span class="slider round"></span>
					</label>
					<span>Kitchen</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_wifi">
						<span class="slider round"></span>
					</label>
					<span>Wifi</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-am_refrigerator">
						<span class="slider round"></span>
					</label>
					<span>Refrigerator</span>
				</li>
			</ul>
			<div class="section-header">FACILITIES</div>
			<ul class="facilities-section">
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-bank">
						<span class="slider round"></span>
					</label>
					<span>Banking/ATM</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-restaurant">
						<span class="slider round"></span>
					</label>
					<span>Restaurant</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-supermarket">
						<span class="slider round"></span>
					</label>
					<span>Supermarket</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-pharmacy">
						<span class="slider round"></span>
					</label>
					<span>Pharmacy</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-pool">
						<span class="slider round"></span>
					</label>
					<span>Swimming Pool</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-gym">
						<span class="slider round"></span>
					</label>
					<span>Gymnasium</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-mall">
						<span class="slider round"></span>
					</label>
					<span>Shopping Mall</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-parking">
						<span class="slider round"></span>
					</label>
					<span>Parking</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-school">
						<span class="slider round"></span>
					</label>
					<span>School</span>
				</li>
				<li>
					<label class="switch">
						<input type="checkbox" class="js-fa-playground">
						<span class="slider round"></span>
					</label>
					<span>Playground</span>
				</li>
			</ul>
			<input type="hidden" class="js-house-amenities" name="house_amenities_c" value="{{ $tour->amenities_c }}">
			<input type="hidden" class="js-house-facilities" name="house_facilities" value="{{ $tour->facilities }}">
			<input name="house_address" class="js-house-address" type="hidden" value="{{ $tour->address }}">
			<input name="house_latitude" class="js-house-latitude" type="hidden" value="{{ $tour->latitude }}">
			<input name="house_longitude" class="js-house-longitude" type="hidden" value="{{ $tour->longitude }}">

			<input class="ot-tour-config" type="hidden" value="{{ $tour->config }}">
			<input class="ot-floormap-id" type="hidden" value="{{ $tour->plan_image_id }}">
			<input class="ot-floormap-url" type="hidden" value="{{ $floorMapUrl }}">

			<input id="tour-published-param" name="tour_published" class="js-tour-published-param" type="hidden" value="true" />
			<input id="tour-param" name="tour_param" class="js-tour-param" type="hidden" value="" />
			<input id="tour-map" name="tour_map" class="js-tour-map" type="hidden" value="">
			<input type="hidden" class="house_photo_param" name="house_photo_param" value="{{ $photos }}">
		</form>
		<div class="ot-floormap-view clearfix">
			<div class="ot-floormap-label">
				<input id="file_floormap" name="file[floormap]" onchange="uploadFloorMap(this.files[0])" style="display:none" type="file">
				<span>Floor Plan</span>
				<button class="btn-create-tour" onclick="openFileDialog('file_floormap');">Import</button>
				<button class="btn-create-tour js-delete-floormap" onclick="confirm_delete_floormap();">Delete</button>
				<button class="btn-create-tour js-move-mode">Move</button>
				<button class="btn-create-tour btn-create-tour-active js-link-mode">Link</button>
				<button class="btn-create-tour js-remove-mode">Remove Link</button>
			</div>
			<div class="ot-view-label" style="margin-top: 0;">
				<span>360 View</span>
				<input id="scene-telop" class="scene-telop ot-form-row-input" type="text" maxlength="255" name="scene[telop]" placeholder="Detail of caption">
			</div>
			<div class="js-round-floor-plan ot-drop-floormap">
				<div class="floormap-overlay"></div>
				<div class="js-drop-floormap drop-floormap drop-area">
					<p class="ot-message">
						Please select floor plan from 「Import」 button.
					</p>
					{{-- <a onclick="panoMoveToPoint()" href="#">moveto(100.0, 5, linear(10))</a><br> --}}
				</div>
				<div class="js-img-minimap img-minimap">
					{{-- <img src="{{ asset('uploads/tours/oscar/minimap.png') }}" alt="krpano minimap" style="max-width: 100%; height: auto;"> --}}
				</div>
				<div class="js-wrap-floor-plan" style="position: absolute; top: 0; left: 0;">
					<canvas id="floor-plan" class="js-floor-plan" ></canvas>
				</div>
			</div>
			<div class="ot-right-column">
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
		</div>
		<div class="ot-sphere-area">
			<div class="ot-sphere-label">
				<span>360°Images</span>
				<button class="btn-create-tour" onclick="openFileDialog('file_spheres');">Import</button>
				<input id="file_spheres" multiple="multiple" name="file[spheres][]" onchange="uploadSpheres(this.files)" style="display:none" type="file">
			</div>
			<div class="ot-drop-sphere js-drop-spheres">
				<p class="ot-message">
					Please drag and drop 360 degree images here.<br> Or <br>select 360 degree images from 「Import」 button.
				</p>
				<div class="js-scroll-area sortable ui-sortable clearfix">
				</div>
			</div>
		</div>
		<div class="ot-sphere-area">
			<div class="ot-sphere-label">
				<span>Photos</span>
				<button class="btn-create-tour" onclick="openFileDialog('file_photos');">Import</button>
				<input id="file_photos" multiple="multiple" name="file[photos][]" onchange="uploadPhotos(this.files)" style="display:none" type="file">
			</div>
			<div class="ot-drop-sphere js-drop-photo">
				<p class="ot-message">
					Select photos from 「Import」 button.
				</p>
				<div class="js-photo-area sphere-container clearfix">
				</div>
			</div>
		</div>
		<section class="property-content bg-smooth blur">
			<div class="block">
				<input id="pac-input" class="controls input-location" type="text" value="{{ $tour->address }}">
				<div class="map">
					<div class="container">
						<div class="content">
						</div>
					</div>
					<div id="map-1" class="ggmap"></div>
				</div>
			</div>
		</section>
		<div class="js-replace-floormap-dialog" title="The information on the floor plan will be lost when you replace it. Is it OK?" style="text-align:center"></div>
		<div class="js-delete-floormap-dialog" title="Do you want to delete floor plan ?" style="text-align:center"></div>
		<div class="ot-page-title-area-bottom">
			<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('tour', '{{ $tour->id }}'); return false;">Save</a>
		</div>
	@endforeach
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c&libraries=places"></script>
	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
	<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>

	<script type="text/javascript">
		var during_restore = true;

		$(document).ready(function(){
			var district = '{{ $tour->district }}';
			$(".option-district").val(district);

			var lat = parseFloat('{{ $tour->latitude }}');
			var lng = parseFloat('{{ $tour->longitude }}');
			var address = '{{ $tour->address }}';
			
			var locationHouse = {lat: lat, lng: lng};
			var markers = [];

			if ($("#map-1").length > 0) {
				var map = new google.maps.Map(document.getElementById('map-1'), {
					zoom: 15,
					center: locationHouse
				});
				var marker = new google.maps.Marker({
					map: map,
					draggable: false,
					position: new google.maps.LatLng(lat, lng),
					visible: true,
					icon: "images/map-marker.png"
				});
				markers.push(marker);
			}

			var input = document.getElementById('pac-input');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			// Bias the SearchBox results towards current map's viewport.
			map.addListener('bounds_changed', function() {
				searchBox.setBounds(map.getBounds());
			});

			// Listen for the event fired when the user selects a prediction and retrieve
			// more details for that place.
			searchBox.addListener('places_changed', function() {
				var places = searchBox.getPlaces();

				if (places.length == 0) {
					return;
				}

			    for (i = 0; i < markers.length; i++){
			        markers[i].setMap(null);
			    }

				// For each place, get the icon, name and location.
				var bounds = new google.maps.LatLngBounds();
				
				

				places.forEach(function(place) {
					lat = place.geometry.location.lat();
					lng = place.geometry.location.lng();
					address = place.formatted_address;

					if (!place.geometry) {
						console.log("Returned place contains no geometry");
						return;
				}

				$(".js-house-latitude").val(lat);
				$(".js-house-longitude").val(lng);
				$(".js-house-address").val(address);
				
				var marker = new google.maps.Marker({
					map: map,
					draggable: false,
					position: new google.maps.LatLng(lat, lng),
					visible: true,
					icon: "images/map-marker.png"
				});
				markers.push(marker);

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
				});
				map.fitBounds(bounds);
			});
		});
	</script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('vtour/tour.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/common.js') !!}"></script>
@stop

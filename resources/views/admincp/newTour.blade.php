
@extends('layout.main')

@section('title', 'New House')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
	<!-- <link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/select2.min.css') !!}"> -->
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/user/style.css') !!}">
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
	</style>
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">New House</h2>
		<!-- <a class="ot-page-title-btn" href="" onclick="showPreview(); return false;">プレビュー</a> -->
		<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('new', ''); return false;">Save</a>
	</div>
	<form id="postTour" action="#" method="post" accept-charset="UTF-8">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="ot-form-row">
			<label class="ot-form-row-label">Title</label>
			<input id="tour-title" name="tour_title" type="text" class="js-tour-title ot-form-row-input" placeholder="Input your house title"/>
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Description</label>
			<input type="text" class="ot-form-row-input" name="tour_description">
			<input id="tour-key" name="tour_key" type="text" class="js-tour-key ot-form-row-input" style="display:none" placeholder="カスタムキーを入力">
			<input id="floormapImage" name="floormapImage" value="" style="display:none" type="text">
			<input id="tour-published-param" name="tour_published" class="js-tour-published-param" type="hidden" value="true" />
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Category</label>
			<select class="ot-input-category" name="tour_category">
				@foreach($categories as $index => $category)
					<option value="{{ $index + 1 }}">{{ $category->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">District</label>
			<select class="ot-input-category" name="house_district">
				<option value="1">1</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="7">7</option>
				<option value="Tan Binh">Tan Binh</option>
			</select>
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Amenities</label>
			<input type="text" class="ot-form-row-input" name="house_amenities" value="">
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Project Facility</label>
			<input type="text" class="ot-form-row-input" name="house_project_facility" value="">
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Traffic</label>
			<input type="text" class="ot-form-row-input" name="house_traffic" value="">
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Notice</label>
			<input type="text" class="ot-form-row-input" name="house_notice" value="">
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Price</label>
			<input type="number" class="ot-form-row-input-number" name="house_price" value="100" min="10" max="4000" step="10">
			<span>$</span>
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Area</label>
			<input type="number" class="ot-form-row-input-number" name="house_area" value="50" min="10" max="1000" step="1">
			<span>m<sup>2</sup></span>
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Bedroom(s)</label>
			<input type="number" class="ot-form-row-input-number" name="house_num_bedroom" value="1" min="1" max="10" step="1">
		</div>
		<div class="ot-form-row">
			<label class="ot-form-row-label">Bathroom(s)</label>
			<input type="number" class="ot-form-row-input-number" name="house_num_toilet" value="1" min="1" max="10" step="1">
		</div>
		<input name="house_address" class="js-house-address" type="hidden" value="">
		<input name="house_latitude" class="js-house-latitude" type="hidden" value="">
		<input name="house_longitude" class="js-house-longitude" type="hidden" value="">

		<input id="tour-param" name="tour_param" class="js-tour-param" type="hidden" value="" />
		<input id="tour-map" name="tour_map" class="js-tour-map" type="hidden" value="">
		<input type="hidden" class="house_photo_param" name="house_photo_param" value="">
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
			<span>360°view</span>
			<input id="scene-telop" class="scene-telop ot-form-row-input" type="text" maxlength="255" name="scene[telop]" placeholder="Detail of caption">
		</div>
		<div class="js-round-floor-plan ot-drop-floormap">
			<div class="floormap-overlay"></div>
			<div class="js-drop-floormap drop-floormap drop-area">
				<p class="ot-message">
					Please select floor plan from 「Import」 button.<br>
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
			<div id="loading_layer" class="loading-layer js-loading-layer" style="">Loading...</div>
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
			<span>360 Image</span>
			<button class="btn-create-tour" onclick="openFileDialog('file_spheres');">Import</button>
			<input id="file_spheres" multiple="multiple" name="file[spheres][]" onchange="uploadSpheres(this.files)" style="display:none" type="file">
		</div>
		<div class="ot-drop-sphere js-drop-spheres">
			<p class="ot-message">
				Please drag and drop 360 degree images here.<br> Or <br>select 360 degree images from 「Import」 button.
			</p>
			<div class="js-scroll-area sortable ui-sortable sphere-container clearfix">
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
			<input id="pac-input" class="controls input-location" type="text" placeholder="Search Location">
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
	<div class="js-delete-floormap-dialog" title="Do you realy want to delete floor plan?" style="text-align:center"></div>
	<div class="ot-page-title-area-bottom">
		<!-- <a class="ot-page-title-btn" href="" onclick="showPreview(); return false;">プレビュー</a> -->
		<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('new', ''); return false;">Save</a>
	</div>

@stop
@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c&libraries=places"></script>
	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
	<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>

	<script type="text/javascript">
		var during_restore = false;

		$(document).ready(function() {
			var locationHouse = {lat: 10.762395, lng: 106.681163};
			var markers = [];

			if ($("#map-1").length > 0) {
				var map = new google.maps.Map(document.getElementById('map-1'), {
					zoom: 15,
					center: locationHouse
				});
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
				
				var lat = 0;
				var lng = 0;
				var address = "";

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

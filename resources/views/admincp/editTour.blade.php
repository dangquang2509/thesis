@extends('layout.main')

@section('title', 'House Edit')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
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
				<span class="ot-form-require-label">必須</span>
				<input type="text" id="tour-title" class="ot-form-row-input js-tour-title" name="tour_title" value="{{ $tour->title }}">
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Description</label>
				<span class="ot-form-require-label" style="visibility:hidden">必須</span>
				<input type="text" class="ot-form-row-input" name="tour_description" value="{{ $tour->description }}" >
				<input id="tour-key" name="tour_key" type="text" class="js-tour-key ot-form-row-input" style="display:none">
				<input id="floormapImage" name="floormapImage" value="" style="display:none" type="text">
				<input class="ot-xml-url" type="hidden" value="{{ $tour->xml_url }}" name="xml_url">
				<!-- <input type="text" class="ot-form-row-input" value="{{ $tour->description }}"> -->
			</div>
			<div class="ot-form-row">
				<label class="ot-form-row-label">Category</label>
				<span class="ot-form-require-label" style="visibility:hidden">必須</span>
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
			<input class="ot-tour-config" type="hidden" value="{{ $tour->config }}">
			<input class="ot-floormap-id" type="hidden" value="{{ $tour->plan_image_id }}">
			<input class="ot-floormap-url" type="hidden" value="{{ $floorMapUrl }}">

			<input id="tour-published-param" name="tour_published" class="js-tour-published-param" type="hidden" value="true" />
			<input id="tour-param" name="tour_param" class="js-tour-param" type="hidden" value="" />
			<input id="tour-map" name="tour_map" class="js-tour-map" type="hidden" value="">
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
			<div class="ot-view-label ot-form-row" style="margin-top: 0;">
				<span>360 View</span>
				<input id="scene-telop" class="scene-telop ot-form-row-input" type="text" maxlength="255" name="scene[telop]" placeholder="キャプションの詳細">
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
		<div class="js-replace-floormap-dialog" title="The information on the floor plan will be lost when you replace it. Is it OK?" style="text-align:center"></div>
		<div class="js-delete-floormap-dialog" title="Do you want to delete floor plan ?" style="text-align:center"></div>
		<div class="ot-page-title-area-bottom">
			<a class="ot-page-title-btn ot-primary-bg" href="" onclick="uploadTour('tour', '{{ $tour->id }}'); return false;">Save</a>
		</div>
	@endforeach
@stop

@section('js')
	<script type="text/javascript">
		var during_restore = true;
	</script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('vtour/tour.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/common.js') !!}"></script>
@stop

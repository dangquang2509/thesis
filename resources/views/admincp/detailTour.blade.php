@extends('layout.main')

@section('title', 'House Detail')

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
		<h2 class="ot-page-title">House Detail</h2>
		<a class="ot-page-title-btn" href="/admincp/house/list">Back to list</a>
		<a class="ot-page-title-btn ot-page-title-btn-right" href="/admincp/house/edit/{{ $tour->id }}">Edit</a>
	</div>
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
		<form class="form-content clearfix" action="{{ url('/admincp/house/delete') }}" method="POST" role="form">
			<div class="ot-content">
					{{ csrf_field()}}
					<input type="hidden" value="{{ $tour->id }}" class="tour_id" name="tour_key">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Title</div>
						<div class="ot-image-detail-value">{{ $tour->title }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">View URL</div>
						<a href="/house/full/{{ $tour->id }}" target="_blank" class="ot-image-detail-value js-view-url"></a>
					</div>
					<!-- <div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Description</div>
						<div class="ot-image-detail-value">{{ $tour->description }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Amenities</div>
						<div class="ot-image-detail-value">{{ $tour->amenities }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Project Facility</div>
						<div class="ot-image-detail-value">{{ $tour->project_facility }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Traffic</div>
						<div class="ot-image-detail-value">{{ $tour->traffic }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Notice</div>
						<div class="ot-image-detail-value">{{ $tour->notice }}</div>
					</div> -->
					<div class="ot-image-detail-row">
						<!-- <div class="ot-image-detail-label"><a href="javascript:void(0)" class="embed-code js-embed-code ot-embed-link">Embeded</a></div> -->
						<div class="ot-image-detail-label">Iframe</div>
						<div class="ot-image-detail-value">
							<textarea rows="4" readonly class="js-embed-code select"></textarea>
						</div>
					</div>
					<input type="text" name="tour_id" value="{{ $tour->id }}" style="display:none">
					<div class="ot-btn-area clearfix">
						<div class="ot-btn-edit">
							<a href="/admincp/house/edit/{{ $tour->id }}">Edit</a>
						</div>
						<div class="ot-btn-delete">
							<a class="ot-link-delete js-delete-tour">Delete this house</a>
						</div>
					</div>
			</div>
			<!-- <div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<a href="/admincp/house/edit/{{ $tour->id }}">編集</a>
				</div>
				<div>
					<a class="ot-link-delete js-delete-tour">このコンテンツを削除</a>
				</div>
			</div> -->
		</form>
	</div>
	@endforeach
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('vtour/tour.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>

	<script type="text/javascript">
	 	$(document).ready(function() {
			embedpano({swf:"/vtour/tour.swf", xml:"/{{ $tour->xml_url }}", target:"pano", consolelog: "true"});
			var width = 600;
			var height = 400;
			var krpano = document.getElementById("krpanoSWFObject");
			var scene = krpano.get("xml.scene");
			var link = "&start_scene=" + scene;
			link = window.location.href.replace("admincp/house", "house/full").replace("detail/", "") + link;
			var leftPosition, topPosition;
			leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
			topPosition = (window.screen.height / 2) - ((height / 2) + 50);
			var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
			u = link;
			t = document.title;
			var embed_code = '<iframe src="' + link + '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" frameborder="0" width="100%" height="100%"></iframe>';
			$(".js-embed-code").text(embed_code);
			$(".js-view-url").text(link);

			// delete tour

			$('.js-delete-tour').on('click', function() {
				var check = confirm("You want to delete this house?");
				if (check == true) {
					$.ajax({
						url: "/admincp/house/delete/" + $('.tour_id').val(),
						type: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: $('.tour_id').val(),
						success: function (data) {
							if (data['row'] > 0) {
								toastr.success(data['success']);
							} else if (data['row'] == 0) {
								toastr.error('This house will not be cancelled.');
							}
						},
						error: function (data) {
							toastr.error('An error occurred. Please try again.');
						}
					});
				} else {
				}
			});
		});

	</script>
@stop

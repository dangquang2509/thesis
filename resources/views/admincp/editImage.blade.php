@extends('layout.main')

@section('title', 'Spherical image edit')

@section('header')
	@include('layout.header')
@stop

@section('content')
	@foreach($image as $image)
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">Spherical image edit</h2>
		<a class="ot-page-title-btn" href="/admincp/image/detail/{{ $image->id}}">Cancel</a>
		<a class="ot-page-title-btn ot-page-title-btn-right submit" href="#">Update</a>
	</div>
	<div class="ot-image-detail-content">
		<form class="form-content clearfix form-edit-image" action="{{ url('/admincp/image/update') }}" method="POST" role="form">
			<div class="ot-content">
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
					<!-- <blockquote data-width="900" data-height="375" class="ricoh-theta-spherical-image" ><a href="https://onetech.theta360.biz/s/e453497a-a1a1-11e7-bb38-06b35f615bf5-1"></a></blockquote><script async src="https://onetech.theta360.biz/widgets.js" charset="utf-8"></script> -->
				</div>
				{{ csrf_field()}}
				<!-- <div class="checkbox ot-upload-checkbox">
					<label>
						@if($image->is_public === 1)
						<input name="is_public" type="checkbox" checked> 公開
						@else
						<input name="is_public" type="checkbox"> 公開
						@endif
					</label>
				</div> -->
				<input type="hidden" value="{{ $image->id}}" name="id">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Spherical ID	</div>
					<div class="ot-image-detail-value">{{ $image->spherical_id }}</div>
				</div>
				<input type="hidden" value="{{ $image->image_url }}" class="js-image-url">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Title</div>
					<div class="ot-image-detail-value">
						<input type="text" value="{{ $image->title }}" name="title">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Thumbnail</div>
					<div class="ot-image-detail-value">
						<img src="{{URL::asset('uploads/images/thumb/' . $image->image_url)}}" alt="image_thumbnail">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">View URL</div>
					<div class="ot-image-detail-value">uploads/images/{{ $image->image_url }}</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Description</div>
					<div class="ot-image-detail-value">
						<input type="text" value="{{ $image->description }}" name="description">
					</div>
				</div>
				<div class="ot-btn-area clearfix">
					<div class="ot-btn-edit">
						<a class="submit" href="#">Update</a>
					</div>
				</div>
			</div>
			<!-- <div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<button type="submit">更新</button>
				</div>
				<div class="ot-btn-cancel">
					<a href="/admincp/image/detail/{{ $image->id}}">キャンセル</a>
				</div>
			</div> -->
		</form>
	</div>
	@endforeach
@stop

@section('js')
	<script type="text/javascript" src="{!! asset('vtour/tour.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var image_url = $('.js-image-url').val();
			console.log(image_url);
			var viewer = createPanoViewer({
				swf: "/vtour/tour.swf",
				target: "pano",
				html5: "auto",
				mobilescale: 1.0,
				passQueryParameters: true,
				bgcolor: "#ffffff",
				consolelog: true
			});
			viewer.addVariable("xml", null);
			viewer.embed();

			var pano_dom = document.getElementById("krpanoSWFObject");
			pano_dom.call("loadpano(null,image.sphere.url=/uploads/images/" + image_url + ",keepbase,blend(1))");

			$('.submit').click(function(){
				$('.form-edit-image').submit();
			});
		});
			

	</script>
@stop
@extends('layout.main')

@section('title', '360画像 詳細')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	@foreach($image as $image)
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">360画像 詳細</h2>
		<span><a class="ot-page-title-btn" href="/admincp/image/list">一覧に戻る</a></span>
		<span><a class="ot-page-title-btn ot-page-title-btn-right" href="/admincp/image/edit/{{ $image->id}}">編集</a></span>
	</div>
	<div class="ot-image-detail-content">
		<form class="form-content clearfix" action="{{ url('/admincp/image/delete') }}" method="POST" role="form">
			<div class="ot-content">
					<div class="pano-area">
						<!-- <blockquote data-width="958" data-height="375" class="ricoh-theta-spherical-image" ><a href="https://onetech.theta360.biz/s/e453497a-a1a1-11e7-bb38-06b35f615bf5-1"></a></blockquote><script async src="https://onetech.theta360.biz/widgets.js" charset="utf-8"></script> -->
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
					{{ csrf_field()}}
					<!-- <div class="ot-btn-public-private-area">
						@if($image->is_public === 1)
						<button type="button" class="ot-btn-public">公開</button>
						@else
						<button type="button" class="ot-btn-public">非公開</button>
						@endif
					</div> -->
					<input type="hidden" value="{{ $image->id}}" name="id" class="image_id">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">360画像ID</div>
						<div class="ot-image-detail-value">{{ $image->spherical_id }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">タイトル</div>
						<div class="ot-image-detail-value">{{ $image->title }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">サムネイル</div>
						<div class="ot-image-detail-value">
							<img src="{{URL::asset('uploads/images/thumb/' . $image->image_url)}}" alt="image_thumbnail">
						</div>
					</div>
					<input type="hidden" value="{{ $image->image_url }}" class="js-image-url">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">View URL</div>
						<div class="ot-image-detail-value">uploads/images/{{ $image->image_url }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">サムネイルURL</div>
						<div class="ot-image-detail-value">{{ $image->view_url }}</div>
					</div>
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">備考</div>
						<div class="ot-image-detail-value">{{ $image->description }}</div>
					</div>
					<div class="ot-btn-area clearfix">
					<div class="ot-btn-edit">
						<a href="/admincp/image/edit/{{ $image->id}}">編集</a>
					</div>
					<div class="ot-btn-delete">
						<a class="ot-link-delete js-delete-image">この360画像を削除</a>
					</div>
				</div>
			</div>
			<!-- <div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<a href="/admincp/image/edit/{{ $image->id}}">編集</a>
				</div>
				<div>
					<a class="ot-link-delete js-delete-image">この360画像を削除</a>
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
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript">
	 	$(document).ready(function() {
			var image_url = $('.js-image-url').val();
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

			// delete image

			$('.js-delete-image').on('click', function() {
				var check = confirm("この360画像を削除します。よろしいですか？");
				if (check == true) {
					$.ajax({
						url: "/admincp/image/delete/" + $('.image_id').val(),
						type: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: $('.image_id').val(),
						success: function (data) {
							if (data['row'] > 0) {
								toastr.success(data['success']);
							} else if (data['row'] == 0) {
								toastr.error('この画像が削除されません。');
							}
						},
						error: function (data) {
							toastr.error('エラーが発生しました。もう一度お試しください。');
						}
					});
				} else {
					
				}
			});
		});
	</script>
@stop

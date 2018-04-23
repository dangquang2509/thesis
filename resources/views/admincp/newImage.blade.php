@extends('layout.main')

@section('title', '360画像新規登録')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

<script type="text/javascript">
	if (window.FileReader) {
		$image_url = document.getElementById("image_url");
		image_url.change(function() {
			var fileReader = new FileReader(), files = this.files, file;
			if (files.length) {
				file = files[0];
				if (/^image\/\w+$/.test(file.type)) {
					fileReader.readAsDataURL(file);
					fileReader.onload = function () {
						//$('#img-preview > img').attr('src', this.result);
					};
				} else {
					//showMessage("Please choose an image file.");
				}
			}
		});
	};
</script>

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">360画像新規登録</h2>
	</div>
{!! Form::open(['url' => 'admincp/image/create', 'files' => true, 'class' => 'form-horizontal']) !!}
	{!! csrf_field() !!}

	<div class="ot-form-row">
		<label class="ot-form-row-label">登録画像選択</label>
		{!! Form::file('image_url', array('id' => 'image_url', 'class' => 'ot-form-row-input')) !!}
	</div>
	<div class="ot-form-row">
		<label class="ot-form-row-label">タイトル</label>
		<input name="title" type="text" class="ot-form-row-input" value="{{ old('title') }}">
	</div>
	<div class="ot-form-row">
		<label class="ot-form-row-label">備考</label>
		<textarea name="description" rows="3" class="ot-form-row-input">{{ old('description') }}</textarea>
	</div>
	<div class="checkbox ot-upload-checkbox">
		<label>
			<input name="is_public" type="checkbox" checked> 公開
		</label>
	</div>
	<div class="ot-btn-submit-area">
		<button type="submit" class="ot-form-btn-submit">登録</button>
	</div>
{!! Form::close() !!}
@stop

@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ot-form-btn-submit').on('click', function(){
				var imgFile = $('#image_url').val(); 
				if (imgFile === '') {
					toastr.error('ファイルを選択してください');
					return false;
				}
			});
		});
	</script>
@stop
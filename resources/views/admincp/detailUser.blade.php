@extends('layout.main')

@section('title', 'ユーザー 詳細')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		 <h2 class="ot-page-title">ユーザー 詳細</h2>
		 <a class="ot-page-title-btn" href="/admincp/user/list">一覧に戻る</a>
	</div>
	<div class="ot-image-detail-content">
		@foreach($user as $user)
			<form class="form-content clearfix" action="{{ url('/admincp/user/delete') }}" method="POST" role="form">
				<div class="ot-content-left">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">ユーザー名</div>
						<div class="ot-image-detail-value">{{ $user->name }}</div>
					</div>
					{{ csrf_field()}}
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">メールアドレス</div>
						<div class="ot-image-detail-value">{{ $user->email }}</div>
					</div>
					<input type="hidden" value="{{ $user->id}}" class="user_id" name="user_id">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">user_id</div>
						<div class="ot-image-detail-value">{{ $user->id }}</div>
					</div>
				</div>
				<div class="ot-content-right">
					<div class="ot-btn-edit-image">
						<a href="/admincp/user/edit/{{ $user->id }}">編集</a>
					</div>
					<div> 
						<a class="ot-link-delete js-delete-user">このユーザーを削除</a>
					</div>
				</div>
			</form>
		@endforeach
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.js-delete-user').on('click', function() {
				var check = confirm("このユーザーを削除します。よろしいですか？");
				if (check == true) {
					$.ajax({
						url: "/admincp/user/delete/" + $('.user_id').val(),
						type: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: $('.user_id').val(),
						success: function (data) {
							if (data['row'] > 0) {
								toastr.success(data['success']);
							} else if (data['row'] == 0) {
								toastr.error('このユーザーが削除されません。');
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
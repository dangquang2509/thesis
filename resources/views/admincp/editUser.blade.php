@extends('layout.main')

@section('title', 'ユーザー 編集')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">ユーザー 編集</h2>
	</div>
	@foreach($user as $user)
	<div class="ot-image-detail-content">
		<form class="form-content clearfix" action="{{ url('/admincp/user/update') }}" name="form_edit_user" onsubmit="return validateFormEditUser()" method="POST" role="form">
			<div class="ot-content-left">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">ユーザー名</div>
					<div class="ot-image-detail-value">{{ $user->name }}</div>
				</div>
				{{ csrf_field()}}
				<input type="hidden" value="{{ $user->id}}" name="id">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">新パスワード</div>
					<div class="ot-image-detail-value">
						<input type="password" name="password" required=""
							oninvalid="this.setCustomValidity('パスワードを入力してください。')" oninput="setCustomValidity('')">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label"></div>
					<div class="ot-image-detail-value">
						半角英数8文字以上
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">新パスワード確認</div>
					<div class="ot-image-detail-value">
						<input type="password" name="password_confirm" required=""
							oninvalid="this.setCustomValidity('パスワードをもう一度入力してください。')" oninput="setCustomValidity('')">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label"></div>
					<div class="ot-image-detail-value">
						確認のため、再度パスワードの入力をお願いします。
					</div>
				</div>
			</div>
			<div class="ot-content-right">
				<div class="ot-btn-edit-image">
					<button type="submit">更新</button>
				</div>
				<div class="ot-btn-cancel">
					<a href="/admincp/user/detail/{{ $user->id}}">キャンセル</a>
				</div>
			</div>
		</form>
	</div>
	@endforeach
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript">
		function validateFormEditUser() {
			var pwd = document.forms["form_edit_user"]["password"].value;
			var pwd_confirm = document.forms["form_edit_user"]["password_confirm"].value;
			if (pwd === "" || pwd_confirm === "") {
				toastr.error('Please filled in required fields');
				return false;
			} else if (pwd.length < 8) {
				toastr.error('パスワードは8文字以上で入力してください。');
				return false;
			} else {
				if (pwd !== pwd_confirm) {
					toastr.error('パスワードが一致しません。');
					return false;
				}
			}
		}
	</script>
@stop

@extends('layout.main')

@section('title', 'Create new user')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">Create new user</h2>
	</div>
	<div class="ot-image-detail-content">
		<form class="form-content clearfix" name="form_new_user" onsubmit="return validateFormNewUser()" action="{{ url('/admincp/user/create') }}" method="POST" role="form">
			<div class="ot-content-left">
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Username</div>
					<span class="ot-form-require-label">required</span>
					<div class="ot-image-detail-value">
						<input type="text" name="username" required="" 
							oninvalid="this.setCustomValidity('ユーザー名を入力してください。')" oninput="setCustomValidity('')">
					</div>
				</div>
				{{ csrf_field()}}
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label"></div>
					<div class="ot-image-detail-notes">
						<!-- 半角英数文字及びアンダーバー(_)、ハイフン(-) -->
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Mail Address</div>
					<span class="ot-form-require-label">required</span>
					<div class="ot-image-detail-value">
						<input type="text" name="email" required=""
							oninvalid="this.setCustomValidity('メールアドレスを入力してください。')" oninput="setCustomValidity('')">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Password</div>
					<span class="ot-form-require-label">required</span>
					<div class="ot-image-detail-value"><input type="password" name="password" required=""
							oninvalid="this.setCustomValidity('パスワードを入力してください。')" oninput="setCustomValidity('')"></div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label"></div>
					<div class="ot-image-detail-notes">
						Minimum 8 characters
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label">Reconfirmed Password</div>
					<span class="ot-form-require-label">required</span>
					<div class="ot-image-detail-value">
						<input type="password" name="password_confirm" required=""
							oninvalid="this.setCustomValidity('パスワードをもう一度入力してください。')" oninput="setCustomValidity('')">
					</div>
				</div>
				<div class="ot-image-detail-row">
					<div class="ot-image-detail-label"></div>
					<div class="ot-image-detail-notes">
						<!-- 確認のため、再度パスワードの入力をお願いします。 -->
					</div>
				</div>
				<!-- <div class="ot-image-detail-row">
					<div class="ot-image-detail-label">権限設定</div>
					<div class="ot-image-detail-value">
						<select class="ot-input-select">
							<option value="id">[カスタム]</option>
							<option value="manage">管理者</option>
							<option value="edit">編集者</option>
							<option value="reference">参照者</option>
						</select>
					</div>
				</div> -->
			</div>
			<div class="ot-content-right">
				<button class="ot-btn-submit" type="submit">Create</button>
			</div>
		</form>
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script type="text/javascript">
		function validateFormNewUser() {
			var username = document.forms["form_new_user"]["username"].value;
			var pwd = document.forms["form_new_user"]["password"].value;
			var pwd_confirm = document.forms["form_new_user"]["password_confirm"].value;
			var email = document.forms["form_new_user"]["email"].value;
			if (username === "" || pwd === "" || pwd_confirm === "" || email === "") {
				toastr.error('Please filled in required fields');
				return false;
			} else if (username.includes(" ")) {
				toastr.error('ユーザー名が無効な形式です。');
				return false;
			} else if (pwd.length < 8) {
				toastr.error('パスワードは8文字以上で入力してください。');
				return false;
			} else if (!email.includes("@")) {
				toastr.error('メールアドレスが無効な形式です。');
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
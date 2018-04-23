@extends('layout.main-portable')

@section('css')
@stop

@section('title', 'ログイン')

@section('content')
	<div class="login-page">
		<div class="form">
			<form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
				{{ csrf_field() }}
				<div class="ot-login-title">House Management</div>
				<input id="username" name="username" type="text" placeholder="Username"/>
				@if ($errors->has('username'))
					<span class="error-block">
						<strong>{{ $errors->first('username') }}</strong>
					</span>
				@endif
				<input id="password" name="password" type="password" placeholder="Password"/>
				@if ($errors->has('password'))
					<span class="error-block">
						<strong>{{ $errors->first('password') }} </strong>
					</span>
				@endif
				@if ($errors->has('errorlogin'))
					<span class="error-block">
						<strong>{{ $errors->first('errorlogin') }} </strong>
					</span>
				@endif
				<button type="submit">Login</button>
			</form>
		</div>
	</div>
@stop

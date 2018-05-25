@extends('layout.main')

@section('title', 'User Detail')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		 <h2 class="ot-page-title">User Detail</h2>
		 <a class="ot-page-title-btn" href="/admincp/user/list">Back to list</a>
	</div>
	<div class="ot-image-detail-content">
		@foreach($user as $user)
			<form class="form-content clearfix" action="{{ url('/admincp/user/delete') }}" method="POST" role="form">
				<div class="ot-content-left">
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Username</div>
						<div class="ot-image-detail-value">{{ $user->name }}</div>
					</div>
					{{ csrf_field()}}
					<div class="ot-image-detail-row">
						<div class="ot-image-detail-label">Email</div>
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
						<a href="/admincp/user/edit/{{ $user->id }}">Edit</a>
					</div>
					<div> 
						<a class="ot-link-delete js-delete-user">Delete this user</a>
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
				var check = confirm("You want to delete this user?");
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
								toastr.error('This user will not be deleted');
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
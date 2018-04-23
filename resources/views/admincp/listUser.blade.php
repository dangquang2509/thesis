@extends('layout.main')

@section('title', 'User List')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">User List</h2>
		<!-- <a class="ot-page-title-btn" href="/admincp/user/new">新規ユーザーを作成する</a> -->
	</div>
	<!-- <form>
		<select class="ot-input-select">
			<option value="username">ユーザー名</option>
		</select>
		<span><input class="ot-input-search" type="text" placeholder="ユーザー名を入力"></span>
	</form> -->
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
			<span>一Operation  </span><button data-url="{{ url('/admincp/user/deleteAll') }}" class="ot-btn-delete js-delete-all">Delete</button>
			@if ($users->count() > 0)
				<span class="ot-list-row-quantity">Total {{ $users->count() }} users</span>
			@endif
		</div>
		<table class="ot-image-list-table">
			<tr>
				<th class="no-sort"><input type="checkbox" id="chk-master"></th>
				<th class="no-sort ot-th-username">Username</th>
				<th class="no-sort">Created At</th>
				<th class="no-sort">Updated At</th>
			</tr>
			@foreach($users as $user)
				<tr>
					<td><input type="checkbox" class="sub-chk" data-id="{{ $user->id }}"></td>
					<td><a href="/admincp/user/detail/{{ $user ->id}}" class="ot-list-link">{{ $user->name }}</a></td>
					<td>{{ $user->created_at }}</td>
					<td>{{ $user->updated_at }}</td>
				</tr>
			@endforeach
		</table>
		
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script>
		$(document).ready(function() {
			$('#chk-master').on('click', function(e) {
				if($(this).is(':checked',true))  
				{
					$(".sub-chk").prop('checked', true);
				} else {
					$(".sub-chk").prop('checked', false);
				}
			});
			$('.js-delete-all').on('click', function(e) {
				var allVals = [];
				$(".sub-chk:checked").each(function() {
					allVals.push($(this).attr('data-id'));
				});
				if(allVals.length <= 0) {
					toastr.info('行を選択してください');
				}
				else {
					var check = confirm("選択されたユーザーを削除しますか？");
					if (check == true) {
						var join_selected_values = allVals.join(",");
						$.ajax({
							url: $(this).data('url'),
							type: 'DELETE',
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							data: 'ids=' + join_selected_values,
							success: function (data) {
								if (data['success']) {
									$(".sub-chk:checked").each(function() {  
										$(this).parents("tr").remove();
									});
									if (data['userCount'] > 0) {
										$(".ot-list-row-quantity").text(data['userCount'] + " 件中 " + "1-" + data['userCount'] + " 件目");
									}
									else {
										$(".ot-list-row-quantity").text("");
									}
									toastr.success(data['success']);
								} else if (data['error']) {
									toastr.error(data['error']);
								} else {
									toastr.error('エラーが発生しました。もう一度お試しください。');
								}
							},
							error: function (data) {
								toastr.error(data.responseText);
							}
						});
						$.each(allVals, function( index, value ) {
							$('table tr').filter("[data-row-id='" + value + "']").remove();
						});
					}
				}
			});
		});
	</script>
@stop

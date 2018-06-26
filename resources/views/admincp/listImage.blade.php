@extends('layout.main')

@section('title', 'Spherical image list')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">Spherical image list</h2>
	</div>
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
			<span>Batch operation</span><button data-url="{{ url('/admincp/image/deleteAll') }}" class="ot-btn-delete js-delete-all">Delete</button>
			@if ($images->count() > 0)
				<span class="ot-list-row-quantity">{{ $images->count() }} images in total</span>
			@endif
		</div>
		<table class="ot-image-list-table" id="table_image">
			<thead>
				<th class="no-sort"><input type="checkbox" id="chk-master"></th>
				<th class="no-sort">Thumbnail</th>
				<th>Spherical ID</th>
				<th>House ID</th>
				<th>View URL</th>
				<th>Created by</th>
				<th>Created at</th>
			</thead>
			<tbody>
			@foreach($images as $image)
				<tr>
					<td><input type="checkbox" class="sub-chk" data-id="{{ $image->id }}"></td>
					<td><a href="/admincp/image/detail/{{ $image->id}}"><img class="ot-img-thumbnail" src="{{URL::asset('uploads/images/thumb/' . $image->image_url)}}"></a></td>
					<td><a href="/admincp/image/detail/{{ $image->id}}" class="ot-list-link">{{ $image->spherical_id }}</a></td>
					<td>{{ $image->tour_id }}</td>
					<td>{{ $image->view_url }}</td>
					<td>{{ $image->created_by }}</td>
					<td>{{ $image->created_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script>
		$(document).ready(function() {
			$('#table_image').DataTable({
				"ordering": true,
				"paging": true,
				"searching": false,
				"bFilter": false,
				iDisplayLength: 10,
				columnDefs: [{
					orderable: false,
					targets: "no-sort"
				}],
				language: {
					emptyTable: "No images",
					paginate: {
						previous: "<",
						next: ">",
						first: "|<",
						last: ">|"
					}
				}
			});
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
					toastr.info('Please select a row');
				}
				else {
					var check = confirm("Delete selected images?");
					if (check == true) {
						var join_selected_values = allVals.join(",");
						$.ajax({
							url: $(this).data('url'),
							type: 'DELETE',
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							data: 'ids=' + join_selected_values,
							success: function (data) {
								if (data['success'] && data['row'] > 0) {
									$(".sub-chk:checked").each(function() {  
										$(this).parents("tr").remove();
									});
									if (data['imageCount'] > 0) {
										$(".ot-list-row-quantity").text(data['imageCount'] + " 件中 " + "1-" + data['imageCount'] + " 件目");
									}
									else {
										$(".ot-list-row-quantity").text("");
									}
									toastr.success(data['success']);

								} else if (data['error']) {
									toastr.error(data['error']);
								} else {
									toastr.error('This image will not be deleted');
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
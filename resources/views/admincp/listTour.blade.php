@extends('layout.main')

@section('title', 'House List')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
	<style type="text/css">
		.switch {
		  position: relative;
		  display: inline-block;
		  width: 46px;
		  height: 24px;
		}

		.switch input {display:none;}

		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #ccc;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 16px;
		  width: 14px;
		  left: 4px;
		  bottom: 4px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}
		.text-center {
			text-align: center;
		}
	</style>
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">House List</h2>
	</div>
	<!-- <form>
		<select class="ot-input-select">
			<option value="id">コンテンツID</option>
			<option value="title">コンテンツタイトル</option>
			<option value="date_pre">作成日</option>
			<option value="date_up">更新日</option>
			<option value="public">公開/非公開</option>
		</select>
		<span><input class="ot-input-search" type="text" placeholder="コンテンツIDを入力"></span>
	</form> -->
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
			<span>Batch operation  </span><button class="ot-btn-delete js-delete-all" data-url="{{ url('/admincp/house/deleteAll') }}">Delete</button>
			@if ($tours->count() > 0)
				<span class="ot-list-row-quantity">Total {{ $tours->count() }} houses</span>
			@endif
		</div>
		<table class="ot-image-list-table" id="table_tour">
			<thead>
				<th class="no-sort"><input type="checkbox" id="chk-master"></th>
				<!-- <th>非公開</th> -->
				<th class="ot-th-tour-title">Title</th>
				<th>Category</th>
				<th>Created By</th>
				<th>Created At</th>
				<th>Updated At</th>
				<th>Public</th>
			</thead>
			<tbody>
			@foreach($tours as $tour)
				<tr>
					<td><input type="checkbox" class="sub-chk" data-id="{{ $tour->id }}"></td>
					<!-- @if ($tour->is_public === 0)
						<td class="ot-ic-private"><img src="{{ asset('resource/img/padlock.png') }}"></td>
					@else
						<td class="ot-ic-private"></td>
					@endif -->
					<td>
						<a href="/admincp/house/detail/{{ $tour->id }}" class="ot-list-link">
						@if(trim($tour->title) != "")
							{{ $tour->title }}
						@else
							[not have title]
						@endif
						</a>
					</td>
					@if ($tour->category_id === 1)
						<td>Apartment</td>
					@else
						<td>Villas</td>
					@endif
					<td>{{ $tour->created_by }}</td>
					<td>{{ $tour->created_at }}</td>
					<td>{{ $tour->updated_at }}</td>
					<td class="text-center">
						<label class="switch">
						  @if ($tour->is_public)
						  	<input type="checkbox" class="js-set-public" checked>
						  @else
						  	<input type="checkbox" class="js-set-public">
						  @endif
						  <span class="slider round"></span>
						  <input type="hidden" value="{{ $tour->id }}" class="house_id">
						</label>
					</td>
				</tr>
			@endforeach
			<tbody>
		</table>
	</div>
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/spin/spin.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/jquery-ui.min.js') !!}"></script>
	<script>
		$(document).ready(function() {
			$(document).ready(function() {
				// catch event public 
				$(".js-set-public").on('change', function(){
					var house_id = $(this).closest(".switch").find(".house_id").val();
					$.ajax({
						url: '/setPublic',
						type: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							id : house_id
						},
						success: function(data){
							if (data['success']) {
								// toastr.info(data['success']);
							} else {
								// toastr.error("Please try again");
							}
						},
						error: function(data){
							toastr.error("There was an error. Please try again");
						}
					});
				});


				$('#table_tour').DataTable({
					"ordering": true,
					"paging": true,
					"searching": true,
					iDisplayLength: 10,
					columnDefs: [
						{orderable: false, targets: "no-sort"},
						{searchable: false, targets: [0,2,3,4,5]}
					],
					language: {
						emptyTable: "There is no house",
						search: "Search",
						searchPlaceholder: "Input house title",
						paginate: {
							previous: "<",
							next: ">",
							first: "|<",
							last: ">|"
						}
					}
				});
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
					var check = confirm("You want to delete these houses？");
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
									if (data['tourCount'] > 0) {
										$(".ot-list-row-quantity").text(data['tourCount'] + " 件中 " + "1-" + data['tourCount'] + " 件目");
									}
									else {
										$(".ot-list-row-quantity").text("");
									}
									toastr.success(data['success']);
								} else if (data['error']) {
									toastr.error(data['error']);
								} else {
									toastr.error('エラーが発生しました。もう一度お試しください。');
									//toastr.error(data['test']);
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

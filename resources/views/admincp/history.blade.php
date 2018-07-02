@extends('layout.main')

@section('title', 'History Request')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/jquery-ui.min.css') !!}">
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">History Request</h2>
	</div>
	<div class="ot-image-list-table-area">
		<div class="ot-list-table-headline">
		</div>
		<table class="ot-image-list-table" id="table_history">
			<thead>
				<th>Time</th>
				<th style="text-align: center;">House ID</th>
				<th>Email</th>
				<th>Message</th>
				<th style="text-align: center;">Agent</th>
			</thead>
			<tbody>
			@foreach($requests as $request)
				<tr>
					<td>{{ $request->requested_at }}</td>
					<td style="text-align: center;"><a href="/admincp/house/detail/{{ $request->house_id }}">{{ $request->house_id }}</a></td>
					<td>{{ $request->email }}</td>
					<td>{{ $request->message }}</td>
					<td style="text-align: center;">{{ $request->agent_name }}</td>
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
		$(document).ready(function(){
			$('#table_history').DataTable({
				"ordering": true,
				"paging": true,
				"searching": false,
				iDisplayLength: 10,
				columnDefs: [
					{orderable: false, targets: "no-sort"},
					{searchable: false, targets: [0,1,2,3]}
				],
				language: {
					emptyTable: "There is no history",
					paginate: {
						previous: "<",
						next: ">",
						first: "|<",
						last: ">|"
					}
				}
			});
		});
			
	</script>
@stop

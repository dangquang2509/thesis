@extends('layout.main')

@section('title', 'House Statistics')

@section('css')
	<style>
		canvas {
			background: #fff;
		}
		.chart-container {
			position: relative; 
		}
		.ot-image-detail-content {
			background: #fff;
			padding: 18px 12px;
		}
		.total_view {
			margin: 10px;
			font-size: 18px;
		}
		.btn-export {
			background: #edf2f5;
		    border: solid 1px #8F969A;
		    border-radius: 8px;
		    color: #8F969A;
		    text-shadow: none;
		    box-shadow: none;
		    font-weight: 400;
		    height: 30px;
		    line-height: 30px;
		    padding: 0px 16px;
		    cursor: pointer;
		    font-size: 12px;
		}
	</style>
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-page-title-area">
		<h2 class="ot-page-title">House Statistics</h2>
	</div>
	<div class="ot-image-detail-content">
		<div class="chart-container">
			<canvas id="canvas" width="1000" height="400"></canvas>
		</div>
		<div class="total_view">Total view (last 30 days) : {{ $total_view }}</div>
		<div class="total_view">Total request (last 30 days) : {{ $total_request }}</div>
		<div style="text-align: right;"><button class="js-export-csv btn-export">Export as a CSV file</button></div>
	</div>
	<input type="hidden" class="date_label" value="{{ $date_label }}">
	<input type="hidden" class="view_data" value="{{ $view_data }}">
	<input type="hidden" class="request_data" value="{{ $request_data }}">
	
@stop
@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/chart.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('resource/js/lib/chart.bundle.min.js') !!}"></script>
	<script>
		var date_label = JSON.parse($(".date_label").val());
		var view_data = JSON.parse($(".view_data").val());
		var request_data = JSON.parse($(".request_data").val());

		var config = {
			"type":"line",
			"data": {
				"labels": date_label,
				"datasets":[{
					"label": "House View Count",
					"data": view_data,
					"fill": true,
					"borderColor": "rgb(75, 192, 192)",
					"lineTension": 0
				},{
					"label": "Request Count",
					"data": request_data,
					"fill": true,
					"borderColor": "#c45850",
					"lineTension": 0
				}]
			},
			options: {
				responsive: false,
				maintainAspectRatio: true,
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true,
		                    stepSize: 10,
		                    min: 0
		                }
		            }]
		        },
		        title: {
			      display: true,
			      text: 'House Statistics'
			    }
		    }
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);

		};

		$('.js-export-csv').click(function(){
			exportCSV();
		});

		function exportCSV(){
			var A = [['date','view_count','request_count']];

			for(var j=1; j<date_label.length; ++j){ 
			    A.push([date_label[j], view_data[j], request_data[j]]);
			}

			var csvRows = [];

			for(var i=0, l=A.length; i<l; ++i){
			    csvRows.push(A[i].join(','));
			}

			var csvString = csvRows.join("%0A");
			var a         = document.createElement('a');
			a.href        = 'data:attachment/csv,' + csvString;
			a.target      = '_blank';
			a.download    = 'view_stat.csv';

			document.body.appendChild(a);
			a.click();
		}
	</script>
@stop
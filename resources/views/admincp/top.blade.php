@extends('layout.main')

@section('title', 'Top')

@section('css')
@stop

@section('header')
	@include('layout.header')
@stop

@section('content')
	<div class="ot-panel-area">
		<div class="ot-title is-bg is-left"><a class="ot-title-link" href="{{ url('/admincp/house/list') }}">Apartment</a></div>
		@foreach($toursModelHouse as $index => $tour)
			<div class="ot-house-panel">
				<a class="ot-house-panel-image" href="/admincp/house/detail/{{ $tour->id }}">
					<img src="/uploads/images/{{ $imagesModelHouse[$index] }}" class="img-responsive" alt="">
					<div class="overlay">
						<img class="ot-house-panel-image-overlay" src="/resource/img/globe360.png" alt="">
					</div>
				</a>
				<div class="ot-house-panel-content">
					<div class="ot-house-panel-title">{{ $tour->title }}</div>
					<div class="ot-house-panel-time">{{ $tour->created_at }}</div>
				</div>
			</div>
		@endforeach
	</div>
	<div class="ot-panel-area">
		<div class="ot-title is-bg is-left"><a class="ot-title-link" href="{{ url('/admincp/house/list') }}">Villas</a></div>
		@foreach($toursProperty as $index => $tour)
			<div class="ot-house-panel">
				<a class="ot-house-panel-image" href="/admincp/house/detail/{{ $tour->id }}">
					<img src="/uploads/images/{{ $imagesProperty[$index] }}" class="img-responsive" alt="">
					<div class="overlay">
						<img class="ot-house-panel-image-overlay" src="/resource/img/globe360.png" alt="">
					</div>
				</a>
				<div class="ot-house-panel-content">
					<div class="ot-house-panel-title">{{ $tour->title }}</div>
					<div class="ot-house-panel-time">{{ $tour->created_at }}</div>
				</div>
			</div>
		@endforeach
	</div>
@stop

@section('js')

@stop

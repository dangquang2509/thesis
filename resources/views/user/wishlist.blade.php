@extends('layout-user.main')

@section('title', 'Wishlist')

@section('css')
	<style>
		#products {
			margin-top: 64px; 
		}
	</style>
@stop

@section('content')
	<main id="products">
		<section class="properties bg-smooth">
			<div class="page-title">
				<div class="container">
					<h1>Wishlist ({{ count($houses) }} houses)</h1>
				</div>
			</div>
		@foreach ($houses as $house)
			<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/{{ $house->image_thumbnail }});">
				<div class="overlay"></div>
				<div class="center-position">
					<div class="property-container">
						<h2 class="title">{{ $house->title }}</h2>
						<div class="price-tag"><span class="price">${{ $house->price }}</span> <span class="tag">- {{ $house->num_bedrooms }} Bedrooms</span></div>
						<div class="description">
							<p>{{ $house->description }}</p>
						</div>
						<a href="/detail/{{ $house->id }}" class="btn-white viewmore">View Details</a>
					</div>
				</div>
			</div>
		@endforeach
		</section>
	</main>
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
@stop

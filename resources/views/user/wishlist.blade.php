@extends('layout-user.main')

@section('title', 'Wishlist')

@section('css')
	<style>
		#products {
			margin-top: 64px; 
		}
		.single-featured-property {
		    position: relative;
		    z-index: 1;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		    overflow: hidden;
		}
		.single-featured-property .property-thumb {
			position: relative;
			z-index: 1;
		}
		.single-featured-property .property-content {
		    padding: 30px;
    		border: 1px solid #e1dddd;
		}
		.single-featured-property .property-thumb .tag span {
			height: 35px;
		    padding: 0 20px;
		    background-color: #947054;
		    color: #ffffff;
		    text-transform: uppercase;
		    font-size: 12px;
		    font-weight: 600;
		    display: inline-block;
		    line-height: 35px;
		    position: absolute;
		    top: 20px;
		    left: 20px;
		    z-index: 10;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		}
		.single-featured-property .property-thumb .list-price p {
			background-color: #ffffff;
		    padding: 10px 20px;
		    color: #947054;
		    font-size: 24px;
		    font-weight: 600;
		    display: inline-block;
		    position: absolute;
		    bottom: 20px;
		    left: 20px;
		    z-index: 10;
		    margin-bottom: 0;
		    line-height: 1;
		    -webkit-transition-duration: 500ms;
		    transition-duration: 500ms;
		}
		.single-featured-property .property-content h5 {
			font-size: 18px;
			width: 100%;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.single-featured-property .property-content .location {
			color: #947054;
		    margin-bottom: 25px;
		    font-size: 14px;
		    font-weight: 600;
		}
		.single-featured-property .property-content .location img {
		    margin-right: 10px;
		    display: inline-block !important;
		    width: auto !important;
		}
		.single-featured-property .property-content p {
			margin-bottom: 30px;
			width: 100%;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.single-featured-property .property-content .property-meta-data img {
			margin-right: 0;
		    display: inline-block !important;
		    width: auto !important;
		}
		.single-featured-property .property-content .property-meta-data span {
		    font-size: 12px;
		    font-weight: 600;
		    margin-left: 5px;
		    color: #838383;
		}
		.justify-content-between {
		    -webkit-box-pack: justify;
		    -ms-flex-pack: justify;
		    justify-content: space-between;
		    display: inline-block;
		}
		.justify-content-between div {
			display: inline-block;
			margin-right: 16px;
		}
		.listings-content-wrapper {
			margin-top: 16px;
		}
		.mb-50 {
			margin-bottom: 50px;
		}
		.page-title {
			margin: 16px 0;
		}
	</style>
@stop

@section('content')
	<main id="products">
		<section class="properties bg-smooth">
			<div class="container">
				<div class="page-title">
					<div class="container">
						<h1>Wishlist ({{ count($houses) }} houses)</h1>
					</div>
				</div>
				@if(count($houses) > 0)
					@foreach ($houses->chunk(3) as $houses_row)
						<div class="row">
							@foreach($houses_row as $house)
								<!-- Single Featured Property -->
				                <div class="col-md-4 col-sm-12">
				                    <div class="single-featured-property mb-50">
				                        <!-- Property Thumbnail -->
				                        <div class="property-thumb">
				                            <a href="/detail/{{ $house->id }}">
				                            	<img class="img-responsive" src="/uploads/images/{{ $house->image_thumbnail }}" alt="">
				                            </a>
				                            <div class="tag">
				                                <span>For Rent</span>
				                            </div>
				                            <div class="list-price">
				                                <p>${{ $house->price }}</p>
				                            </div>
				                        </div>
				                        <!-- Property Content -->
				                        <div class="property-content">
				                            <h5>{{ $house->title }}</h5>
				                            <p class="location"><img src="resource/img/icon/location.png" alt="">District {{ $house->district }}</p>
				                            <p>{{ $house->description }}</p>
				                            <div class="property-meta-data d-flex align-items-end justify-content-between">
				                                <div class="bathroom">
				                                    <img src="resource/img/icon/bathtub.png" alt="">
				                                    <span>{{ $house->num_toilets }} bath</span>
				                                </div>
				                                <div class="garage">
				                                    <img src="resource/img/icon/garage.png" alt="">
				                                    <span>{{ $house->num_bedrooms }} bed</span>
				                                </div>
				                                <div class="space">
				                                    <img src="resource/img/icon/space.png" alt="">
				                                    <span>{{ $house->area }} m<sup>2</sup></span>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
							@endforeach
						</div>
					@endforeach
				@endif
			</div>
		</section>
	</main>
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
@stop

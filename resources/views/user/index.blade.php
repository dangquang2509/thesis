@extends('layout-user.main')

@section('title', 'Find apartment for rent in Ho Chi Minh City')

@section('css')
	<link rel="stylesheet" type="text/css" href="{!! asset('resource/css/lib/toastr/toastr.min.css') !!}">
	<style>
		.viewall-section {
			margin: 22px 0;
		}
		.south-search-area {
			position: relative;
			z-index: 1;
		}
		.south-search-area .container {
			/*width: 100%;*/
		    padding-right: 15px;
		    padding-left: 15px;
		    margin-right: auto;
		    margin-left: auto;
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
		.section-heading {
			margin: 32px;
			text-transform: uppercase;
			font-weight: bold;
		}
		.section-heading h2 {
			font-size: 30px;
			color: #000;
			font-weight: bold;
		}
		.featured-properties-area {
			margin-bottom: 24px;
		}
		.south-search-area .advanced-search-form {
			position: relative;
		    z-index: 1;
		    padding: 30px 50px;
		    border: 1px solid #e1dddd;
		    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
		}
		.south-search-area .advanced-search-form .search-title {
			position: absolute;
		    width: 260px;
		    height: 45px;
		    background-color: #947054;
		    top: -46px;
		    left: 50%;
		    -webkit-transform: translateX(-50%);
		    transform: translateX(-50%);
		    padding: 0 40px;
		    text-align: center;
		}
		.south-btn {
		    position: relative;
		    z-index: 1;
		    min-width: 120px;
		    color: #ffffff;
		    font-size: 14px;
		    font-weight: 600;
		    background-color: #947054;
		    border-radius: 0;
		    line-height: 32px;
		    padding: 4px 8px;
		    text-transform: uppercase;
		    margin-top: 24px;
		}
		.control {
			margin-top: 42px;
		}
	</style>
@stop

@section('content')
	<main id="homepage">
		<section class="slider">
			<ul class="bxslider">
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/hero1.jpg);" ></div></li>
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/slider-1.jpg);" ></div></li>
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/bg-form-home.jpg);" ></div></li>
			</ul>
			<div class="caption">
				<div class="table-cell">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-9 col-sm-11 col-xs-12 centered text-center">
								<h1 class="title">Find apartment for rent in Ho Chi Minh City</h1>
								<a class="btn-yellow viewmore" href="/all">View Details</a>
							</div>
							<div class="control text-center">
								<div class="prev"></div>
								<div class="next"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ##### Advance Search Area Start ##### -->
	    <div class="south-search-area">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="advanced-search-form">
	                        <!-- Search Title -->
	                        <div class="search-title">
	                            <p>Search for your home</p>
	                        </div>
	                        <!-- Search Form -->
	                        <form class="" action="/search" method="POST" id="advanceSearch">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                            <div class="row">
	                                <div class="col-md-4 col-lg-3">
	                                    <div class="form-group">
	                                        <label>Location</label>
	                                        <select class="form-control" name="district">
	                                            <option value="1">District 1</option>
												<option value="3">District 3</option>
												<option value="4">District 4</option>
												<option value="5">District 5</option>
												<option value="7">District 7</option>
												<option value="Tan Binh">Tan Binh District</option>
	                                        </select>
	                                    </div>
	                                </div>

	                                <div class="col-md-4 col-lg-3">
	                                    <div class="form-group">
	                                        <label>Type</label>
	                                        <select class="form-control" name="category" class="select2">
												<option value="1">Apartment</option>
												<option value="2">Villa</option>
											</select>
	                                    </div>
	                                </div>

	                                <div class="col-md-4 col-xl-2">
	                                    <div class="form-group">
	                                        <label>Bedrooms</label>
	                                        <select class="form-control" name="num_bedrooms">
	                                            <option value="1">1</option>
	                                            <option value="2">2</option>
	                                            <option value="3">3</option>
	                                            <option value="4">4</option>
	                                            <option value="5">5</option>
	                                        </select>
	                                    </div>
	                                </div>

	                                <div class="col-md-4 col-xl-2">
	                                    <div class="form-group">
	                                        <label>Price min ($)</label>
	                                        <input class="form-control" type="number" value="100" min="100" max="4000" step="50" name="price_min">
	                                    </div>
	                                </div>

	                                <div class="col-md-4 col-xl-2">
	                                    <div class="form-group">
	                                        <label>Price max ($)</label>
	                                        <input class="form-control" type="number" value="1000" min="100" max="4000" step="50" name="price_max">
	                                    </div>
	                                </div>

	                                <div class="col-md-4 d-flex justify-content-between align-items-end">
	                                    <!-- Submit -->
	                                    <div class="form-group mb-0">
	                                        <button type="submit" class="btn south-btn">Search</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- ##### Advance Search Area End ##### -->
		<!-- <section class="filter">
			<div class="description">
				<div class="left-container">
					<div class="content">
						<h2  class="yellow-text-gradient title line-bottom line-yellow">Find apartment for rent in Ho Chi Minh City</h2>
						<p>Find a long-term rental place that fits your preferences with 360 Degree Apartment View</p>
					</div>
				</div>
			</div>
			<div class="filter-form">
				<div class="right-container">
					<form class="" action="/search" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<h3 class="blue-text-gradient cta line-bottom">Find your perfect house</h3>
						<div class="gutter-30">
							<div class="col-sm-6 group-input">
								<label for="input-location">Area</label>
								<select name="district" class="select2" id="input-location">
									<option value="1">District 1</option>
									<option value="3">District 3</option>
									<option value="4">District 4</option>
									<option value="5">District 5</option>
									<option value="7">District 7</option>
									<option value="Tan Binh">Tan Binh District</option>
								</select>
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-type">Type</label>
								<select name="category" class="select2">
									<option value="1">Apartment</option>
									<option value="2">Villa</option>
								</select>
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-price">Price Min</label>
								<input type="number" value="100" min="100" max="4000" step="50" name="price_min">
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-price">Price Max</label>
								<input type="number" value="1000" min="100" max="4000" step="50" name="price_max">
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-bedroom">Number of Bedrooms</label>
								<input type="number" value="1" min="1" max="10" step="1" name="num_bedrooms">
							</div>
							<div class="col-sm-6 group-input">
								<button type="submit" class="btn-yellow submit">SEARCH</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section> -->
		<section class="featured-properties-area">
			<div class="container">
				<div class="row">
	                <div class="col-md-12">
	                    <div class="section-heading wow fadeInUp text-center">
	                        <h2>Recently Listed Properties</h2>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	            	@foreach($houses as $house)
	            	<!-- Single Featured Property -->
	                <div class="col-md-4 col-sm-12">
	                    <div class="single-featured-property mb-50 wow fadeInUp" data-wow-delay="100ms">
	                        <!-- Property Thumbnail -->
	                        <div class="property-thumb">
	                            <a href="/detail/{{ $house->id }}">
	                            	<img class="img-responsive" src="/uploads/images/{{ $house->image_thumbnail }}" alt="">
	                            </a>
	                            <div class="tag">
	                                <span>New</span>
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
			</div>
		</section>
		<section class="form-submit form-hasBg submit-type-1">
			<div class="container position-relative">
				<div class="row">
	                <div class="col-md-12">
	                    <div class="section-heading wow fadeInUp text-center">
	                        <h2>Register Now</h2>
	                    </div>
	                </div>
	            </div>
				<div class="description">
					<p>Fill in the form and our team will get in touch with you</p>
				</div>
					<div class="group-input">
						<input type="text" class="js-register-name" name="name" placeholder="Name">
					</div>
					<div class="group-input">
						<input type="text" class="js-register-email" name="email" placeholder="Email">
					</div>
					<div class="group-input">
						<input type="text" class="js-register-phone" name="phone" placeholder="Phone Number">
					</div>
					<button class="btn-yellow submit js-register">Send</button>
			</div>
		</section>
	</main>
@stop

@section('js')
	<script type="text/javascript" src="{!! asset('resource/js/lib/toastr/toastr.min.js') !!}"></script>
@stop

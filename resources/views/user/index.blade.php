@extends('layout-user.main')

@section('title', 'Find apartment for rent in Ho Chi Minh City')

@section('content')
	<main id="homepage">
		<section class="slider">
			<ul class="bxslider">
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/slider-1.jpg);" ></div></li>
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/bg-form-home.jpg);" ></div></li>
				<li data-title="" data-description="" data-link="" ><div class="bg-cover" style="background-image: url(images/slider-1.jpg);" ></div></li>
			</ul>
			<div class="caption">
				<div class="table-cell">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-9 col-sm-11 col-xs-12 centered text-center">
								<h1 class="yellow-text-gradient title">Find apartment for rent in Ho Chi Minh City</h1>
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
			<a href="#" class="scroll-next">
				<i class="icon ion-ios-arrow-down"></i>
				<i class="icon ion-ios-arrow-down"></i>
				<img src="images/mouse-scroll.png">
			</a>
		</section>
		<section class="filter">
			<div class="description">
				<div class="left-container">
					<div class="content">
						<h2  class="yellow-text-gradient title line-bottom line-yellow">Find apartment for rent in Ho Chi Minh City</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
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
								<input type="number" value="100" min="100" max="4000" step="10" name="price_min">
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-price">Price Max</label>
								<input type="number" value="1000" min="100" max="4000" step="10" name="price_max">
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
		</section>
		<section class="properties">
			<div class="page-title">
				<div class="container">
					<h1>Recently Listed Properties</h1>
				</div>
			</div>
			@foreach($houses as $house)
				<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/{{ $house->image_thumbnail }});">
					<div class="overlay"></div>
					<div class="center-position">
						<div class="property-container">
							<h2 class="title">{{ $house->title }}</h2>
							<div class="price-tag"><span class="price">${{ $house->price }}</span> <span class="tag">- {{ $house->num_bedrooms }} Bedroom(s)</span></div>
							<div class="description">
								<p>{{ $house->description }}</p>
							</div>
							<a href="/detail/{{ $house->id }}" class="btn-white viewmore">View Details</a>
						</div>
					</div>
				</div>
			@endforeach
		</section>
			</div>
		</section>
		<section class="form-submit form-hasBg submit-type-1">
			<div class="bg-form">
				<div class="img" style="background-image: url(images/bg-form-home.jpg);"></div>
				<img src="images/icon-logo.svg" class="icon-logo">
			</div>
			<div class="container position-relative">
				<h2 class="form-title yellow-text-gradient">Register now</h2>
				<!-- <div class="description"> -->
					<!-- <p>"An cư lạc nghiệp"</p> -->
					<!-- <p>Hãy tìm cho gia đình bạn một tổ ấm, bằng cách đơn gian nhất!</p> -->
				<!-- </div> -->
				<form action="/user/register" method="POST">
					<div class="group-input">
						<input type="text" name="" placeholder="Name">
					</div>
					<div class="group-input">
						<input type="text" name="" placeholder="Email">
					</div>
					<div class="group-input">
						<input type="text" name="" placeholder="Phone Number">
					</div>
					<button class="btn-yellow submit">Send</button>
				</form>
			</div>
		</section>
	</main>
@stop
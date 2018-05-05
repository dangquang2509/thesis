@extends('layout-user.main')

@section('title', 'Find apartment for rent in Ho Chi Minh City')

@section('header') 
	<header>
	    <nav class="navbar navbar-inverse" id="main-menu">
	        <div class="container">
	            <a class="navbar-brand" href="#">
	                <!-- <img src="images/logo-cong-thong-tin-bds.png" alt=""> -->
	            </a>
	            <div class="navbar-header pull-right">
	                <a class="phone-number" href="tel:0922 11 39 30">
	                    <i class="icon ion-ios-telephone-outline"></i> <span>0908 41 64 84</span>
	                </a>
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span> 
	                </button>
	            </div>
	            <div class="collapse navbar-collapse pull-right" id="myNavbar">
	                <ul class="nav navbar-nav navbar-right">
	                    <li class="active"><a href="#">Home</a></li>
	                    <li><a href="/all">Rent</a></li>
	                    <li><a href="/contact">Contact</a></li>
	                    <li><a href="#">Log In</a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	</header>
@stop

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
							<div class="col-lg-6 col-md-9 col-sm-11 col-xs-12 centered text-center">
								<h1 class="yellow-text-gradient title">Find apartment for rent in Ho Chi Minh City</h1>
								<div class="description">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								</div>
								<a class="btn-yellow viewmore" href="#">View Details</a>
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
					<form class="" action="" method="get">
						<h3 class="blue-text-gradient cta line-bottom">Find your perfect home</h3>
						<div class="gutter-30">
							<div class="col-sm-6 group-input">
								<label for="input-key">Keyword</label>
								<input type="text" name="key" id="input-key" placeholder="Input keyword">
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-location">Area</label>
								<select name="location" class="select2" id="input-location">
									<option value="quan-1">District 1</option>
									<option value="quan-1">District 2</option>
									<option value="quan-1">District 7</option>
								</select>
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-type">Type</label>
								<select name="type" class="select2" id="input-type">
									<option value="quan-1">All Properties</option>
									<option value="quan-1">Apartment</option>
									<option value="quan-1">Villa</option>
									<option value="quan-1">Other</option>
								</select>
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-price">Price</label>
								<select name="price" class="select2" id="input-price">
									<option value="quan-1"> < $500</option>
									<option value="quan-1">$500 - $1,000</option>
									<option value="quan-1"> > $1,000</option>
								</select>
							</div>
							<div class="col-sm-6 group-input">
								<label for="input-badroom">Number of Bedrooms</label>
								<select name="badroom" class="select2" id="input-badroom">
									<option value="quan-1">1</option>
									<option value="quan-1">2</option>
									<option value="quan-1">3+</option>
								</select>
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
			@foreach($houses as $house)
				<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/{{ $house->image_thumbnail }});">
					<div class="overlay"></div>
					<div class="center-position">
						<div class="property-container">
							<h2 class="title">{{ $house->title }}</h2>
							<div class="price-tag"><span class="price">$1,000</span> <span class="tag">- 2 Bedrooms</span></div>
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
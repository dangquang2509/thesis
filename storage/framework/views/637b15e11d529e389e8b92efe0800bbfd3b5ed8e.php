<?php $__env->startSection('title', 'All Houses'); ?>

<?php $__env->startSection('header'); ?> 
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
	                    <li><a href="/user/home">Home</a></li>
	                    <li class="active"><a href="#">Rent</a></li>
	                    <li><a href="/user/contact">Contact</a></li>
	                    <li><a href="#">Log In</a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	</header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<main id="products">
		<section class="map">
			<div id="map"></div>
			<form class="filter-map" method="get" action="">
				<div class="container">
					<div class="gutter-10">
						<div class="col-lg-2 col-sm-4 input">
							<input type="text" name="q" placeholder="Input keyword">
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<select class="select2" name="location">
								<option value="*">Area</option>
								<option value="AL">District 1</option>
								<option value="1">District 3</option>
								<option value="2">District 5</option>
								<option value="3">District 7</option>
								<option value="WY">District 8</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<select class="select2" name="product_type">
								<option value="*">Type</option>
								<option value="AL">All Properties</option>
								<option value="1">Villa</option>
								<option value="2">Apartment</option>
								<option value="3">Townhouse</option>
								<option value="WY">Other</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<select class="select2" name="bad_room">
								<option value="*">Number of Bedrooms</option>
								<option value="AL">1</option>
								<option value="1">2</option>
								<option value="2">3</option>
								<option value="3">4+</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input">
							<select class="select2" name="price">
								<option value="*">Price</option>
								<option value="AL"> < $500</option>
								<option value="1">$500 - $1000</option>
								<option value="2">$1000 - $2000</option>
								<option value="3"> > $2000</option>
							</select>
						</div>
						<div class="col-lg-2 col-sm-4 input text-right">
							<button class="btn-yellow submit">SEARCH</button>
						</div>
					</div>
				</div>
			</form>
		</section>
		<section class="properties bg-smooth">
			<div class="page-title">
				<div class="container">
					<h1>All Properties</h1>
				</div>
			</div>
			<?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
				<div class="col-md-4 col-xs-6 property-info" style="background-image: url(/uploads/images/<?php echo e($house->image_thumbnail); ?>);">
					<div class="overlay"></div>
					<div class="center-position">
						<div class="property-container">
							<h2 class="title"><?php echo e($house->title); ?></h2>
							<div class="price-tag"><span class="price">$1,000</span> <span class="tag">- 2 Bedrooms</span></div>
							<div class="description">
								<p><?php echo e($house->description); ?></p>
							</div>
							<a href="/user/detail/<?php echo e($house->id); ?>" class="btn-white viewmore">View Details</a>
						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			<nav class="navigation pagination" role="navigation">
				<div class="nav-links">
					<a class="next page-numbers" href="#"><i class="icon ion-chevron-left" aria-hidden="true"></i></a>
					<span class="page-numbers current"><span class="meta-nav screen-reader-text"> </span>1</span>
					<a class="page-numbers" href="#"><span class="meta-nav screen-reader-text"> </span>2</a>
					<span class="page-numbers dots">...</span>
					<a class="page-numbers" href="#"><span class="meta-nav screen-reader-text"> </span>20</a>
					<a class="next page-numbers" href="#"><i class="icon ion-chevron-right" aria-hidden="true"></i></a>
				</div>
			</nav>
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
			</div>
		</section>
	</main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmPq7GJGWrVXertDiV_JZcUUpAXp1cb5c"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"> </script>
    <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/infobox/1.1.13/src/infobox.js"></script>
	
	<script>
		$(document).ready(function() {
			var propertyDefault = {
				url: "",
				thumb: "images/bg-form-home.jpg",
				title: "Dự án bac",
				price: "124 Triệu/m<sup>2</sup>"
			};
			var locations = [
				{lat: -31.563910, lng: 147.154312, property: propertyDefault},
				{lat: -33.718234, lng: 150.363181, property: propertyDefault},
				{lat: -33.727111, lng: 150.371124, property: propertyDefault},
				{lat: -33.848588, lng: 151.209834, property: propertyDefault},
				{lat: -33.851702, lng: 151.216968, property: propertyDefault},
				{lat: -34.671264, lng: 150.863657, property: propertyDefault},
				{lat: -35.304724, lng: 148.662905, property: propertyDefault}
			]
			var setupMap = {
				zoom: 6,
				icon_marker: "images/map-marker.png",
				icon_cluster: "images/cluster-icon.png"
			}

			function initMap() {

				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: setupMap['zoom'],
					center: centerMap()
				});

				// var markers = locations.map(function(location, i) {
				// 	return new google.maps.Marker({
				// 		position: location,
				// 		icon: "images/map-marker.png"
				// 	});
				// });
				var markers = [];
				locations.forEach(function(location){
					var marker = new google.maps.Marker({
						map: map,
						draggable: true,
						position: new google.maps.LatLng(location.lat, location.lng),
						visible: true,
						icon: setupMap['icon_marker']
					});
					markers.push(marker);

					setEventMarkerInfo(marker, map, location.property);
				})

				var markerClustererOptions = {
					ignoreHidden: true,
					maxZoom: 14,
					styles: [{
						textColor: '#ffffff',
						url: setupMap['icon_cluster'],
						height: 48,
						width: 48
					}]
				};

				var markerCluster = new MarkerClusterer(map, markers, markerClustererOptions);

			}
			function centerMap(){
				var centerMap = {lat: 0, lng: 0};
				locations.forEach(function(item){
					centerMap.lat += item.lat;
					centerMap.lng += item.lng;
				})
				centerMap.lat = centerMap.lat / locations.length;
				centerMap.lng = centerMap.lng / locations.length;
				return centerMap;
			}
			function setEventMarkerInfo(marker, map, property){
				var boxText = document.createElement("div");
				boxText.className = 'map-info-window';
				var innerHTML = "";
				if ( property.thumb ) {
					innerHTML += '<a class="thumb-link" href="' + property.url + '">' +
					'<img class="prop-thumb" src="' + property.thumb + '" alt="' + property.title + '"/>' +
					'</a>';
				}
				innerHTML += '<h5 class="prop-title"><a class="title-link" href="' + property.url + '">' + property.title + '</a></h5>';
				if ( property.price ) {
					innerHTML += '<p><span class="price">' + property.price + '</span></p>';
				}
				innerHTML += '<div class="arrow-down"></div>';
				boxText.innerHTML = innerHTML;

				var myOptions = {
					content: boxText
					,disableAutoPan: false
					,maxWidth: 0
					,boxStyle: { width: '240px' }
					,pixelOffset: new google.maps.Size(-120, -45)
					,zIndex: null
					,alignBottom: true
					,closeBoxMargin: "0 0 -16px -16px"
					,closeBoxURL: "images/close.png"
					,infoBoxClearance: new google.maps.Size(1, 1)
					,isHidden: false
					,pane: "floatPane"
					,enableEventPropagation: false
				};

				var ib = new InfoBox(myOptions);
				marker.addListener("click", function(){
					ib.open(map, marker);
				})
			}

			if ($("#map").length > 0)
				initMap();
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout-user.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
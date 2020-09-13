<?php
include_once('config.php');
include_once('functions.php');
include('hindex.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=SITENAME?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/all.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/chosen.min.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/leaflet.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/MarkerCluster.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/MarkerCluster.Default.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/betterScale.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/leaflet.contextmenu.min.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/L.Control.Zoomslider.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/Control.FullScreen.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/leaflet.contextmenu.min.css" />
		<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="<?=base_url?>css/style.css">

		<style>

			html,body{
					height: 100vh !important;
			}


			.mt-4{
				margin-top: 0 !important;
			}

			input[type=checkbox], input[type=radio]{
					top:1px;
			}

			.chosen-container-single, .chosen-container-multi{
				width:100% !important;
			}


			.btn-clear{
				color: #E31E24;
				background: transparent;
				transition: all 0.3s;
			}

			.btn-clear:hover{
				color:#fff;
				background: #E31E24;
			}

			.btn-filter{
				width: 100%;
			}

			.leaflet-control-attribution a:hover{
				font-size: inherit;

			}


			@media only screen and (max-width: 640px) {
				.clear-filterr, .desktop_none{
					margin-top: 20px;
				}
			}

			#map { position: absolute; top:0; bottom:0; right:0; left:0; }
			#basemaps-wrapper {
				position: absolute;
				top: 10px;
				right: 10px;
				z-index: 400;
				background: white;
				padding: 10px;
			}
			#basemaps {
				margin-bottom: 5px;
			}
			#grid-wrapper {
				position: absolute;
				top: 80px;
				right: 10px;
				z-index: 400;
				background: white;
				padding: 10px;
			}
			#grid {
				margin-bottom: 5px;
			}
		</style>

	</head>
	<body class="viewer">
		<div class="navbar_area">
			<nav class="navbar navbar-expand-lg navbar-light bg-blue">
				<div class="logo_main" >
					<a class="navbar-brand" href="https://ihfc-iugg.org/">
						<img src="https://ihfc-iugg.org/user/themes/quark/images/grav-logo.svg">
					</a>
				</div>
				<h1 class="page-header"><?=SITENAME?></h1>
			</nav>
		</div>
		<div class="container-fluid">
			<form action="" method="post" id="search_frm">
				<div class="row no-gutters">
					<div class="col-sm-12 ">
						<div class=" desktop_none">
							<button class="btn btn-primary">Filter Map</button>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-12">
						<div class="search__areaa srclicolst mobile_block">
							<div class="select-table">
							<div class="form-group mb-3">
								<select class="form-control chosen-select" name="select_year" id="select_year" data-placeholder="Select Year">
									<option value="">Site Year</option>
									<option value="2010" <?php if(isset($_POST['select_year']) && $_POST['select_year'] == '2010'){ echo 'selected'; }else{ echo 'selected'; }?>>2010</option>
									<option value="2020" <?php if(isset($_POST['select_year']) && $_POST['select_year'] == '2020'){ echo 'selected'; }?>>2020</option>
								</select>
							</div>
						</div>
						<hr>
							<div class="mt-3">
								<h5 class="brosiclit">Filter Map</h5>
							</div>
							<!--- disable global search 
								<div class="form-group mb-4">
									<input type="text" class="form-control" id="search" name="s" value="<?php // if(isset($_POST['s']) && $_POST['s'] != ''){ echo $_POST['s']; }?>" placeholder="Search...">
								</div>
									-->

								<!-- disable lower year selection 
								<div class="form-group mb-3">
									<select class="form-control chosen-select" name="select_year" id="select_year" data-placeholder="Select Year">
										<option value="">Site Year</option>
										<option value="2010" <?php if(isset($_POST['select_year']) && $_POST['select_year'] == '2010'){ echo 'selected'; }else{ echo 'selected'; }?>>2010</option>
										<option value="2020" <?php if(isset($_POST['select_year']) && $_POST['select_year'] == '2020'){ echo 'selected'; }?>>2020</option>
									</select>
								</div>
							-->


								<div class="form-group mb-3">
									<select class="form-control chosen-select" name="sitename" id="sitename" data-placeholder="Site name">
										<option value="">Site name</option>
										<?php
											$allSiteName = allSiteName();
											if(!empty($allSiteName)){
												foreach($allSiteName as $siteName){
													$selected = '';
													if(isset($_POST['sitename']) && $_POST['sitename'] == $siteName->site_name){
														$selected = 'selected=""';
													}
													echo '<option value="'.$siteName->site_name.'" '.$selected.'>'.$siteName->site_name.'</option>';
												}
											}
										?>
									</select>
								</div>
								<div class="form-group mb-3">
									<!-- <label for="countty"> Region</label> -->
									<select class="form-control chosen-select" id="country" name="country[]" data-placeholder="Region or country" multiple>
										<option value="">Region or country</option>
										<?php
											$allCountry = allCountry();
											if(!empty($allCountry)){
												foreach($allCountry as $country){
													$selected = '';
													if(!empty($_POST['country']) && in_array($country->region, $_POST['country'])){
														$selected = 'selected=""';
													}
													echo '<option value="'.$country->region.'" '.$selected.'>'.$country->region.'</option>';
												}
											}
										?>
									</select>
								</div>

								<div class="form-group mb-3">
									<!-- <label for="conti"> Continents</label> -->
										<select class="form-control chosen-select" name="continent[]" id="continent" data-placeholder="Continent" multiple>
											<option value="">Continent</option>
											<?php
												$allContinent = allContinent();
												if(!empty($allContinent)){
													foreach($allContinent as $continent){
														$selected = '';
														if(!empty($_POST['continent']) && in_array($continent->continent, $_POST['continent'])){
															$selected = 'selected=""';
														}
														echo '<option value="'.$continent->continent.'" '.$selected.'>'.$continent->continent.'</option>';
													}
												}
											?>
									</select>
								</div>

								<div class="form-group mb-3">
									<!-- <label for="search"> Search Year</label>
										<select class="form-control chosen-select" name="year" id="year" data-placeholder="Year of publication">
											<option value="">Year of publication</option>
											<?php
												$allYears = allYears();
												if(!empty($allYears)){
													foreach($allYears as $year){
														$selected = '';
														if(isset($_POST['year']) && $_POST['year'] == $year->year_of_pub){
															$selected = 'selected=""';
														}
														echo '<option value="'.$year->year_of_pub.'" '.$selected.'>'.$year->year_of_pub.'</option>';
													}
												}
											?>
									</select>   -->  
								</div>

								<div class="form-group mb-3">
									<!-- <label for="conti"> Reference</label> -->
										<select class="form-control chosen-select" name="reference[]" id="reference" data-placeholder="Reference" multiple>
											<option value="">Reference</option>
											<?php
												$allReferences = allReferences();
												if(!empty($allReferences)){
													foreach($allReferences as $reference){
														$selected = '';
														if(!empty($_POST['reference']) && in_array($reference->reference, $_POST['reference'])){
															$selected = 'selected=""';
														}
														echo '<option value="'.$reference->reference.'" '.$selected.'>'.$reference->reference.'</option>';
													}
												}
											?>
									</select>
								</div>

								<div class="form-group mb-3">
									<!-- <label for="conti">Domains</label> -->
										<div class="all-ctg">
											<div class="form-group form-check">
												<label><input checked class="form-check-input" type="radio" id="domain" name="domain" value="" <?php if(isset($_POST['domain']) && $_POST['domain'] == ''){ echo 'checked'; }?>>All</label>
											</div>

											<div class="form-group form-check">
											<label><input class="form-check-input" type="radio" id="domain" name="domain" value="marine" <?php if(isset($_POST['domain']) && $_POST['domain'] == 'marine'){ echo 'checked'; }?>>Marine</label>
											</div>

											<div class="form-group form-check">
											<label><input class="form-check-input" type="radio" id="domain" name="domain" value="continental" <?php if(isset($_POST['domain']) && $_POST['domain'] == 'continental'){ echo 'checked'; }?>>Continental</label>
											</div>
									</div>
								</div>


								<div class="form-group mb-3">
									<label for="search"> Heat-Flow [mW/m<sup>2</sup>]</label>
									<input type="text" id="heatflow" style="border:0; color:#E31E24; font-weight:bold; font-size:14px; width:38%; overflow: visible;">
									<div id="slider-range"></div>
									<input type="hidden" name="min_heat_flow" id="min_heat_flow" value="<?php if(isset($_POST['min_heat_flow']) && $_POST['min_heat_flow'] > 0){ echo $_POST['min_heat_flow']; }?>" />
									<input type="hidden" name="max_heat_flow" id="max_heat_flow" value="<?php if(isset($_POST['max_heat_flow']) && $_POST['max_heat_flow'] > 0){ echo $_POST['max_heat_flow']; }?>" />
								</div>

								<div class="form-group mb-3">
									<label for="search"> Depth [m]</label>
									<input type="text" id="depth" style="border:0; color:#E31E24; font-weight:bold; font-size:14px; width:38%; overflow: visible;">
									<div id="slider-range2"></div>
									<input type="hidden" name="mind" id="mind" value="<?php if(isset($_POST['mind']) && $_POST['mind'] > 0){ echo $_POST['mind']; }?>" />
									<input type="hidden" name="maxd" id="maxd" value="<?php if(isset($_POST['maxd']) && $_POST['maxd'] > 0){ echo $_POST['maxd']; }?>" />
								</div>


								<div class="form-group mb-3">
									<label for="search"> Years</label>
									<input type="text" id="year" style="border:0; color:#E31E24; font-weight:bold; font-size:14px; width:38%; overflow: visible;">
									<div id="slider-range3"></div>
									<input type="hidden" name="min_year" id="min_year" value="<?php if(isset($_POST['min_year']) && $_POST['min_year'] > 0){ echo $_POST['min_year']; }?>" />
									<input type="hidden" name="max_year" id="max_year" value="<?php if(isset($_POST['max_year']) && $_POST['max_year'] > 0){ echo $_POST['max_year']; }?>" />
								</div>


								<div class="row pt-3">
									<div class="col-sm-6">
										<div class="clear-filterr text-center">
											<button type="submit" name="search" value="search_value" class="btn btn-primary btn-filter btn-apply"> Apply Filter</button>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="clear-filterr text-center">
											<a href="" class="btn btn-danger btn-filter btn-clear" > Clear Filter</a>
										</div>
									</div>
								</div>

							<br/>
							<!-- <hr style="border-top: 1px solid grey;" noshade> </hr> -->

							<div id="legend">
							<h5>Legend</h5>

							<label for="legend">Heat-flow [mW/m<sup>2</sup>]</label>
							<br/>
							<div>
									<span><img src="http://www.ihfc-iugg.org/viewer/map_icon/map1.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">&le; 0 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map2.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">0&ndash;25 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map3.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">25&ndash;50 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map4.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">50&ndash;75 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map5.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">75&ndash;100 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map6.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">100&ndash;150 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map7.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">150&ndash;250 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map8.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">250&ndash;500 |</span>
									<span style="padding-left:15px;"><img src="https://www.ihfc-iugg.org/viewer/map_icon/map9.png" alt="" border="0" width="25px" height=""></span><span style="width:50px;text-align:right;">&gt;500 |</span>
							</div>
							<div style="margin-top:15px">
									<span><img src="http://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l1.png" alt="" border="0" width="25px" height="">
									<img src="http://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l2.png" alt="" border="0" width="25px" height="">
									<img src="http://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l3.png" alt="" border="0" width="25px" height="">
											&nbsp;Data cluster with X values</span>
							</div>
							</div>
						</div>
					</div>

					<div class="col-lg-10 col-md-9 col-sm-12 mb-2">
						<div id="map" class="mapp"></div>
						<div id="basemaps-wrapper" class="leaflet-bar">
						<select id="basemaps">
							<option value="Topographic">Topographic</option>
							<option value="Streets">Streets</option>
							<option value="NationalGeographic">National Geographic</option>
							<option value="Oceans">Oceans</option>
							<option value="Gray">Gray</option>
							<option value="DarkGray">Dark Gray</option>
							<option value="Imagery">Imagery</option>
							<option value="ImageryClarity">Imagery (Clarity)</option>
							<option value="ImageryFirefly">Imagery (Firefly)</option>
							<option value="ShadedRelief">Shaded Relief</option>
							<option value="Physical">Physical</option>
						</select>
						</div>
						<div id="grid-wrapper" class="leaflet-bar">
							
							<select class="" name="grid" id="grid" data-placeholder="Select Year">
								<option value="no" <?php if(isset($_POST['grid']) && $_POST['grid'] == 'no'){ echo 'selected'; }else{ echo 'selected'; }?>>Grid Off</option>
								<option value="yes" <?php if(isset($_POST['grid']) && $_POST['grid'] == 'yes'){ echo 'selected'; }?>>Grid On</option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>

		<?php
			$heatflow_sql = "SELECT MAX(heatflow) AS mx_hf, MIN(heatflow) AS mn_hf FROM `IHFC2010`";
			$stmt = $conn->prepare($heatflow_sql);
			$stmt->execute();
			$heatflow_data = $stmt->fetch(PDO::FETCH_OBJ);
		?>
		<?php
			$year_sql = "SELECT MAX(year_of_pub) AS mx_y, MIN(year_of_pub) AS mn_y FROM `IHFC2010`";
			$stmt = $conn->prepare($year_sql);
			$stmt->execute();
			$year_data = $stmt->fetch(PDO::FETCH_OBJ);
		?>

		<!-- JavaScript Includes Start-->

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		
		<script src="<?=base_url?>js/chosen.jquery.min.js"></script>
		<script src="<?=base_url?>js/custom.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js" integrity="sha512-MQlyPV+ol2lp4KodaU/Xmrn+txc1TP15pOBF/2Sfre7MRsA/pB4Vy58bEqe9u7a7DczMLtU5wT8n7OblJepKbg==" crossorigin="anonymous"></script>
		<script src='<?=base_url?>js/betterScale.js'></script>
		<script src='<?=base_url?>js/MousePosition.js'></script>
		<script src='<?=base_url?>js/L.Control.Zoomslider.js'></script>
		<script src='<?=base_url?>js/Control.FullScreen.js'></script>
		<script src="<?=base_url?>js/bundle.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-contextmenu/1.4.0/leaflet.contextmenu.min.js" integrity="sha512-8sfQf8cr0KjCeN32YPfjvLU2cMvyY1lhCXTMfpTZ16CvwIzeVQtwtKlxeSqFs/TpXjKhp1Dcv77LQmn1VFaOZg==" crossorigin="anonymous"></script>
		<script src='<?=base_url?>js/L.Graticule.js'></script>
		<script src='<?=base_url?>js/esri-leaflet.js'></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier-Leaflet/0.2.6/oms.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

		<!-- JavaScript Includes End-->

		<script>
			var markers = <?php print $map_arr_json_data;?>
		</script>
		<script>

			var cities = L.layerGroup();

			// L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities),
			// L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities),
			// L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities),
			// L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);


			var mbAttr = '&copy; <a href="http://ihfc-iugg.org/">www.ihfc-iugg.org</a>',
				mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

			var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}),
				streets  = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});

			var map = L.map( 'map', {
				center: [10.0, 5.0],
				minZoom: 2,
				zoom: 2,
				layers: [grayscale, cities],
				contextmenu: true,
				contextmenuWidth: 140,
				contextmenuItems: [{
					text: 'Show coordinates',
					callback: showCoordinates
				}, {
					text: 'Center map here',
					callback: centerMap
				}, '-', {
					text: 'Zoom in',
					icon: 'images/zoom-in.png',
					callback: zoomIn
				}, {
					text: 'Zoom out',
					icon: 'images/zoom-out.png',
					callback: zoomOut
				}]
			});

			var baseLayers = {
				"Grayscale": grayscale,
				"Streets": streets
			};

			var overlays = {
				//"Cities": cities
			};


			//L.control.layers(baseLayers, overlays).addTo(map);
			

			//var myURL = jQuery( 'script[src$="leaf-demo.js"]' ).attr( 'src' ).replace( 'leaf-demo.js', '' );

			/* var myIcon = L.icon({
			iconUrl: 'my_icon.png',
			iconRetinaUrl: 'gm.png',
			iconSize: [29, 24],
			iconAnchor: [9, 21],
			popupAnchor: [0, -14]
			}); */


		


			var heatflow;

			var markerClusters = L.markerClusterGroup();

			for ( var i = 0; i < markers.length; ++i )
			{

				heatflow = markers[i].heat_fl;
				//console.log(heatflow);
				if(heatflow == 0){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map1.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 0 && heatflow <= 25 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map2.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 25 && heatflow <= 50 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map3.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 50 && heatflow <= 75 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map4.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 75 && heatflow <= 100 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map5.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 100 && heatflow <= 150 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map6.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 150 && heatflow <= 250 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map7.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 250 && heatflow <= 500 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map8.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -14]
						});
				}else{
					var myIcon = L.icon({
						iconUrl: 'map_icon/map9.png',
						iconSize: [28, 25],
						iconAnchor: [9, 21],
						popupAnchor: [0, -15]
						});

				}
				var popup = '<br>Heat-Flow Density</br> <h4 class="pop-header">'+ markers[i].heat_fl + ' <span> mW/m<sup>2</sup> </h4>' +
				<!-- '<div class="kreis">test</div>'+    -->
				'<table> <tr> <td> <b>Site Name: </b> </td> <td style="padding-left:10px;"> '+ markers[i].name + '</td> </tr>' +
				'<tr> <td><b>Coordinates: </b> </td> <td style="padding-left:10px;">Lat ' + markers[i].lat +' / Long ' + markers[i].lng +'</td></tr>' +
				'<tr> <td> <b>Domain: </b> </td> <td style="padding-left:10px;">' + markers[i].dnm + '</td> </tr>' +
				' <tr> <td> <b>Region at: </b> </td> <td style="padding-left:10px;">' + markers[i].crt +'</td> </tr>' +
				' <tr> <td> <b>Reference: </b> </td> <td style="padding-left:10px;">' + markers[i].ref +'</td> </tr>' +
				' <tr> <td> <b>Data status: </b> </td> <td style="padding-left:10px;">original, not verified</td> </tr> </table>'+
				' <br/> Did you find an error or want <br/>to comment on this value? &rArr; <a href="mailto:heatflow@ihfc-iugg.org?subject=IHFC Heat Flow Viewer - New error report or comment" class="error-report">Contact us!</a> ';

			var m = L.marker( [markers[i].lat, markers[i].lng], {icon: myIcon} )
							.bindPopup( popup );

			markerClusters.addLayer( m );
			}

			map.addLayer( markerClusters );

				//add better scale

				L.control.betterscale().addTo(map);
				L.control.mousePosition().addTo(map);

			




			// create fullscreen control
			var fsControl = L.control.fullscreen();
			// add fullscreen control to the map
			map.addControl(fsControl);

			// detect fullscreen toggling
			map.on('enterFullscreen', function(){
				if(window.console) window.console.log('enterFullscreen');
			});
			map.on('exitFullscreen', function(){
				if(window.console) window.console.log('exitFullscreen');
			});

			//print
			var printer = L.easyPrint({
							sizeModes: ['Current', 'A4Landscape', 'A4Portrait'],
							filename: 'myMap',
							exportOnly: true,
							hideControlContainer: true
						}).addTo(map);

			<?php if(isset($_POST['grid']) && $_POST['grid'] == 'yes'){ ?>
			// Add a basic graticule with divisions every 20 degrees
			// as a layer on a map
			L.graticule().addTo(map);

			// Specify divisions every 10 degrees
			L.graticule({ interval: 20 }).addTo(map);

			// Specify bold red lines instead of thin grey lines
			L.graticule({
					sphere: true,
					style: {
						color: '#777',
						opacity: 0.1,
						// fillColor: '#ccf',

						weight: 0.3
					}
				}).addTo(map);

				L.graticule({
					style: {
						color: '#777',
						weight: 0.3,
						opacity: 0.1
					}
				}).addTo(map);

		<?php } ?>


		// oms starts


		//oms ends




		// L.geoJson(countries, {
		//     style: {
		//         color: '#000',
		//         weight: 0.5,
		//         opacity: 1,
		//         fillColor: '#fff',
		//         fillOpacity: 1
		//     }
		// }).addTo(map);

		// map.fitWorld();




		// call functions for conetext menu


		function showCoordinates (e) {
			alert(e.latlng);
		}

		function centerMap (e) {
			map.panTo(e.latlng);
		}

		function zoomIn (e) {
			map.zoomIn();
		}

		function zoomOut (e) {
			map.zoomOut();
		}


		
		$('#grid').on('change', function() {
		//alert( this.value );
			$( "#search_frm" ).submit();
		});
		
		$('#basemaps').on('change', function() {
		//alert( this.value );
			var basemap = this.value;
			setBasemap(basemap);
		});

		var layer = L.esri.basemapLayer('Topographic').addTo(map);
		var layerLabels;
		function setBasemap (basemap) {
			if (layer) {
			map.removeLayer(layer);
			}

			layer = L.esri.basemapLayer(basemap);

			map.addLayer(layer);

			if (layerLabels) {
			map.removeLayer(layerLabels);
			}

			if (
			basemap === 'ShadedRelief' ||
			basemap === 'Oceans' ||
			basemap === 'Gray' ||
			basemap === 'DarkGray' ||
			basemap === 'Terrain'
			) {
			layerLabels = L.esri.basemapLayer(basemap + 'Labels');
			map.addLayer(layerLabels);
			} else if (basemap.includes('Imagery')) {
			layerLabels = L.esri.basemapLayer('ImageryLabels');
			map.addLayer(layerLabels);
			}
		}
		
		// end of context menu



		</script>
		<!--script type='text/javascript' src='<?=base_url?>maps/leaf-demo.js'></script-->

		<script type="text/javascript">
			$(function(){
				$(".chosen-select").chosen();
			});

			// ##### Heat Flow ##### 
			//$(function() {
				var min_val;
				var max_val;
				var def_min_val = parseFloat(<?php echo $heatflow_data->mn_hf; ?>);
				var def_max_val = parseFloat(<?php echo $heatflow_data->mx_hf; ?>);

				<?php
					if(isset($_POST['min_heat_flow']) && $_POST['min_heat_flow'] > 0){
						?>
						min_val = <?php echo $_POST['min_heat_flow'];?>;
						<?php
					}else{
						?>
						min_val = <?php echo $heatflow_data->mn_hf; ?>;
						<?php
					}

					if(isset($_POST['max_heat_flow']) && $_POST['max_heat_flow'] > 0){
						?>
						max_val = <?php echo $_POST['max_heat_flow'];?>;
						<?php
					}else{
						?>
						max_val = <?php echo $heatflow_data->mx_hf; ?>;
						<?php
					}
				?>

				$( "#slider-range" ).slider({
					range: true,
					min: def_min_val,
					max: def_max_val,
					values: [ min_val, max_val ],
					slide: function( event, ui ) {
						$( "#heatflow" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
						$( "#min_heat_flow" ).val(ui.values[ 0 ]);
						$( "#max_heat_flow" ).val(ui.values[ 1 ]);
						/*setTimeout(function(){
							$( "#search_frm" ).submit();
						}, 500);*/
					}
				});

				$( "#heatflow" ).val( $( "#slider-range" ).slider( "values", 0 ) + " - " + $( "#slider-range" ).slider( "values", 1 ) );
				-->

			//-- ##### Year ##### -->

			$(function() {
				var miny_val;
				var maxy_val;
				var def_miny_val = parseFloat(<?php echo $year_data->mn_y; ?>);
				var def_maxy_val = parseFloat(<?php echo $year_data->mx_y; ?>);

				<?php
					if(isset($_POST['min_year']) && $_POST['min_year'] > 0){
						?>
						miny_val = <?php echo $_POST['min_year'];?>;
						<?php
					}else{
						?>
						miny_val = <?php echo $year_data->mn_y; ?>;
						<?php
					}

					if(isset($_POST['max_year']) && $_POST['max_year'] > 0){
						?>
						maxy_val = <?php echo $_POST['max_year'];?>;
						<?php
					}else{
						?>
						maxy_val = <?php echo $year_data->mx_y; ?>;
						<?php
					}
				?>

				$( "#slider-range3" ).slider({
					range: true,
					min: def_miny_val,
					max: def_maxy_val,
					values: [ miny_val, maxy_val ],
					slide: function( event, ui ) {
						$( "#year" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
						$( "#min_year" ).val(ui.values[ 0 ]);
						$( "#max_year" ).val(ui.values[ 1 ]);
						/*setTimeout(function(){
							$( "#search_frm" ).submit();
						}, 500);*/
					}
				});

				$( "#year" ).val( $( "#slider-range3" ).slider( "values", 0 ) + " - " + $( "#slider-range3" ).slider( "values", 1 ) );

				//-- ##### Depth ##### -->
		<?php
			$mind_sql = "SELECT MIN(mind) AS mn_mind FROM `IHFC2010` WHERE mind > 0 ";
			$stmt = $conn->prepare($mind_sql);
			$stmt->execute();
			$mind_data = $stmt->fetch(PDO::FETCH_OBJ);

			$maxd_sql = "SELECT MAX(maxd) as mx_maxd FROM `IHFC2010` WHERE maxd > 0 ";
			$stmt = $conn->prepare($maxd_sql);
			$stmt->execute();
			$maxd_data = $stmt->fetch(PDO::FETCH_OBJ);
		?>

				var mind;
				var maxd;
							var def_mind_val = parseFloat(<?php echo $mind_data->mn_mind; ?>);
				var def_maxd_val = parseFloat(<?php echo $maxd_data->mx_maxd; ?>);


				<?php
					if(isset($_POST['mind']) && $_POST['mind'] > 0){
						?>
						mind = <?php echo $_POST['mind'];?>;
						<?php
					}else{

						?>
						mind = <?php echo $mind_data->mn_mind; ?>;
						<?php
					}

					if(isset($_POST['maxd']) && $_POST['maxd'] > 0){
						?>
						maxd = <?php echo $_POST['maxd'];?>;
						<?php
					}else{

						?>
						maxd = <?php echo $maxd_data->mx_maxd; ?>;
						<?php
					}
				?>

				$( "#slider-range2" ).slider({
					range: true,
					min: def_mind_val,
					max: def_maxd_val,
					values: [ mind, maxd ],
					slide: function( event, ui ) {
						$( "#depth" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
						$( "#mind" ).val(ui.values[ 0 ]);
						$( "#maxd" ).val(ui.values[ 1 ]);
						/*setTimeout(function(){
							$( "#search_frm" ).submit();
						}, 500); */
					}
				});

				$( "#depth" ).val( $( "#slider-range2" ).slider( "values", 0 ) + " - " + $( "#slider-range2" ).slider( "values", 1 ) );

			});

			/*$("#search, #sitename, #country, #continent, #domain, #mind, #maxd, #year, #reference").change(function() {
				this.form.submit();
			});*/
		</script>

		<script>
				$(document).ready(function(){
				$(".desktop_none").click(function(){
					//$(".mobile_block").fadeToggle(900);
					$(".mobile_block").toggle("slow");
				});
				});
		</script>
		
	</body>
</html>
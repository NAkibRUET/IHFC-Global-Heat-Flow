<?php
include_once('config.php');
include_once('functions.php');
include('hindex.php');
//echo(count($all_map_data));
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=SITENAME?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha512-L7MWcK7FNPcwNqnLdZq86lTHYLdQqZaz5YcAgE+5cnGmlw8JT03QB2+oxL100UeB6RlzZLUxCGSS4/++mNZdxw==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" integrity="sha512-1xoFisiGdy9nvho8EgXuXvnpR5GAMSjFwp40gSRE3NwdUdIMIKuPa7bqoUhLD0O/5tPNhteAsE5XyyMi5reQVA==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css" integrity="sha512-BBToHPBStgMiw0lD4AtkRIZmdndhB6aQbXpX7omcrXeG2PauGBl2lzq2xUZTxaLxYz5IDHlmneCZ1IJ+P3kYtQ==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css" integrity="sha512-RLEjtaFGdC4iQMJDbMzim/dOvAu+8Qp9sw7QE4wIMYcg2goVoivzwgSZq9CsIxp4xKAZPKh5J2f2lOko2Ze6FQ==" crossorigin="anonymous" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/betterScale.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/leaflet.contextmenu.min.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/L.Control.Zoomslider.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url?>css/Control.FullScreen.css" />
		<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="<?=base_url?>css/style.css">
		<style>
			.leaflet-control-attribution a{
				font-size: inherit !important;
			}
			.mycluster {
				width: 34px;
				height: 34px;
				border-radius: 50%;
				text-align: center;
				padding-top:7px;
				font-size:12px;
			}
			.myclusterGray{
				
				border: 5px solid rgba(197, 197, 197, 0.5);
				color:black;
				background-color: rgba(191, 191, 191, 0.8);
				background-clip: padding-box;
			}
			
			.myclusterDarkGray{
				border: 5px solid rgba(173, 173, 173, 0.5);
				color:black;
				background-color:rgba(168, 168, 168, 0.7);
				background-clip: padding-box;
			}
			.myclusterDarkerGray{
				font-size:11px;
				border: 5px solid rgba(144, 144, 144, 0.5);
				color:black;
				background-color: rgba(138, 138, 138, 0.8);
				background-clip: padding-box;
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
				<button type="button" class="helpbtn btn btn-light" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-question"></i></button>
			</nav>
		</div>
		<div class="containerFluid">
			<form action="" method="post" id="search_frm">
				<div class="row no-gutters">
					<div class="col-sm-12 ">
						<div class=" desktop_none">
							<button type="button" class="btn btn-primary">Filter Database</button>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-12 ">
						<div class="sideNav srclicolst mobile_block" style="">
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
								<h5 class="brosiclit">Filter Database</h5>
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

								<div class="form-group">
									<!-- <label for="conti">Domains</label> -->
										<div class="all-ctg">
											<div class="form-check">
												<label><input checked class="form-check-input" type="radio" id="domain" name="domain" value="" <?php if(isset($_POST['domain']) && $_POST['domain'] == ''){ echo 'checked'; }?>>All</label>
											</div>
											<br>
											
											<div class="form-check">
											<label><input class="form-check-input" type="radio" id="domain" name="domain" value="marine" <?php if(isset($_POST['domain']) && $_POST['domain'] == 'marine'){ echo 'checked'; }?>>Marine</label>
											</div>
											<br>
											<div class="form-check">
											<label><input class="form-check-input" type="radio" id="domain" name="domain" value="continental" <?php if(isset($_POST['domain']) && $_POST['domain'] == 'continental'){ echo 'checked'; }?>>Continental</label>
											</div>
									</div>
								</div>


								<div class="form-group mb-3 pb-3"  style="border-bottom:1px solid #e5e5e5;">
									<label for="search"> Heat-Flow [mW/m<sup>2</sup>]</label>
									<div class="form-row mb-3">
										<div class="col-6">
											<input type="number" class="form-control_temp" 
											oninput="heatFlowControl('min')" name="min_heat_flow"
											placeholder="Min" id="min_heat_flow" value="<?php if(isset($_POST['min_heat_flow'])){ echo $_POST['min_heat_flow']; }?>" />
										</div>
										<div class="col-6">
											<input type="number" class="form-control_temp" oninput="heatFlowControl('max')" name="max_heat_flow" 
											placeholder="Max" id="max_heat_flow" value="<?php if(isset($_POST['max_heat_flow'])){ echo $_POST['max_heat_flow']; }?>" />
										</div>
									</div>
								
									<div id="slider-range"></div>
									
								
								</div>

								<div class="form-group mb-3 pb-3" style="border-bottom:1px solid #e5e5e5;">
									<label for="search"> Depth [m]</label>
									<div class="form-row mb-3">
										<div class="col-6">
											
											<input type="number" class="form-control_temp" placeholder="Min" oninput="depthControl('min')"name="mind" id="mind" value="<?php if(isset($_POST['mind']) && $_POST['mind'] > 0){ echo $_POST['mind']; }?>" />
										</div>
										<div class="col-6">
											
											<input type="number" class="form-control_temp" placeholder="Max" oninput="depthControl('max')"name="maxd" id="maxd" value="<?php if(isset($_POST['maxd']) && $_POST['maxd'] > 0){ echo $_POST['maxd']; }?>" />
										</div>
									</div>
									<div id="slider-range2"></div>
									
									
								</div>


								<div class="form-group mb-3">
									<label for="search"> Years</label>
									
									<div class="form-row mb-3">
										<div class="col-6">
											
											<input type="number" class="form-control_temp" placeholder="Min" oninput="yearControl('min')"name="min_year" id="min_year" value="<?php if(isset($_POST['min_year']) && $_POST['min_year'] > 0){ echo $_POST['min_year']; }?>" />
										</div>
										<div class="col-6">
											
											<input type="number" class="form-control_temp" placeholder="Max" oninput="yearControl('max')"name="max_year" id="max_year" value="<?php if(isset($_POST['max_year']) && $_POST['max_year'] > 0){ echo $_POST['max_year']; }?>" />
										</div>
									</div>
									<div id="slider-range3"></div>
									
									
								</div>


								<div class="row pt-3">
									<div class="col-sm-6">
										<div class="clear-filterr text-center">
											<button type="submit" name="search" value="search_value" class="btn btn-primary btn-filter btn-apply"> Apply </button>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="clear-filterr text-center">
											<a href="" class="btn btn-danger btn-filter btn-clear" > Clear </a>
										</div>
									</div>
								</div>
							<br/>
							<!-- <hr style="border-top: 1px solid grey;" noshade> </hr> -->
						</div>
					</div>

					<div class="col-lg-10 col-md-9 col-sm-12">
						<div id="map"></div>
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

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				
				<div class="modal-content" style="background: #fff;">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Purpose and Usabilities</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none !important; outline:none !important;">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="p-3">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia, illo ad illum quidem iure fuga voluptatibus, nisi, hic ratione autem expedita. Explicabo ullam hic ratione temporibus suscipit debitis alias!
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde cum explicabo id exercitationem nostrum placeat cumque non nulla libero amet doloribus velit aut, ipsum provident ipsam officiis labore illum dolor.
						<br>
						<br>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia, illo ad illum quidem iure fuga voluptatibus, nisi, hic ratione autem expedita. Explicabo ullam hic ratione temporibus suscipit debitis alias!
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde cum explicabo id exercitationem nostrum placeat cumque non nulla libero amet doloribus velit aut, ipsum provident ipsam officiis labore illum dolor.
						<br>
						<br>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia, illo ad illum quidem iure fuga voluptatibus, nisi, hic ratione autem expedita. Explicabo ullam hic ratione temporibus suscipit debitis alias!
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde cum explicabo id exercitationem nostrum placeat cumque non nulla libero amet doloribus velit aut, ipsum provident ipsam officiis labore illum dolor.
						<br>
						<br>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia, illo ad illum quidem iure fuga voluptatibus, nisi, hic ratione autem expedita. Explicabo ullam hic ratione temporibus suscipit debitis alias!
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde cum explicabo id exercitationem nostrum placeat cumque non nulla libero amet doloribus velit aut, ipsum provident ipsam officiis labore illum dolor.
					</div>
				</div>
			</div>
		</div>
		<div class="dataCount">
			<span style="color:black; text-align: center"> Data Count: <?php echo count($all_map_data); ?></span>
		</div>
		<div id="legendShowBtn" class="legendShow" onclick="showLegend()">
			<span style="color:black; text-align: center;"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp; Show Legend</span>
		</div>										
		<div id="legend" class="legendContainer">
			<span onclick="hideLegend()" class="float-right mr-2"><i class="fa fa-times"></i></span>
			<h5>Legend</h5>
			<label for="legend">Heat-flow [mW/m<sup>2</sup>]</label>
			<table>
				<tbody>
					<tr>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map1.png" alt="" class="mb-2" width="15px" height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;&le; 0 </span></td>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map2.png" alt="" width="15px" class="mb-2 ml-3"  height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;0&ndash;25 </span></td>
					</tr>
					<tr>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map3.png" alt="" width="15px" class="mb-2"  height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;25&ndash;50 </span></td>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map4.png" alt="" width="15px" class="mb-2 ml-3"  height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;50&ndash;75 </span></td>
					</tr>
					<tr>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map5.png" alt="" width="15px" class="mb-2"  height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;75&ndash;100 </span></td>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map6.png" alt="" width="15px" class="mb-2 ml-3"  height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;100&ndash;150 </span></td>
					</tr>
					<tr>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map7.png" alt="" width="15px" class="mb-2" height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;150&ndash;250 </span></td>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map8.png" alt="" width="15px" class="mb-2 ml-3" height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;250&ndash;500 </span></td>
					</tr>
					<tr>
						<td><img src="https://www.ihfc-iugg.org/viewer/map_icon/map9.png" alt="" width="15px" class="mb-2" height=""><span class="mb-2"  style="font-size:12px; font-weight:bold; text-align:right;">&nbsp;&gt; 500 </span></td>
					</tr>
				</tbody>
			</table>
		
			<div style="margin-top:15px">
				<span><img src="https://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l1.png" alt="" width="25px" height="">
				<img src="https://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l2.png" alt="" width="25px" height="">
				<img src="https://www.ihfc-iugg.org/viewer/map_icon/marker_cluster_l3.png" alt="" width="25px" height="">
						&nbsp;Data cluster with X values</span>
			</div>
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
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous"></script>
		<script src="<?=base_url?>js/custom.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js" integrity="sha512-MQlyPV+ol2lp4KodaU/Xmrn+txc1TP15pOBF/2Sfre7MRsA/pB4Vy58bEqe9u7a7DczMLtU5wT8n7OblJepKbg==" crossorigin="anonymous"></script>
		<script src='js/betterScale.js'></script>
		<script src='<?=base_url?>js/MousePosition.js'></script>
		<script src='<?=base_url?>js/L.Control.Zoomslider.js'></script>
		<script src='<?=base_url?>js/Control.FullScreen.js'></script>
		<script src="<?=base_url?>js/bundle.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-contextmenu/1.4.0/leaflet.contextmenu.min.js" integrity="sha512-8sfQf8cr0KjCeN32YPfjvLU2cMvyY1lhCXTMfpTZ16CvwIzeVQtwtKlxeSqFs/TpXjKhp1Dcv77LQmn1VFaOZg==" crossorigin="anonymous"></script>
		
		<script src='<?=base_url?>js/esri-leaflet.js'></script>
		<script src="https://unpkg.com/leaflet.markercluster.freezable@1.0.0/dist/leaflet.markercluster.freezable.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier-Leaflet/0.2.6/oms.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script src="https://leaflet.github.io/Leaflet.Graticule/Leaflet.Graticule.js"></script>

		<!-- JavaScript Includes End-->

		<script>
			var markers = <?php print $map_arr_json_data;?>


			function showLegend(){
				document.getElementById("legend").style.right = "10px";
				document.getElementById("legendShowBtn").style.right = "-180px";
			}
			function hideLegend(){
				document.getElementById("legend").style.right = "-180px";
				document.getElementById("legendShowBtn").style.right = "10px";
			}



			var cities = L.layerGroup();

			// L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities),
			// L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities),
			// L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities),
			// L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);


			var mbAttr = '&copy; <a href="https://ihfc-iugg.org/">www.ihfc-iugg.org</a>',
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
		


			var heatflow;

			var markerClusters = L.markerClusterGroup({
				maxClusterRadius: 80,
				iconCreateFunction: function (cluster) {
					var n = cluster.getChildCount();
					
					if(n <= 10){
						return L.divIcon({ html: n, className: 'mycluster myclusterGray', iconSize: L.point(40, 40) });
					}
					else if(n > 10 && n <= 100){
						return L.divIcon({ html: n, className: 'mycluster myclusterDarkGray', iconSize: L.point(40, 40) });
					}
					else if(n > 100){
						return L.divIcon({ html: n, className: 'mycluster myclusterDarkerGray', iconSize: L.point(40, 40) });
					}
					
				},
				//Disable all of the defaults:
				//spiderfyOnMaxZoom: false, showCoverageOnHover: false, zoomToBoundsOnClick: false
			});

			for ( var i = 0; i < markers.length; ++i )
			{

				heatflow = markers[i].heat_fl;
				//console.log(heatflow);
				if(heatflow == 0){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map1.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 0 && heatflow <= 25 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map2.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 25 && heatflow <= 50 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map3.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 50 && heatflow <= 75 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map4.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 75 && heatflow <= 100 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map5.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 100 && heatflow <= 150 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map6.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 150 && heatflow <= 250 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map7.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else if(heatflow > 250 && heatflow <= 500 ){
					var myIcon = L.icon({
						iconUrl: 'map_icon/map8.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});
				}else{
					var myIcon = L.icon({
						iconUrl: 'map_icon/map9.png',
						iconSize: [18, 30],
						iconAnchor: [10, 30],
						popupAnchor: [0, -14]
						});

				}
				var popup = '<br>Heat-Flow Density</br> <h4 class="pop-header">'+ markers[i].heat_fl + ' <span> mW/m<sup>2</sup> </h4>' +
				// <!-- '<div class="kreis">test</div>'+    -->
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
			

			// map.on("zoomend", showMapCurrentZoom);

			// showMapCurrentZoom();

			// function showMapCurrentZoom() {
			// 	var currZoom = map.getZoom();
			// 	if(currZoom > 5){
			// 		markerClusters.disableClustering();
			// 	}
			// 	else{
			// 		markerClusters.enableClustering();
			// 	}
			// }
			
			
			//markerClusters.addTo(map);

			//markerClusters.freezeAtZoom(55);
			// markerClusters.freezeAtZoom("maxKeepSpiderfy");
			// markerClusters.freezeAtZoom("max");
			// markerClusters.unfreeze(); // shortcut for mcg.freezeAtZoom(false)

			// markerClusters.disableClusteringKeepSpiderfy(); // shortcut for mcg.freezeAtZoom("maxKeepSpiderfy")
			// markerClusters.disableClustering(); // shortcut for mcg.freezeAtZoom("max")
			// markerClusters.enableClustering(); // alias for mcg.unfreeze()

			//add better scale

			L.control.betterscale({metric: true, imperial: false}).addTo(map);
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

			var grat = L.latlngGraticule({
				showLabel: true,
				color: '#000',
				weight:'0.5',
				zoomInterval: [
					{start: 2, end: 3, interval: 30},
					{start: 4, end: 4, interval: 10},
					{start: 5, end: 7, interval: 5},
					{start: 8, end: 10, interval: 1}
				]
			});
			
		
			$('#grid').on('change', function() {

				
				if(this.value == "yes"){
					grat.addTo(map);
				}
				else if(this.value == "no"){
					//location.reload();
					grat.remove();
				}


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

				function heatFlowControl(type){
					if(type == 'min'){
						min_val = $('#min_heat_flow').val();
						//console.log(def_min_val);
					}
					else if(type=='max'){
						max_val = $('#max_heat_flow').val();
					}
					$("#slider-range").slider('values',[min_val, max_val]);
				}
				$( "#slider-range" ).slider({
					range: true,
					min: def_min_val,
					max: def_max_val,
					values: [ min_val, max_val ],
					slide: function( event, ui ) {
						$( "#heatflow1" ).val( ui.values[ 0 ] );
						$( "#heatflow2" ).val( ui.values[ 1 ] );
						$( "#min_heat_flow" ).val(ui.values[ 0 ]);
						$( "#max_heat_flow" ).val(ui.values[ 1 ]);
						/*setTimeout(function(){
							$( "#search_frm" ).submit();
						}, 500);*/
					}
				});
				

			//-- ##### Year ##### -->

			
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
				function yearControl(type){
					if(type == 'min'){
						miny_val = $('#min_year').val();
						//console.log(def_min_val);
					}
					else if(type=='max'){
						maxy_val = $('#max_year').val();
					}
					$("#slider-range3").slider('values',[miny_val, maxy_val]);
				}
				$( "#slider-range3" ).slider({
					range: true,
					min: def_miny_val,
					max: def_maxy_val,
					values: [ miny_val, maxy_val ],
					slide: function( event, ui ) {
						$( "#year1" ).val( ui.values[ 0 ]);
						$( "#year2" ).val( ui.values[ 1 ]);
						 
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
				function depthControl(type){
					if(type == 'min'){
						mind = $('#mind').val();
						//console.log(def_min_val);
					}
					else if(type=='max'){
						maxd = $('#maxd').val();
					}
					$("#slider-range2").slider('values',[mind, maxd]);
				}
				$( "#slider-range2" ).slider({
					range: true,
					min: def_mind_val,
					max: def_maxd_val,
					values: [ mind, maxd ],
					slide: function( event, ui ) {
						$( "#depth1" ).val( ui.values[ 0 ]);
						$( "#depth2" ).val( ui.values[ 1 ]);
						$( "#mind" ).val(ui.values[ 0 ]);
						$( "#maxd" ).val(ui.values[ 1 ]);
						/*setTimeout(function(){
							$( "#search_frm" ).submit();
						}, 500); */
					}
				});

				$( "#depth" ).val( $( "#slider-range2" ).slider( "values", 0 ) + " - " + $( "#slider-range2" ).slider( "values", 1 ) );

			

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

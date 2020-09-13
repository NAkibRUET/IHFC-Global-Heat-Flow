                                                        <?php
include_once('config.php');
include_once('functions.php');

$where = '';
if(isset($_POST) && count($_POST) > 0){
    //echo "<pre>"; print_r($_POST);
    /*[sitename] => 1
    [country] =>
    [continent] =>
    [year] =>
    [reference] => */
    $where .= " WHERE ";

    if($_POST['s'] !=""){
        $where .= "`domain` LIKE '%".$_POST['s']."%' OR `region` LIKE '%".$_POST['s']."%' OR `continent` LIKE '%".$_POST['s']."%' OR `data_number` LIKE '%".$_POST['s']."%' OR `site_name` LIKE '%".$_POST['s']."%' AND ";
    }
    if($_POST['sitename'] !=""){
        $where .= "`site_name` = '".$_POST['sitename']."' AND ";
    }
    if($_POST['country'] !=""){
        $where .= "`region` = '".$_POST['country']."' AND ";
    }
    if($_POST['continent'] !=""){
        $where .= "`continent` = '".$_POST['continent']."' AND ";
    }
    if($_POST['year'] !=""){
        $where .= "`year_of_pub` = '".$_POST['year']."' AND ";
    }
    if($_POST['reference'] !=""){
        $where .= "`reference` = '".$_POST['reference']."' AND ";
    }
    if($_POST['domain'] !=""){
        $where .= "`domain` = '".$_POST['domain']."' AND ";
    }
    if($_POST['mind'] !="" && $_POST['maxd']){
        $where .= "`mind` > ".$_POST['mind']." AND `maxd` < ".$_POST['maxd']." AND ";
    }
    if($_POST['min_heat_flow'] !="" && $_POST['max_heat_flow']){
        $where .= "`heatflow` BETWEEN ".$_POST['min_heat_flow']." AND ".$_POST['max_heat_flow']." AND ";
    }
    $where .= 1;
}
$sql = "SELECT * FROM IHFC2010".$where;
//echo $sql;
$stmt = $conn->prepare($sql);
$stmt->execute();
$all_map_data = $stmt->fetchAll(PDO::FETCH_OBJ);

$map_arr_json_data = "[]";
//print_r($all_map_data);
if(!empty($all_map_data)){
    $map_arr = array();
    foreach($all_map_data as $data){
        $map_arr[] = array(
                        "heat_fl" => $data->heatflow,
                        "dnm" => $data->domain,
                        "lat" => $data->latitude,
                        "lng" => $data->longitude,
                        "name" => $data->site_name,
                        "crt" => $data->region,
                        "ref" => $data->reference
                    );
    }
    $map_arr_json_data = json_encode($map_arr);
    //print($map_arr_json_data); die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=SITENAME?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url?>css/all.min.css">
    <link href="<?=base_url?>css/chosen.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url?>css/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url?>css/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url?>css/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="<?=base_url?>css/style.css">

    <script src="<?=base_url?>js/jquery.min.js"></script>
    <script src="<?=base_url?>js/popper.min.js"></script>
    <script src="<?=base_url?>js/bootstrap.min.js"></script>
    <script src="<?=base_url?>js/chosen.jquery.min.js"></script>
    <script src="<?=base_url?>js/custom.js"></script>
    <script src='<?=base_url?>js/leaflet.js'></script>
    <script src='<?=base_url?>js/leaflet.markercluster.js'></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <style>

    body         {background-color: #fff;}
    div.first    {background: rgba(76, 175, 80, 0.1);width: 120px;height:100px;}
     #gradient {
        background-color: orange;
        width: 300px;
        height: 60px;
        position: absolute;
        top: 150px;
        left: 50px;
        background-image: linear-gradient(to right, rgb(255, 255, 255), rgb(40, 145, 200), rgb(115, 170, 170), rgb(175, 200, 145), rgb(250, 220, 85), rgb(250, 160, 60), rgb(245, 100, 40), rgb(230, 15, 20), rgb(230, 0, 170));
}
     #legend {
        margin-top:20px;
        margin-left:25px;
        border: 1px solid #000;
     }
    </style>
</head>
<body>

     <div class="first"><p>10% opacity</p></div>

     <h1>CSS3 Farbverlauf</h1>
<div id="gradient">1</div>

<div id="legend">
<h4>Legend</h4>
<label for="legend">Heat-flow density [mW/m<sup>2</sup>]</label>
<table style="border-collapse: separate;border-spacing: 5px;">
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map1.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">&le; 0 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map2.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">0&ndash;25 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map3.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">25&ndash;50 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map4.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">50&ndash;75 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map5.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">75&ndash;100 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map6.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">100&ndash;150 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map7.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">150&ndash;250 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map8.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">250&ndash;500 </td></tr>
<tr><td><img src="http://www.ihfc-iugg.org/viewer/map_icon/map9.png" alt="" border="0" width="35px" height=""></td><td style="text-align:right;">&gt;500 </td></tr>
</table>

</div>


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
            layers: [grayscale, cities]
        });

        var baseLayers = {
            "Grayscale": grayscale,
            "Streets": streets
        };

        var overlays = {
            //"Cities": cities
        };



        L.control.layers(baseLayers, overlays).addTo(map);

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
              '<tr> <td><b>Latitude: </b> </td> <td style="padding-left:10px;"> ' + markers[i].lat +'</td></tr>' +
              ' <tr> <td><b>Longitude: </b> </td> <td style="padding-left:10px;">' + markers[i].lng +'</td> </tr>' +
              '<tr> <td> <b>Domain: </b> </td> <td style="padding-left:10px;">' + markers[i].dnm + '</td> </tr>' +
              ' <tr> <td> <b>Region at: </b> </td> <td style="padding-left:10px;">' + markers[i].crt +'</td> </tr>' +
              ' <tr> <td> <b>Reference: </b> </td> <td style="padding-left:10px;">' + markers[i].ref +'</td> </tr> </table>'+
              ' <br/> Did you find an error or want <br/>to comment on this value? <br/><a href="mailto:heatflow@ihfc-iugg.org?subject=IHFC Heat Flow Viewer - New error report or comment" class="error-report">Contact us!</a> ';


          var m = L.marker( [markers[i].lat, markers[i].lng], {icon: myIcon} )
                          .bindPopup( popup );

          markerClusters.addLayer( m );
        }

        map.addLayer( markerClusters );
    </script>



</body>
</html>
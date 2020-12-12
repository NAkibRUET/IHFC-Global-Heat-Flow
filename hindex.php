<?php 
$where = '';
$DB_Year = '';

if(isset($_GET['year'])){
	$DB_Year = $_GET['year'];
}
if($DB_Year == '2010'){
    $table = 'IHFC2010';
}
else if($DB_Year == '2020'){
    $table = 'IHFC2020';
}
else{
    $table = 'IHFC2010';
}
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
		//print_r($_POST['country']); 
		$selected_country = $_POST['country'];
		$selected_country_comma_seprated= "'" . implode ( "', '", $selected_country ) . "'";

		//echo $selected_country_comma_seprated; die;
        $where .= "`region` IN (".$selected_country_comma_seprated.") AND ";
    }
    if($_POST['continent'] !=""){
		
		$selected_continent = $_POST['continent'];
		$selected_continent_comma_seprated= "'" . implode ( "', '", $selected_continent ) . "'";

        $where .= "`continent` IN (".$selected_continent_comma_seprated.") AND ";
    }
    if($_POST['year'] !=""){
        $where .= "`year_of_pub` = '".$_POST['year']."' AND ";
    }
    if($_POST['reference'] !=""){
        //$where .= "`reference` = '".$_POST['reference']."' AND ";
		$selected_reference = $_POST['reference'];
		$selected_reference_comma_seprated= "'" . implode ( "', '", $selected_reference ) . "'";

        $where .= "`reference` IN (".$selected_reference_comma_seprated.") AND ";
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
    if($_POST['min_year'] !="" && $_POST['max_year']){
        $where .= "`year_of_pub` BETWEEN ".$_POST['min_year']." AND ".$_POST['max_year']." AND ";
    }
	
	if($_POST['select_year'] !="" && $_POST['select_year']){
		if($_POST['select_year'] == '2010'){
			$table = 'IHFC2010';
		}elseif($_POST['select_year'] == '2020'){
			$table = 'IHFC2020';
		}
	}
	
    $where .= 1;
}

$sql = "SELECT * FROM ".$table.$where;
//echo $sql; die;
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
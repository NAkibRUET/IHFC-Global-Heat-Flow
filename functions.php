<?php
error_reporting(E_PARSE); //remove notice errors and warnings
function dbQuery($sql){
	global $conn;
	$dbq = $conn->query($sql);
	
	return $dbq;
}

function dbInsert($data, $tableName){
	
	global $conn;
	
	//print_r($data);
	$mykey = "";
	$myvalue = "";
	foreach($data as $key => $value){
		
	  $mykey .= $key.", ";
	  $myvalue .= ":".$key.", ";
	}
	$mykey = rtrim($mykey, ', ');
	$myvalue = rtrim($myvalue, ', ');
	
	
	$statement = $conn->prepare("INSERT INTO ".$tableName."(".$mykey.")
		VALUES(".$myvalue.")");
	$returnData = $statement->execute($data); 
	$id = $conn->lastInsertId();
	return $id;
}

function dbUpdate($arrData, $tableName, $where){
	
	global $conn;
	$i				=	0;
	$str			=	"";
	if($tableName !="" && count($arrData) > 0){
		foreach($arrData as $key => $value){
			if($i == count($arrData)-1){
				$str	.=	"`".$key."` = '".$value."' ";
			}
			else{
				$str	.=	"`".$key."` = '".$value."', ";
			}
			$i++;
		}
		
		try{
			$sqlUpdate		 =	"UPDATE ".$tableName." SET ".$str;
			if(!empty($where)){
				$strWhere	=	"";
				if(is_array($where)){
					foreach($where as $keyWhere => $valueWhere){
						$strWhere	.=	" AND ".$keyWhere."='".$valueWhere."'";
					}							
				}
				else{
					$strWhere	.=	" AND ".$where;
				}
				$sqlUpdate	.=	" WHERE 1=1 ".$strWhere;
			}			
			
			$stmt = $conn->prepare($sqlUpdate);									
			if($stmt->execute()){
				$affectedRows = $stmt->rowCount();		
			}
			else{
				$affectedRows = 0;
			}	
		}
		catch( PDOException $e ){
			echo $e->getMessage();
			return $returnedValue =0;
		}
		return $affectedRows;			
	}
}

function fetchColumn($qry){
	
	global $conn;
	$stmt = $conn->prepare($qry);
	$stmt->execute();
	$table_fields = $stmt->fetchColumn();
	
	return $table_fields;
}

function getAlbumDetails($aid){
	
	global $conn;

	$stmt = $conn->prepare("SELECT * FROM album WHERE AlbumID='".$aid."'"); 
	$stmt->execute(); 
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	return $row;
	
}

function allSiteName($tableName){
	
	global $conn;

	$stmt = $conn->prepare("SELECT DISTINCT `site_name` FROM ".$tableName." WHERE `site_name`!='' OR  `site_name`!=NULL"); 
	$stmt->execute(); 
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	return $row;	
}

function allCountry($tableName){
	
	global $conn;

	$stmt = $conn->prepare("SELECT DISTINCT `region` FROM ".$tableName); 
	$stmt->execute(); 
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	return $row;	
}

function allContinent($tableName){
	
	global $conn;

	$stmt = $conn->prepare("SELECT DISTINCT `continent` FROM ".$tableName); 
	$stmt->execute(); 
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	return $row;	
}

function allYears($tableName){
	
	global $conn;

	$stmt = $conn->prepare("SELECT DISTINCT `year_of_pub` FROM ".$tableName); 
	$stmt->execute(); 
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	return $row;	
}

function allReferences($tableName){
	
	global $conn;

	$stmt = $conn->prepare("SELECT DISTINCT `reference` FROM ".$tableName); 
	$stmt->execute(); 
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	return $row;	
}
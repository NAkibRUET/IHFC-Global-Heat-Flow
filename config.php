<?php
	@session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	//$hostname = 'rdbms.strato.de';
	$hostname = 'localhost';
	$db = 'gfz';
	$user = 'root';
	$pass = '';
	$conn = new PDO("mysql:host=$hostname; dbname=$db; charset=utf8", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	
	global $conn;
	
	define( "SITENAME", "IHFC Viewer Global Heat Flow Database");
	define( "base_url", "https://www.ihfc-iugg.org/viewer/");
	define("ENCRYPTION_KEY", "1234567890qwertyuioplkjhgfdsazxcvbnmASDKSDFEDKQPETROYTMCBX");
	
	date_default_timezone_set("Europe/Berlin");	
?>
<?php
	include("getSchedule.php");
	$db = new PDO("mysql:dbname=uwcc;host=localhost", "root");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$array = getSchedule('2066172877', $db);
	print_r($array);
?>
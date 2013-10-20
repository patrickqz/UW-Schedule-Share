<?php
	include("addSchedule.php");
	include("getSchedule.php");
	include("addDaysToQuery.php");
	$number = '2066172877';
	$friendnumber = '4253813715';
	try {
		$db = new PDO("mysql:dbname=uwcc;host=localhost", "root");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$number = $db -> quote($number);
		$friendnumber = $db -> quote($friendnumber);
		
		$array = getSchedule($number, $db);
		$friendarray = getSchedule($friendnumber, $db);
		$addedArray = addSchedule($array, $friendarray);
		print_r($addedArray);
		$query = "INSERT INTO isfriend VALUES ($number, $friendnumber ";
		$query .= addDaysToQuery($addedArray, $db);
		$query .=");";
		print($query);
		$db -> exec($query);
	} catch(PDOException $ex) {
		if($ex->getCode() == 23000) {
			print("Sorry, you two have already become friends!");
		}
	}
	
	
	
?>
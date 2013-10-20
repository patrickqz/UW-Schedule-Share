<?php
	include("getSchedule.php");
	include("addSchedule.php");
	function acceptFriendship($number, $friendnumber) {
		$array = getschedule($number, $db);
		$friendarray = getschedule($friendnumber, $db);
		$addedArray = addSchedule($array, $friendarray);
		try{
			$db = new PDO("mysql:dbname=uwcc;host=localhost", "root");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$number = quote($number);
			$friendnumber = quote($friendnumber);
			//Still have to put schedule into database
			$query = "INSERT INTO isfriend VALUES ($number, $friendnumber, $lastname, ";
			foreach($addedarray as $value) {
				$value = $db->quote($value);
				$query .= ", $value";
			}
			$query .= ");";
			$db->exec($query);
			
			
			
		} catch(PDOException $ex) {
			
		}
		

	}
?>
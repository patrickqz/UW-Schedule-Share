<?php	
	include("addDaysToQuery.php");
	function addUserToTable($number, $firstname, $lastname, $array) {
		try {
			$db = new PDO("mysql:dbname=uwcc;host=localhost", "root");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$number = $db->quote($number);
			$firstname = $db->quote($firstname);
			$lastname = $db->quote($lastname);
			$query = "INSERT INTO users VALUES ($number, $firstname, $lastname ";
			$query .= addDaysToQuery($array, $db);
			$query .= ", '');";
			print($query);
			$db->exec($query);
		
		} catch(PDOException $ex) {
			//print($ex->getCode());
			if($ex->getCode() == 23000) {
			
				print("Sorry, you have already registered an account!");
			}
		}	
		
			
	}
?>
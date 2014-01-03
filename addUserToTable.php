<?php	
	include("addDaysToQuery.php");
	//Adds a new user to the database
	//prints out the query for inspection
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
			//executes query
			$db->exec($query);
		
		} catch(PDOException $ex) {
			//deals with query exception (if user has registered an account)
			if($ex->getCode() == 23000) {			
				print("Sorry, you have already registered an account!");
			}
		}	
		
			
	}
?>
<?php	
	//given a number as the key, returns the schedule for a specific user
	function getSchedule($number, $db) {
		$userrows = $db->query("SELECT M, T, W, Th, F FROM users WHERE phone_number = $number");
		if($userrows->rowCount() > 0) {
			$firstrow = $userrows->fetch(PDO::FETCH_ASSOC);			
			return $firstrow;
		} 
		return null;
	}
?>
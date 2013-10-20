<?php	
	function getSchedule($number, $db) {
		$userrows = $db->query("SELECT M, T, W, Th, F FROM users WHERE phone_number = $number");
		/**
		$array = array(
					'M' => '',
					'T' => '',
					'W' => '',
					'Th' => '',
					'F' => ''						
				);
		*/
		if($userrows->rowCount() > 0) {
			$firstrow = $userrows->fetch(PDO::FETCH_ASSOC);			
			return $firstrow;
		} 
		return null;
	}
?>
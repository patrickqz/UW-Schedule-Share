<?php
	function addDaysToQuery($array, $db) {
		$query = "";
		foreach($array as $value) {
			$value = $db->quote($value);
			$query .= ", $value";
		}
		return $query;
	}
?>
<?php
libxml_use_internal_errors(true);
	// This function finds the exact time and days of a class with the on the department-specific page
	// is passed in the department, coursenumber, section and timepage url, 
	// returns (something) or updates database in some way. 
	
	function findtimes($department, $coursenumber, $section, $timepage) {
		
		$html = file_get_contents($timepage); 
		//$html = utf8_encode($pre);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$tables = $dom -> getElementsByTagName("table");
		
		// looks through all the tables, uses i to keep track of the table
		for($i = 0; $i < $tables->length; $i++) {
			$children = $tables->item($i) -> childNodes;
			foreach($children as $child1) {
				if($child1 ->hasChildNodes()) {
					foreach($child1 -> childNodes as $child2) {
						if($child2 -> hasChildNodes()) {
							foreach($child2 -> childNodes as $child3) {
								if($child3 -> hasChildNodes()) {
									foreach($child3 -> childNodes as $child4) {
										if(strtolower($child4 -> nodeName) == "a" && $child4 ->hasAttribute("name")) {
											$decoded = preg_replace("/\p{Z}+/u", " ", $child4->textContent);
											preg_match("/[0-9]+/", $decoded, $number);
											//print($number[0]);
											if($number[0] == $coursenumber) {
												// Here we verify that the course number is matched, and now we move on 
												// to find the next table in the tables variable, where the time will be contained.
												findsection($tables, $section, $i + 1);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}			
	}
?>
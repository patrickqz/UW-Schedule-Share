	<?php
/*
	This code reads the visual schedule from a student in MyUW, parses through the 
	source code and stores info about the schedule in an array of 0's and 1's. 
	
	THIS CODE PROBABLY DOESN'T WORK SINCE I CAN'T FIGURE OUT HOW THE VISUAL TIME SCHEDULE DETERMINES THE DAY OF THE WEEK FOR CLASSES.
	FUCKED. 
*/
	//reads the visual schedule as a text file, stores as a string
	$content = file_get_contents('test2.htm');
	libxml_use_internal_errors(true);
	//sets up parsing components
	$dom = new DOMDocument();
	$dom->loadHTML($content);
	// finds all table rows in the table
	$tags = $dom->getElementsByTagName("tr");
	//
	$counter = $tags->length;
	$test = 0;
	// sets up the days array, this will be the one to store all the data. 
	$days = array("", "", "", "", "");
	// array to keep track of the indeces for each day. 
	$indeces = array(0, 0, 0, 0, 0);
	
	// looks through all the table rows
	foreach($tags as $tag) {
		//?
		$day = 0;
		// many table rows exist purely for spacing. checking for children eliminates those rows
		if($tag->hasChildNodes()) {
			// stores children rows
			$children = $tag->childNodes;
			foreach($children as $child) {
				// can get ride of this check..
				if($child->hasAttributes()) {
					// looking for title attribute, which is unique to class elements in the table. 
					if($child->hasAttribute("title")) {
						// stores a "1030-1120" type string
						$time = $child->getAttribute("title");
						$start = processTime($day, $time, true);
						$end = processTime($day, $time, false);
						
						//
						for($k = $indeces[$day]; $k < $start; $k++) {
							$days[$day] .= strval("0");
						}
						for($k = $start; $k < $end; $k++) {
							$days[$day] .= strval("1");
						}
						$indeces[$day] = $end;
						
					}
					$day++;
				}
			}
		}
	}
	
	for($i = 0; $i < sizeof($days); $i++) {
		for($j = $indeces[$i]; $j < 180; $j++) {
			$days[$i] .= strval("0");
		}
	}
	
	foreach($days as $element) {
		print_r($element);
	}
	
	//
	function processTime($day, $time, $ifstart) {

		if($ifstart) {
			return $start;
		} else {
			return $end;
		}
	}
	
	// converts the time stored as "1030" to a integer value starting
	// count at 7:00 AM. 
	function convert($time) {
		if($time > 700) {
			$hrs = (int)(($time - 700) / 100);
			$mins = (int) (($time - 700) % 100);
			return $hrs * 12 + $mins / 5;
		} else {
			$hrs = (int) ($time / 100);
			$mins = (int) ($time % 100);
			return 60 + $hrs * 12 + $mins / 5;
		}	
	}
	
	
	
?>
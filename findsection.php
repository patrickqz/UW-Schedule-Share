<?php
	//this function looks through the specific table given in the previous function, 
	//pulls out the specific time, and parses it to store in the database
	function findsection($tables, $section, $i) {
		// #ffffcc is the color of all the tables that are new classes.
		
		//apparently there are two colors that the time schedule can use to show a new class in the tables, 
		// either #ffffcc or #ffcccc. Must be on the look out for even more. 
		while($tables->item($i) && ($tables->item($i)->getAttribute("bgcolor") != "#ffffcc" &&
			$tables->item($i)->getAttribute("bgcolor") != "#ffcccc")) {
			$children = $tables -> item($i) -> childNodes;
			foreach($children as $child1) {
				if($child1 -> hasChildNodes()) {
					foreach($child1-> childNodes as $child2) {
						if($child2 -> hasChildNodes()) {
							
							foreach($child2 -> childNodes as $child3) {
								$text = trim($child3 -> textContent);	
								$spaces = explode(" ", $text);	
								// This line is very prone to error, will have to fix. 
								// potentially use another regex match to single out the section. 
								$issection = false;
								//finds if section is correct
								foreach($spaces as $token) {
									$token = trim($token);
									if($token == $section) {
										$issection = true;
										break;
									}
								}
								if($issection) {
									$pattern = "/[MTW(Th)F]+\s+[0-9]+-[0-9]+P?/";
									preg_match_all($pattern, $text, $out);
									splittime($out[0]);
									return;
								}							
							}
						}
					}
				}
			}
		$i++;
		}
	}
	
	//this function splits the time found into a beginning and an end time, 
	//then handles each of them separately. It also keeps track of what day of the week
	//each time is for.
	function splittime($timesdays) {
		foreach($timesdays as $timeday) {
			//pattern looks like this because (Th) has to have priority over T, so that Th's will match.
			$daypattern = "/M|(Th)|W|T|F/";
			
			preg_match_all($daypattern, $timeday, $days);
			$timepattern = "/[0-9]+-[0-9]+P?/";
			preg_match($timepattern, $timeday, $time);
			foreach($days[0] as $day) {
				process($day, $time[0]);
			}
			
		}
	}
	
	//stores times in the day specified
	function process($day, $time) {
		$startend = explode("-", $time);
		$start = convert($startend[0]);
		$end = convert($startend[1]);
		$replacement = "";
		for($i = 0; $i < $end - $start; $i++) {
			$replacement .= "1";
		}
		$GLOBALS['array'][$day] = substr_replace($GLOBALS['array'][$day], $replacement, $start, $end - $start);
	}
	
	//converts time in the normal representation(1030 as 10:30 AM) to representation of
	//integer of 5 minute intervals starting from 7:00 AM. 
	// need to fix function, must include something to distinguish 
	// between PM and AM at times like 830 or 730, which could be both. 
	function convert($time) {
		$numberpattern = "/[0-9]+/";
		preg_match($numberpattern, $time, $number);
		if(substr($time, strlen($time) - 1, 1) == 'P' || $number[0] < 700) {
			$hrs = (int) ($time / 100);
			$mins = (int) ($time % 100);
			return 60 + $hrs * 12 + $mins / 5;
		} else {
			$hrs = (int)(($time - 700) / 100);
			$mins = (int) (($time - 700) % 100);
			return $hrs * 12 + $mins / 5;
		}	
	}
?>
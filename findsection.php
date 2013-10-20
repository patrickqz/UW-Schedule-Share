<?php
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
								
								// This is for testing:
								/*
								?>
								<p>
								<?=$text?>
								</p>
								<?php
								*/
								$spaces = explode(" ", $text);	
								// This line is very prone to error, will have to fix. 
								// potentially use another regex match to single out the section. 
								
								if($spaces[3] == $section || $spaces[2] == $section || $spaces[1] == $section) {
									$pattern = "/[MTW(Th)F]+\s+[0-9]+-[0-9]+P?/";
									preg_match_all($pattern, $text, $out);
									splittime($out[0]);
								}
								
								
							}
						}
					}
				}
			}
		$i++;
		}
	}
	
	function splittime($timesdays) {
		//print_r($timesdays);
		foreach($timesdays as $timeday) {
			//print($timeday);
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
	
		// need to fix function, must include something to distinguish 
		// between PM and AM at times like 830 or 730, which could be both. 
	function convert($time) {
		$numberpattern = "/[0-9]+/";
		preg_match($numberpattern, $time, $number);
		//print($number[0] . " ");
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
<?php
libxml_use_internal_errors(true);
	
	// This function reads the section of the time schedule with all the departments listed, 
	// finds the department we are looking for, and links to that department-specific page. 
	function finddepartment($department, $coursenumber, $section, $departmentpage) {
		$html = file_get_contents($departmentpage);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		
		// grabs all the list tags
		$tags = $dom->getElementsByTagName("li");
		foreach($tags as $tag) {
			
			if($tag->hasChildNodes()) {
				// examines the child nodes of each list tag. 
				$children = $tag->childNodes;
				
				foreach($children as $child) {
					
					if($child->nodeName == "a") {
						$link = $child->getAttribute("href");
						if(substr($link, 0, 1) != "#") {
							$new_str = $child->textContent;
							//TESTING, to determine how many departments actually exist.
							$pattern = "/\([A-Z|\s|\X]*\)/u";
							preg_match($pattern, $new_str, $out);
							
							//CHERISH THIS
							$new = preg_replace("/\p{Z}/u", " ", $out);
							
							if($new) {
								
								
								
								$matcher = "(" . $department . ")";
								if($matcher == $new[0]) {
									//print("FOUND");
									$timepage = $departmentpage . "/" . $link;
									findtimes($department, $coursenumber, $section, $timepage);
									// Have to add return to end function, 
									// otherwise there may be duplicates, and findtimes may be called
									// more than once. 
									return;
								}
															
							}
							
						}
					}
				}
			}
		}
	}
?>
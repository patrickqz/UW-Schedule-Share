<?php
/*
	This page will take the department abbreviation entered by the student, and find the redirection
	needed to continue parsing through the registration pages
*/
	// grabs the department, coursenumber, and section from submitclasses.html.
	//currently in testing, will fill out exception cases later
	$number = $_GET["number"];
	$count = $_GET["count"];
	$firstname = $_GET["firstname"];
	$lastname = $_GET["lastname"];
	//quarter consists of AUT, WIN, SPR, or SUM, and then year
	$QUARTER = "WIN2014";
	
	$departmentpage = "http://www.washington.edu/students/timeschd/".$QUARTER;
	libxml_use_internal_errors(true);
	include("finddepartments.php");
	include("findtimes.php");
	include("findsection.php");
	include("addUserToTable.php");
	
	// makes 180 zeros for each element in the array. 
	// 180 zeros represents the amount of 5 minute increments 
	// in a day of the schedule that is currently open. 
	
	$array = array(
		'M' => '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
		'T' => '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
		'W' => '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
		'Th' =>'000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
		'F' => '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
	);
	//for each class the user has inputted, goes through registration and find times for such class
	//stores times in given array
	for($i = 1; $i <= $count; $i++) {
		$department = $_GET["department" . $i];
		$coursenumber = $_GET["coursenumber" . $i];
		$section = $_GET["section". $i];
		?>
		<p>
		<?php
		//shows information of the class inputted
		print($department . " " . $coursenumber . " " . $section);
		?>
		</p>
		<?php
		finddepartment($department, $coursenumber, $section, $departmentpage);
	}
	//shows array for testing
	print_r($array);
	
	//calls function to add the updated array into the database
	addUserToTable($number, $firstname, $lastname, $array);
	

	
?>
	

	
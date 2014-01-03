UW-Schedule-Share
=================
This is currently a web application in development that matches students' class schedules to their best friends', 
to figure out when during the day they can hangout. I am hoping to implement this as a smartphone application in the 
future. Most of the code here is in PHP.

NOTE: this is very messy code, partly because PHP was not an ideal language for this project to start off with, but also
because I was very focused on correctness rather than and neatness since it was a side project for fun. The code is most
horrendous when parsing through HTML, and I have now learned that there is actually a library in PHP to make life much 
easier, so I will replace all the nasty code with neat library code when I get a chance.

The project is currently organized in 3 sections:
The signup section which includes: addUserToTable.php, finddepartments.php, findsection.php, findtimes,php, and saveclass.php,
The accept friendship section which includes: acceptFriendship.php, addDaysToQuery.php, addSchedule.php, getSchedule.php
The interface(very simple, for testing purposes) section which includes: submitclasses.html, submitclasses.js

To test, open up submitclasses.html on a machine that has both Apache and MySQL
some sample classes to test are: 
(written in: DEPARTMENT COURSENUMBER SECTION)
(all letters much be caps)
CSE 312 A
CSE 312	AA
PHIL 240 A
PHIL 240 AB
CSE 344 A
CSE 344 AB
CSE 390 A


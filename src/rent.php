<?php
ini_set('display_errors', 'On');
include 'savedinfo.php';

//database variables
$host = "oniddb.cws.oregonstate.edu";
$db = "duttonk-db";
$user = "duttonk-db";
$table = 'videos';

//create object
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
} 
?>

<!DOCTYPE html>
<html>
  <head><title>Check Video In/Out</title></head>
  <body>
  	<?php

  	//determine if movie is being checked in or out based on value passed by button in POST
 	if (isset($_REQUEST['checkin'])) {
  		$rentId = $_REQUEST['checkin'];

  		//prepare update statement according to check in procedure
		if (!($stmt = $mysqli->prepare("UPDATE $table SET rented=1 WHERE id = ?"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		} else {
			//bind parameters and execute
			$stmt->bind_param("i", $rentId);
			$stmt->execute();

			//send people home
			echo "Video returned!";
			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
		}

  	 //video is being checked out 	
  	} else if (isset($_REQUEST['checkout'])) {
  		$rentId = $_REQUEST['checkout'];

  		//prepre updte statement according to check out procedure
		if (!($stmt = $mysqli->prepare("UPDATE $table SET rented=0 WHERE id = ?"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		} else {
			//bind parameters and execute
			$stmt->bind_param("i", $rentId);
			$stmt->execute();

			//send people home
			echo "Video checked out!";
			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
		}
  	} else {
  		echo "ERROR: No video selected. </br>";
  		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
  	}

  	$mysqli->close();

	?>
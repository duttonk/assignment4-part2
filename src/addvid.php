<?php
ini_set('display_errors', 'On');
include 'savedinfo.php';

//Set connection variables
$host = "oniddb.cws.oregonstate.edu";
$db = "duttonk-db";
$user = "duttonk-db";
$table = 'videos';

//Create new object, with error checking
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
} 
?>

<!DOCTYPE html>
<html>
  <head><title>Add Video</title></head>
  <body>
  	<?php

  	//Error checking - look for non-numeric entry, negative numbers - force to return to main
	if((!is_numeric($_REQUEST['length']) || $_REQUEST['length'] < 0 ) && !empty($_REQUEST['length'])) {
		echo "ERROR - Length must be a positive number. ";
		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';

	} else {

		//get info from POST to populate binding parameters
		$name = $_REQUEST['name'];
		$category = $_REQUEST['category'];

		//If length wasn't filled in, use null in the table
		if (empty($_REQUEST['length'])) {
			$length = NULL;
		} else {
			$length = $_REQUEST['length'];
		}

		//Prepare insert statement with variables, include error handling
		if (!($stmt = $mysqli->prepare("INSERT INTO $table (name, category, length) VALUES (?, ?, ?)"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		} else {

			//bind input parameters to insert statement and execute - new row added to table
			$stmt->bind_param("ssi", $name, $category, $length);
			$stmt->execute();

			//Get back to the main page
			echo "Video successfully added!";
			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
		}
	}

	$mysqli->close();
	?>

<?php
ini_set('display_errors', 'On');
include 'savedinfo.php';

$host = "oniddb.cws.oregonstate.edu";
$db = "duttonk-db";
$user = "duttonk-db";
$table = 'videos';

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

	if((!is_numeric($_REQUEST['length']) || $_REQUEST['length'] < 0 ) && !empty($_REQUEST['length'])) {
		echo "ERROR - Length must be a positive number. ";
		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
	} else {

		$name = $_REQUEST['name'];
		$category = $_REQUEST['category'];

		if (empty($_REQUEST['length'])) {
			$length = NULL;
		} else {
			$length = $_REQUEST['length'];
		}

		if (!($stmt = $mysqli->prepare("INSERT INTO $table (name, category, length) VALUES (?, ?, ?)"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		} else {
			$stmt->bind_param("ssi", $name, $category, $length);
			$stmt->execute();
			echo "Video successfully added!";
			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
		}
	}

	$mysqli->close();
	?>

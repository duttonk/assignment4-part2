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
  <head><title>Check Video In/Out</title></head>
  <body>
    <?php

    if (isset($_REQUEST['deleteRow'])) {

      $deleteId = $_REQUEST['deleteRow'];

    if (!($stmt = $mysqli->prepare("DELETE FROM $table WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
      $stmt->bind_param("i", $deleteId);
      $stmt->execute();
      echo "Video successfully deleted!";
      echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
    }
      
    } else {
      echo "ERROR: No video selected. </br>";
      echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
    }
    $mysqli->close();
  ?>
  </body>
</html> 

$host = "oniddb.cws.oregonstate.edu";
$db = "duttonk-db";
$user = "duttonk-db"
$table = 'videos';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno .")" . $mysqli->connect_error;
}  else {
  echo "Connection worked! <br />";
}
?>
?>

<!DOCTYPE html>
<html>
  <head><title>Check Video In/Out</title></head>
  <body>
  	<?php

  	if (isset($_REQUEST['deleteRow'])) {

  		$deleteId = $_REQUEST['deleteRow'];

		if (!($stmt = $mysqli->prepare("DELETE FROM $table WHERE id = ?"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		} else {
			$stmt->bind_param("i", $deleteId);
			$stmt->execute();
			echo "Video successfully deleted!";
			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
		}
  		
  	} else {
  		echo "ERROR: No video selected. </br>";
  		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
  	}
  	$mysqli->close();
	?>
  </body>
</html> 
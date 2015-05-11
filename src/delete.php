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
  <head><title>Delete All Videos</title></head>
  <body>
  	<?php
  		if (!$mysqli->query("TRUNCATE TABLE $table")) {
  			echo "Failed to delete table.";
  		} else {
  			echo "Table $table successfully dropped.</ br>";
  			echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
  		}
  		$mysqli->close();
  	?>
  </body>
 </html>
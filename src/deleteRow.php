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
  <head><title>Delete Video</title></head>
  <body>
    <?php

    //get the id number of the row that will be deleted - passed in through POST as value of the button
    if (isset($_REQUEST['deleteRow'])) {
      $deleteId = $_REQUEST['deleteRow'];

      //prepare statement - delete the row corresponding to the passed id value, with error reporting
      if (!($stmt = $mysqli->prepare("DELETE FROM $table WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      } else {
        //bind parameter to delete statement and execute
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();

        //return to main page
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
<?php
ini_set('display_errors', 'On');

//If category "All Movies" was selected, send user back without header info
if ($_POST['category'] == "All" ) {
	header('Location: videos.php');
} else {
	//send user back with header info to execute select statement in videos.php
	header('Location: videos.php?action=filter&key=' . $_POST['category']);
}

?>

<!DOCTYPE html>
<html>
  <head><title>Add Video</title></head>
  <body>
  	<?php

  	//This shouldn't ever show - just for error handling consistency
	if(!isset($_POST['category'])) {
		echo "ERROR - No category selected.";
		echo var_dump($_POST);
		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
	} 

	?>
  </body>
</html>
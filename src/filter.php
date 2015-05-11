<?php
ini_set('display_errors', 'On');

if ($_POST['category'] == "All" ) {
	header('Location: videos.php');
} else {
	header('Location: videos.php?action=filter&key=' . $_POST['category']);
}

?>

<!DOCTYPE html>
<html>
  <head><title>Add Video</title></head>
  <body>
  	<?php

	if(!isset($_POST['category'])) {
		echo "ERROR - No category selected.";
		echo var_dump($_POST);
		echo '<form action="videos.php"><button name="Return" type="submit" autofocus>Return to main page</button></form>';
	} 

	?>
  </body>
</html>
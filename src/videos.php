<?php
ini_set('display_errors', 'On');
include 'savedinfo.php';

/* Note on sources across all files: I performed numerous google searches and consulted (probably) hundreds
   of pages on php.net, stackoverflow, W3Schools, MySQL documentation, and other tutorials. I also referenced
   the course videos and the Thursday night tutorial videos and source code. Honestly there were too many
   sources to cite them all, especially since I often found near-fixes that required additional thought 
   to implement (not straight fixes, but strong hints). I'm sorry I didn't keep better track of all of them
   while I was coding, but this is my attempt to say I absolutely consulted sources to get this code into 
   good working order. 
*/

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
  <head><title>Dutton Video Store</title></head>
  <link rel="stylesheet" type="text/css" href="video.css">
  <body>
  	<h1>Dutton Video Store Database</h1>
  	
  	  	<form id="deleteAll" method="POST" action="delete.php">
  			<input id="deleteButton" type="submit" name="deleteButton" value="Delete All Videos">
  		</form>

  	<?php

  	if (!$cat = $mysqli->prepare("SELECT DISTINCT category from $table")) {
  		echo "Prepare failed: (". $mysqli->errno . ")" . $mysqli->error;
  	}
  	if(!$cat->execute()) {
  		echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
  	}
  	$listCat = NULL;

  	if (!$cat->bind_result($listCat)) {
			echo "Binding output parameters failed: (" . $all->errno. ")" . $all->error;
	}
	echo '<form id="select" method="POST" action="filter.php"><select name="category">';
	while ($cat->fetch()) {
		echo '<option value=' . $listCat . '>' . $listCat . '</option>';
	}
	echo '<option value="All">All Movies</option>';
	echo '</select>';
	echo '<input id="selectButton" type="submit" name="selectButton" value="Filter"></form>';

  	$cat->close();

  	?>

  	<div id="addVideo">
  		<h3>Add a video to the database</h3>
  		<form id="addForm" method="POST" action="addvid.php">
  			<span>Name: </span><input type="text" name="name" required placeholder="Enter video name" autofocus>
			<span>Category: </span><input type="text" name="category">
			<span>Length: </span><input type="text" name="length">
			<input id="addButton" type="submit" name="addButton" value="Add Video">
      	</form>
    </div>

    <?php
    	if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'filter')) {
    		$filterCat = $_REQUEST['key'];
    		
    		
    		if(!$filtered = $mysqli->prepare("SELECT id, name, category, length, rented FROM $table WHERE category = ?")) {
				echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
			} else {
				$filtered->bind_param("s", $filterCat);
				
				if (!$filtered->execute()) {
	      			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
    	  		}	
	      		$vidId = NULL;
    	  		$vidName = NULL;
	      		$vidCat = NULL;
    	  		$vidLength = NULL;
      			$vidRent = NULL;

				if (!$filtered->bind_result($vidId, $vidName, $vidCat, $vidLength, $vidRent)) {
					echo "Binding output parameters failed: (" . $filtered->errno. ")" . $filtered->error;
				}
				echo '<table id="movies"><tr><th>Movie Name</th>';
				echo '<th>Category</th>';
				echo '<th>Length</th>';
				echo '<th>Availability</th>';
				echo '<th>Check In/Out</th>';
				echo '<th>Delete Video</th>';
				echo '</tr>';
				while ($filtered->fetch()) {
					echo '<tr><td>' . $vidName .'</td><td>' . $vidCat . '</td><td>' . $vidLength . '</td>';
					echo '<td>';
					if ($vidRent == 0) {
						echo 'Checked Out';
					} else {
						echo 'Available';
					}
					echo '</td>';
					echo '<td>';
					if ($vidRent == 0) {
						echo '<form action="rent.php" method="POST"><button name="checkin" 
					   	type="submit" value=' . $vidId . '>CHECK IN/OUT</button></form></td>';
					} else if ($vidRent == 1) {
						echo '<form action="rent.php" method="POST"><button name="checkout"
							type="submit" value=' . $vidId . '>CHECK IN/OUT</button></form></td>';
					}
					echo '<td><form action="deleteRow.php" method="POST"><button name="deleteRow" 
					   	type="submit" value=' . $vidId . '>DELETE</button></form></td>';
					echo '</tr>';
				}
			}

    	} else {
      		if (!$all = $mysqli->prepare("SELECT id, name, category, length, rented FROM $table")) {
      			//$all->bind_param("ssii", $vidName, $vidCat, $vidLength, $vidRent);
      			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
      		}
      	
      		if (!$all->execute()) {
	      		echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
    	  	}

	      	$vidId = NULL;
    	  	$vidName = NULL;
	      	$vidCat = NULL;
    	  	$vidLength = NULL;
      		$vidRent = NULL;

			if (!$all->bind_result($vidId, $vidName, $vidCat, $vidLength, $vidRent)) {
				echo "Binding output parameters failed: (" . $all->errno. ")" . $all->error;
			}
			echo '<table id="movies"><tr><th>Movie Name</th>';
			echo '<th>Category</th>';
			echo '<th>Length</th>';
			echo '<th>Availability</th>';
			echo '<th>Check In/Out</th>';
			echo '<th>Delete Video</th>';
			echo '</tr>';
			while ($all->fetch()) {
				echo '<tr><td>' . $vidName .'</td><td>' . $vidCat . '</td><td>' . $vidLength . '</td>';
				echo '<td>';
				if ($vidRent == 0) {
					echo 'Checked Out';
				} else {
					echo 'Available';
				}
				echo '</td>';
				echo '<td>';
				if ($vidRent == 0) {
					echo '<form action="rent.php" method="POST"><button name="checkin" 
				   	type="submit" value=' . $vidId . '>CHECK IN/OUT</button></form></td>';
				} else if ($vidRent == 1) {
					echo '<form action="rent.php" method="POST"><button name="checkout"
						type="submit" value=' . $vidId . '>CHECK IN/OUT</button></form></td>';
				}
				echo '<td><form action="deleteRow.php" method="POST"><button name="deleteRow" 
				   	type="submit" value=' . $vidId . '>DELETE</button></form></td>';
				echo '</tr>';

			}$all->close();
		}
		
	
	?>

  </body>
</html>
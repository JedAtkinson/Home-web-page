<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $loggedin = false;
} else {
	$loggedin = true;

		// Include config file
		require_once "config.php";

		$sql = 'SELECT theme FROM users WHERE id='.$_SESSION["id"].'';
		$result = $link->query($sql);
		while($row = $result->fetch_assoc()) {
			$theme = $row["theme"];
		}

	if (!empty($_POST)) {

		if ($theme == "dark"){
			$sql = 'UPDATE users SET theme="light" WHERE id='.$_SESSION["id"].'';
			$theme = 'light';
		}
		else {
			$sql = 'UPDATE users SET theme="dark" WHERE id='.$_SESSION["id"].'';
			$theme = 'dark';
		}
		
		if ($link->query($sql) === TRUE) {
		} else {
			  echo "Error updating record: " . $link->error;
		}
	}

	$link->close();
}

header("Location: http://localhost/home/index.php");
exit();
?>
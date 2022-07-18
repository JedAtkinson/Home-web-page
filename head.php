<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $loggedin = false;
	$bg_colour = "#333333";
	$text_colour = "#e6e6e6";
	$secondary_colour = "#242424";
	$image_colour = "invert(0%)";
} else {
	$loggedin = true;
		// Include config file
		require_once "config.php";

		$sql = 'SELECT theme FROM users WHERE id='.$_SESSION["id"].'';
		$result = $link->query($sql);
		while($row = $result->fetch_assoc()) {
			$theme = $row["theme"];
		}

	if($theme == 'light'){
		$bg_colour = "#e6e6e6";
		$text_colour = "#333333";
		$secondary_colour = "#d1d1d1";
		$image_colour = "invert(90%)";
	} elseif($theme == "dark"){
		$bg_colour = "#333333";
		$text_colour = "#e6e6e6";
		$secondary_colour = "#242424";
		$image_colour = "invert(0%)";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Home</title>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="images/favicon.png">
</head>
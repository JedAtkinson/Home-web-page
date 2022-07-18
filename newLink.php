<!--<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
<title>New Link</title>
</head>

<body>
	<h1><a href="index.php"><img src="images\pineapple.png" alt="logo"></a> New Link</h1>

<form action="newLink.php" method="post">
	<label>URL</label><br>
	<input type="text" name="url" class="form-control" autocomplete="off"><br>

    <label>Title</label><br>
    <input type="text" name="title" class="form-control" autocomplete="off"><br>

    <label>Image</label><br>
    <input type="text" name="img" class="form-control" autocomplete="off"><br>

    <input type="submit" value="Submit" class="btn btn-primary">
</form>-->

<?php
// Initialize the session
session_start();
require_once "config.php";

$userID = $_SESSION["id"];
$url = $_POST['url'];
$title = $_POST['title'];

$urlarray = explode("/", $url);
if($urlarray[0] != "https:") {
	$url = "https://".$url;
}

$img = "https://www.google.com/s2/favicons?domain_url=".$url;

$sql = "insert into links(userID, link, title, img) values('$userID', '$url', '$title', '$img')";

if(empty($url)) {
    echo "Please enter a url";
    return;
}
if(empty($title)) {
    echo "Please enter a title";
    return;
}

if ($link->query($sql) === TRUE) {
	echo "ADDED: ".$url.", ".$title.", ".$img."<br><br>";
} else {
	echo "Error ".$spl."<br>".$link->error;
}

$link->close();

header("Location: http://localhost/home/index.php");
exit();
?>

</body>

</html>
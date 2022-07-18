<?php
// Initialize the session
session_start();
require_once "config.php";

$id = $_POST['id'];

// sql to delete a record
$sql = "DELETE FROM links WHERE id=" . $id ."";

if ($link->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $link->error;
}

$link->close();

header("Location: http://localhost/home/index.php");
exit();
?>
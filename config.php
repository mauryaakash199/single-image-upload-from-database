<?php
$host = "localhost";
$username = "root"; // Change if different
$password = "";
$database = "file_upload_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

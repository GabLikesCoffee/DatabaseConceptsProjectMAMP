<?php
$servername = "localhost";
$username = "GabbsLemons";
$password = "cookie";
$db_name = "DB_Project";

//Last param is supposed to be db name but its gabbslemons too
// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "!";
?>
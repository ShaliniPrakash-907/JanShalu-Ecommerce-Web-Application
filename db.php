<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Uncomment this line if you want to test connection
// echo "Database Connected Successfully";

?>
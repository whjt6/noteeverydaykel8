<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u857619896_testdiary";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Jakarta');
?>
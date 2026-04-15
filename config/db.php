<?php
$conn = new mysqli("localhost", "root", "", "project_bank");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
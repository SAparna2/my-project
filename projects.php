<?php
include 'config/db.php';

$result = $conn->query("SELECT * FROM projects WHERE status='approved'");

while($row = $result->fetch_assoc()){
    echo "<h3>".$row['title']."</h3>";
    echo "<p>".$row['description']."</p>";
    echo "<a href='uploads/".$row['file_path']."' download>Download</a><hr>";
}
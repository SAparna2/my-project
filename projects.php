<?php
include 'config/db.php';

$result = $conn->query("SELECT * FROM projects WHERE status='approved'");

while($row = $result->fetch_assoc()){
    echo "<h3>".$row['title']."</h3>";
    echo "<p>".$row['description']."</p>";
    echo "<a href='uploads/".$row['file_path']."' download>Download</a><hr>";
    $pid = $row['id'];

$sol = $conn->query("SELECT * FROM solutions WHERE project_id=$pid");

while($s = $sol->fetch_assoc()){
    echo "<p><b>Solution:</b> ".$s['solution']."</p>";
}
}
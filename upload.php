<?php
include 'includes/auth.php';
include 'config/db.php';

if(isset($_POST['upload'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $file = $_FILES['file']['name'];

    move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$file);

    $user_id = $_SESSION['user']['id'];

    $conn->query("INSERT INTO projects(title,description,file_path,uploaded_by)
    VALUES('$title','$desc','$file','$user_id')");

    echo "Uploaded!";
}
?>

<form method="POST" enctype="multipart/form-data">
    <h3>Upload Project</h3>
    <input type="text" name="title" required>
    <textarea name="description"></textarea>
    <input type="file" name="file" required>
    <button name="upload">Upload</button>
</form>

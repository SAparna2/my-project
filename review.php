<?php
include 'includes/auth.php';
include 'config/db.php';

if($_SESSION['user']['role'] != 'faculty'){
    die("Access Denied");
}

if(isset($_POST['review'])){
    $id = $_POST['project_id'];

    $conn->query("UPDATE projects SET status='approved' WHERE id=$id");
}

$result = $conn->query("SELECT * FROM projects WHERE status='pending'");

while($row = $result->fetch_assoc()){
?>
<form method="POST">
    <h3><?php echo $row['title']; ?></h3>
    <input type="hidden" name="project_id" value="<?php echo $row['id']; ?>">
    <button name="review">Approve</button>
</form>
<hr>
<?php } ?>
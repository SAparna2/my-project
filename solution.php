<?php
include 'includes/auth.php';
include 'config/db.php';

if(isset($_POST['submit'])){
    $project_id = $_POST['project_id'];
    $solution = $_POST['solution'];
    $student_id = $_SESSION['user']['id'];

    $conn->query("INSERT INTO solutions(project_id,student_id,solution)
    VALUES('$project_id','$student_id','$solution')");

    echo "Solution Submitted!";
}

$result = $conn->query("SELECT * FROM projects");
?>

<h3>Submit Solution</h3>

<form method="POST">
    <select name="project_id">
        <?php while($row = $result->fetch_assoc()){ ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['title']; ?>
            </option>
        <?php } ?>
    </select>

    <textarea name="solution" placeholder="Enter your solution"></textarea>

    <button name="submit">Submit</button>
</form>
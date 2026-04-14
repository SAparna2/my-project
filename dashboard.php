<?php include 'includes/auth.php'; ?>

<h3>Welcome <?php echo $_SESSION['user']['name']; ?></h3>

<a href="upload.php">Upload Project</a><br>
<a href="projects.php">View Projects</a><br>
<a href="review.php">Review (Faculty)</a><br>
<a href="logout.php">Logout</a>

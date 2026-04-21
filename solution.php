<?php
include 'includes/auth.php'; // Ensure session_start() is inside here
include 'config/db.php';
include 'includes/header.php';

$message = "";

if (isset($_POST['submit'])) {
    $project_id = $_POST['project_id'];
    $solution_text = $_POST['solution'];
    $student_id = $_SESSION['user']['id'];

    // --- File Upload Logic ---
    $file_name = $_FILES['sol_file']['name'];
    $file_tmp = $_FILES['sol_file']['tmp_name'];
    $upload_dir = "uploads/";

    // Create unique filename to prevent overwriting
    $unique_name = time() . "_" . basename($file_name);
    $target_path = $upload_dir . $unique_name;

    if (move_uploaded_file($file_tmp, $target_path)) {
        // Secure Insert using Prepared Statement
        $stmt = $conn->prepare("INSERT INTO solutions (project_id, student_id, solution, file_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $project_id, $student_id, $solution_text, $unique_name);

        if ($stmt->execute()) {
            $message = "<p class='msg-success'>✅ Solution & file submitted successfully!</p>";
        } else {
            $message = "<p class='msg-error'>❌ Database error: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p class='msg-error'>❌ Failed to upload file. Check folder permissions.</p>";
    }
}

// Fetch only approved projects for submission
$projects = $conn->query("SELECT id, title FROM projects WHERE status='approved'");
?>

<div class="solution-container">
    <h2>Submit Solution</h2>

    <?php echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Select Project</label>
        <select name="project_id" required>
            <option value="" disabled selected>-- Choose the project --</option>
            <?php while($row = $projects->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Description / Notes</label>
        <textarea name="solution" placeholder="Briefly explain your solution..." required></textarea>

        <label>Upload Document (PDF, ZIP, DOCX)</label>
        <input type="file" name="sol_file" class="file-input" required>

        <button name="submit" type="submit">Submit Solution</button>
    </form>

    <div class="form-footer">
        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</div>
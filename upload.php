<?php
// 1. Include security and database
include 'includes/auth.php'; // Ensure this contains session_start()
include 'config/db.php';
include 'includes/header.php'; // This triggers your CSS and global styles

$message = "";

// 2. Handle the Form Submission
if (isset($_POST['upload'])) {
    $title = $_POST['project_name'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user']['id'];

    // Check if a file was actually uploaded without errors
    if (isset($_FILES['project_file']) && $_FILES['project_file']['error'] == 0) {
        
        $file_name = $_FILES['project_file']['name'];
        $file_tmp = $_FILES['project_file']['tmp_name'];
        $upload_dir = "uploads/";

        // Create a unique filename to avoid overwriting existing files
        $unique_name = time() . "_" . basename($file_name);
        $target_path = $upload_dir . $unique_name;

        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // 3. Move the file and save to Database
        if (move_uploaded_file($file_tmp, $target_path)) {
            // Use a Prepared Statement for security
            $stmt = $conn->prepare("INSERT INTO projects (title, description, file_path, uploaded_by, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->bind_param("sssi", $title, $description, $unique_name, $user_id);

            if ($stmt->execute()) {
                $message = "<div class='alert success'>✅ Project uploaded successfully and is pending review!</div>";
            } else {
                $message = "<div class='alert error'>❌ Database Error: " . $conn->error . "</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='alert error'>❌ Failed to move uploaded file. Check folder permissions.</div>";
        }
    } else {
        $message = "<div class='alert error'>❌ Please select a valid file to upload.</div>";
    }
}
?>

<div class="upload-container">
    <h2>Upload New Project</h2>
    
    <?php echo $message; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
            <label for="project_name">Project Title</label>
            <input type="text" id="project_name" name="project_name" placeholder="e.g., Banking System V1" required>
        </div>

        <div class="input-group">
            <label for="description">Project Description</label>
            <textarea id="description" name="description" placeholder="Describe the project goals and features..." required></textarea>
        </div>

        <div class="input-group">
            <label for="project_file">Attach Project File (PDF or ZIP)</label>
            <input type="file" id="project_file" name="project_file" class="file-input" required>
        </div>

        <button type="submit" name="upload">Upload Project</button>
    </form>

    <div class="form-footer">
        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</div>

<?php // include 'includes/footer.php'; ?>
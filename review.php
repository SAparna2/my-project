<?php
include 'includes/auth.php'; // Ensure session_start() is in here
include 'config/db.php';
include 'includes/header.php'; // This triggers the review.css

// 1. Role Security Check
if ($_SESSION['user']['role'] != 'faculty') {
    die("<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>
            <h2>Access Denied</h2>
            <p>Only Faculty members can access this page.</p>
            <a href='dashboard.php'>Back to Dashboard</a>
         </div>");
}

// 2. Handle Approval or Rejection
if (isset($_POST['action'])) {
    $id = $_POST['project_id'];
    $status = ($_POST['action'] == 'approve') ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE projects SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

// 3. Fetch Pending Projects
$result = $conn->query("SELECT projects.*, users.name as student_name 
                        FROM projects 
                        JOIN users ON projects.uploaded_by = users.id 
                        WHERE status='pending'");
?>

<div class="review-container">
    <div class="back-nav">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
    <h2>⚖️ Pending Approvals</h2>
    <p style="color: #64748b; margin-bottom: 2rem;">Review and manage project submissions below.</p>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-item">
                <div class="project-details">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Submitted by: <b><?php echo htmlspecialchars($row['student_name']); ?></b></p>
                    <a href="uploads/<?php echo $row['file_path']; ?>" download style="font-size: 0.8rem; color: #5c7cfa; text-decoration: none;">
                        View Attached File
                    </a>
                </div>

                <form method="POST" class="review-actions">
                    <input type="hidden" name="project_id" value="<?php echo $row['id']; ?>">

                    <button type="submit" name="action" value="approve" class="btn-approve">
                        Approve
                    </button>

                    <button type="submit" name="action" value="reject" class="btn-reject">
                        Reject
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-state">
            <p>Everything is clear! No projects are waiting for review.</p>
            <a href="dashboard.php" class="back-link">Return to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<?php // include 'includes/footer.php'; 
?>
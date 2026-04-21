<?php
include 'config/db.php';
include 'includes/header.php';

// Fetch all projects and join with users to get the uploader's name
$sql = "SELECT projects.*, users.name as uploader_name 
        FROM projects 
        JOIN users ON projects.uploaded_by = users.id 
        ORDER BY projects.id DESC";
$result = $conn->query($sql);

// We'll group them into arrays to display them in sections
$sections = ['approved' => [], 'pending' => [], 'rejected' => []];

while ($row = $result->fetch_assoc()) {
    $status = $row['status'] ? $row['status'] : 'pending';
    $sections[$status][] = $row;
}
?>

<div class="projects-container">
    <div class="back-nav">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>

    <?php foreach ($sections as $status => $project_list): ?>
        <section class="status-section">
            <h2 class="section-title status-<?php echo $status; ?>">
                <?php
                if ($status == 'approved') echo "✅ Approved Projects";
                elseif ($status == 'pending') echo "⏳ Pending Review";
                else echo "❌ Rejected Projects";
                ?>
            </h2>

            <div class="projects-grid">
                <?php if (count($project_list) > 0): ?>
                    <?php foreach ($project_list as $row): ?>
                        <div class="project-card card-<?php echo $status; ?>">
                            <div class="project-info">
                                <span class="uploader-tag">Uploaded by: <?php echo htmlspecialchars($row['uploader_name']); ?></span>
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p><?php echo htmlspecialchars($row['description']); ?></p>

                                <a href="uploads/<?php echo $row['file_path']; ?>" download class="download-btn btn-<?php echo $status; ?>">
                                    Download Project
                                </a>
                            </div>

                            <?php if ($status != 'rejected'): ?>
                                <div class="solutions-area">
                                    <hr>
                                    <h4>Student Solutions</h4>
                                    <?php
                                    $pid = $row['id'];

                                    // We fetch EVERYTHING from solutions, including the file_path
                                    $sol_sql = "SELECT solutions.*, users.name as student_name 
                FROM solutions 
                JOIN users ON solutions.student_id = users.id 
                WHERE project_id = $pid 
                ORDER BY created_at DESC";

                                    $sol_res = $conn->query($sol_sql);

                                    if ($sol_res && $sol_res->num_rows > 0): ?>
                                        <?php while ($s = $sol_res->fetch_assoc()): ?>
                                            <div class="solution-item">
                                                <div class="solution-meta">
                                                    <strong><?php echo htmlspecialchars($s['student_name']); ?></strong>
                                                    <span><?php echo date('M d, Y', strtotime($s['created_at'])); ?></span>
                                                </div>

                                                <p><?php echo htmlspecialchars($s['solution']); ?></p>

                                                <?php if (!empty($s['file_path'])): ?>
                                                    <a href="uploads/<?php echo htmlspecialchars($s['file_path']); ?>" download class="sol-download">
                                                        📎 Download Solution Attachment
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <p class="no-data">No solutions submitted yet.</p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-msg">No projects found in this category.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
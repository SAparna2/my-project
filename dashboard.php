<?php include 'includes/auth.php'; ?>

<?php 
include 'includes/header.php'; 

$username = $_SESSION['user']['name']; // Adjust based on your DB column name
?>

<div class="dashboard-container">
    <div class="welcome-header">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="action-grid">
    <a href="upload.php" class="action-card">
        <span>📤</span>
        Upload Project
    </a>
    
    <a href="projects.php" class="action-card">
        <span>📂</span>
        View Projects
    </a>

    <a href="solution.php" class="action-card">
        <span>💡</span>
        Submit Solution
    </a>

    <?php if(isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'faculty'): ?>
    <a href="review.php" class="action-card">
        <span>⚖️</span>
        Review Projects
    </a>
    <?php endif; ?>
</div>
</div>

<?php // include 'includes/footer.php'; ?>
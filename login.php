<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
    } else {
        echo "Invalid login";
    }
}
?>

<div class="login-container">
    <div class="top-nav">
    <a href="index.php" class="home-link">
        <span class="arrow">←</span> Back to Home
    </a>
</div>
    <h2>Login</h2>
    
    <?php if(isset($error)): ?>
        <p style="color: #e74c3c; margin-bottom: 15px; font-size: 0.9rem;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    
    <div class="form-footer">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

<?php // include 'includes/footer.php'; ?>
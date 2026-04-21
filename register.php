<?php
include 'config/db.php';
include 'includes/header.php';

$message = "";
$messageType = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
    
    if($checkEmail->num_rows > 0) {
        $message = "❌ This email is already registered!";
        $messageType = "error";
    } else {
        // Insert user
        $sql = "INSERT INTO users(name,email,password,role) VALUES('$name','$email','$password','$role')";
        
        if($conn->query($sql)) {
            $message = "✅ Registered Successfully! You can now login.";
            $messageType = "success";
        } else {
            $message = "❌ Registration failed. Please try again.";
            $messageType = "error";
        }
    }
}
?>

<div class="register-container">
    <div class="top-nav">
    <a href="index.php" class="home-link">
        <span class="arrow">←</span> Back to Home
    </a>
</div>
    <h2>Create Account</h2>

    <?php if($message != ""): ?>
        <div class="alert <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <select name="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
        </select>

        <button type="submit" name="register">Register</button>
    </form>
    
    <div class="form-footer">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>
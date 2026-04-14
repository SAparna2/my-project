<?php
include 'config/db.php';

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $conn->query("INSERT INTO users(name,email,password,role)
    VALUES('$name','$email','$password','$role')");

    echo "Registered Successfully!";
}
?>

<form method="POST">
    <h3>Register</h3>
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" required>
    <input type="password" name="password" required>

    <select name="role">
        <option value="student">Student</option>
        <option value="faculty">Faculty</option>
    </select>

    <button name="register">Register</button>
</form>
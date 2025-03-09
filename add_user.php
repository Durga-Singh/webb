<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
include("config.php"); // Database connection

// Handle form submission to add a new user
if (isset($_POST['add'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, md5($_POST['password'])); // Hash password

    $insertQuery = "INSERT INTO users (Username, Email, Password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($con, $insertQuery)) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Add New User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="add">Add User</button>
        </form>
        <a href="manage_users.php" class="back-btn">Back to Manage Users</a>
    </div>
</body>
</html>

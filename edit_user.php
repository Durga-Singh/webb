<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
include("config.php"); // Database connection

// Get user ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE Id='$id'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
}

// Handle form submission for updating user
if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    
    $updateQuery = "UPDATE users SET Username='$username', Email='$email' WHERE Id='$id'";
    if (mysqli_query($con, $updateQuery)) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $user['Username']; ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['Email']; ?>" required>
            <button type="submit" name="update">Update</button>
        </form>
        <a href="manage_users.php" class="back-btn">Back to Manage Users</a>
    </div>
</body>
</html>

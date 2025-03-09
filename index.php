<?php
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check in users table
    $userQuery = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
    $userResult = mysqli_query($con, $userQuery);
    $userRow = mysqli_fetch_assoc($userResult);

    // Check in admin table
    $adminQuery = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $adminResult = mysqli_query($con, $adminQuery);
    $adminRow = mysqli_fetch_assoc($adminResult);

    if ($userRow) { 
        // If the user exists, redirect to user home
        $_SESSION['valid'] = $userRow['Email'];
        $_SESSION['username'] = $userRow['Username'];
        $_SESSION['age'] = $userRow['Age'];
        $_SESSION['id'] = $userRow['Id'];
        header("Location: home.php");
        exit();
    } elseif ($adminRow) { 
        // If the admin exists, redirect to admin dashboard
        $_SESSION['admin'] = $adminRow['email'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<div class='message'><p>Wrong Username or Password</p></div><br>";
        echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body class="auth-page">
    <div class="container">
        <div class="nav">
            <div class="logo">
                <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
            </div>
        </div>
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

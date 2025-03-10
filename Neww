<?php

function valid_email($email){
    $result = trim($email);
    if(filter_var($result, FILTER_VALIDATE_EMAIL)){
        return "Email Valid";
    } else {
        echo "Email not Valid";
    }
}

echo valid_email("abc@gmail.com");

?>



<label for="username">
    Username: (3-10 characters)
</label>
<input type="text" pattern="\w{3,10}" id="username" name="username" value="Percent" required/>

<label for="pin">
    PIN: (4 digits)
</label>
<input type="password" pattern="\d{4,4}" id="pin" name="pin" required/>





<?php
include("config.php");
$error = ""; // To store error messages

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $age = $_POST['age'];
    $password = $_POST['password'];

    // Validation
    if (!preg_match("/^[a-zA-Z0-9]{3,10}$/", $username)) {
        $error = "Username must be 3-10 characters long and contain only letters and numbers.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!filter_var($age, FILTER_VALIDATE_INT, ["options" => ["min_range" => 18, "max_range" => 100]])) {
        $error = "Age must be between 18 and 100.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Verifying the unique email
        $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");
        if (mysqli_num_rows($verify_query) != 0) {
            $error = "This email is already in use. Try another!";
        } else {
            mysqli_query($con, "INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") 
            or die("Error Occurred");

            echo "<div class='message'>
                  <p>Registration successful!</p>
              </div> <br>";
            echo "<a href='index.php'><button class='btn'>Login Now</button>";
            exit;
        }
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
    <title>Register</title>
</head>
<body class="auth-page">
    <div class="container">
        <div class="nav">
            <div class="logo">
                <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
            </div>
        </div>
        <div class="box form-box">
            <header>Sign Up</header>

            <?php if (!empty($error)) { echo "<div class='message'><p>$error</p></div><br>"; } ?>

            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register">
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

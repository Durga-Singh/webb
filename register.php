<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>

<body class="auth-page"> <!-- Adding the class "auth-page" here -->
    <div class="container">
        <div class="nav">
            <div class="logo">
                <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
            </div>
        </div>
        <div class="box form-box">
            <?php
            include("config.php");
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];

                // Verifying the unique email
                $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");
                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                      <p>This email is already in use. Try another!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    mysqli_query($con, "INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Error Occurred");
                    echo "<div class='message'>
                      <p>Registration successful!</p>
                  </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }
            } else {
            ?>
                <header>Sign Up</header>
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
    <?php } ?>
    </div>
</body>

</html>
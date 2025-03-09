<?php
session_start();
include("config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

// Fetch user data
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
$user = mysqli_fetch_assoc($query);

// Check if the form is submitted and update user info
if (isset($_POST['submit'])) {
    // Get user input from the form
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = mysqli_real_escape_string($con, $_POST['age']);

    // Update user data in the database
    $update_query = "UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        // If update successful, show a success message
        echo "<script>alert('Profile updated successfully!'); window.location.href='edit.php';</script>";
    } else {
        // If update fails, show an error message
        echo "<script>alert('Error updating profile. Please try again.');</script>";
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
    <title>Change Profile</title>
    <style>
        input, button {
    margin-top: 10px;
    padding: 8px 12px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
}
    </style>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
        </div>
    </div>

    <div class="container">
        <div class="box form-box">
            <header>Change Profile</header>

            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['Username']); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['Email']); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($user['Age']); ?>" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update">
                </div>
            </form>
        </div>
        <div class="field">
            <input type="submit" class="btn" name="submit" onclick="redirectToPage()" value="My Orders">
        </div>

        <div class="logout" style="display: flex; justify-content: center; margin-top: 20px; border-top: 2px solid #ddd;">
            <a href="logout.php"><button class="btn logout-btn">Log Out</button></a>
        </div>
    </div>

    <script>
        function redirectToPage() {
            window.location.href = "my_orders.php"; // Change this to your desired page
        }
    </script>
</body>

</html>
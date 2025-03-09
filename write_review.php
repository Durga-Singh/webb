<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Fetch the logged-in username
$payment_id = $_GET['payment_id'] ?? null;

if (!$payment_id) {
    die("Invalid order.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($con, $_POST['review']); // Fixed $conn reference

    // Insert the review with Username instead of user_id
    $query = "INSERT INTO reviews (payment_id, Username, rating, review) 
              VALUES ('$payment_id', '$username', '$rating', '$review')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Review submitted successfully!'); window.location.href='my_orders.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* Google Font */
        
    </style>
</head>
<body class="review-body">
<nav class="nav">
        <div class="logo">
            <p><a href="home.php"><span class="case">Case</span> <span class="cobra">Cobra</span></a></p>
        </div>
        <div class="navtwo">
            <div class="left-links">
                <a href="create_case.php">Create Case <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="right-links">
                <?php
                
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
                while ($result = mysqli_fetch_assoc($query)) {
                    $res_id = $result['Id'];
                }
                echo "<a href='edit.php?Id=$res_id'><i class='fas fa-user-circle profile-icon-logo'></i></a>";
              ?>
            </div>
        </div>
    </nav>


    <div class="review-container">
        <h2 class="review-h2" >Write a Review</h2>
        <form class="review-form" method="post">
            <label for="rating">Rating (1-5):</label>
            <select class="select-review" name="rating" required>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>

            <label class="label-review" for="review">Your Review:</label>
            <textarea class="textarea-review" name="review" placeholder="Share your experience..." required></textarea>

            <button type="submit" class="btn-review">Submit Review</button>
        </form>
    </div>
</body>
</html>

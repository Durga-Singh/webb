<?php
session_start();
include 'config.php'; // Include database connection

if (!isset($_SESSION['username'])) {
    echo "Please log in to view your orders.";
    exit;
}

$username = $_SESSION['username']; // Get logged-in user's username

// Ensure the database connection is defined
if (!isset($con)) {
    die("Database connection error.");
}

// Fetch all payment details along with the image
$query = "SELECT id, username, amount, payment_status, payment_id, added_on, model, material, finish, delivery_date, image 
          FROM payment 
          WHERE username = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }

        .orders-container {
            margin-top: 15vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 30px;
            max-width: 1200px;
        }

        .order-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 70vw;
            display: flex;
            align-items: center;
            gap: 40px;
            text-align: left;
            transition: transform 0.3s ease-in-out;
        }

        .order-card:hover {
            transform: scale(1.02);
        }

        .order-card img {
            margin-left: 15px;
            width: 120px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .order-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            font-size: 14px;
            line-height: 1.6;
        }

        .order-details .left,
        .order-details .right {
            width: 48%;
        }

        .seperation {
            border: 1px solid #ddd;
            height: 200px;
        }

        .highlight {
            font-weight: bold;
            color: #27ae60;
        }

        @media (max-width: 768px) {
            .order-card {
                flex-direction: column;
                align-items: center;
                width: 90%;
                padding: 15px;
            }

            .seperation{
                display: none;
            }

            .order-card img {
                width: 80px;
                margin-bottom: 10px;
            }

            .order-details {
                flex-direction: column;
                text-align: center;
                align-items: center;
                
            }

            .review-btn {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>

<body>
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
                while ($resultt = mysqli_fetch_assoc($query)) {
                    $res_id = $resultt['Id'];
                }
                echo "<a href='edit.php?Id=$res_id'><i class='fas fa-user-circle profile-icon-logo'></i></a>";
              ?>
            </div>
        </div>
        
    </nav>

    <div class="orders-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="order-card">';
                echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Uploaded Image">';
                echo '<div class="seperation">';
                echo '</div>';
                echo '<div class="order-details">';
                echo '<div class="left">';
                echo '<p><span class="highlight">Id:</span> ' . htmlspecialchars($row['id']) . '</p>';
                echo '<p><span class="highlight">Username:</span> ' . htmlspecialchars($row['username']) . '</p>';
                echo '<p><span class="highlight">Amount Paid:</span> ₹' . htmlspecialchars($row['amount']) . '</p>';
                echo '<p><span class="highlight">Payment ID:</span> ' . htmlspecialchars($row['payment_id']) . '</p>';
                echo '<p><span class="highlight">Payment Status:</span> ' . htmlspecialchars($row['payment_status']) . '</p>';
                echo '</div>';


                echo '<div class="right">';
                echo '<p><span class="highlight">Date:</span> ' . htmlspecialchars($row['added_on']) . '</p>';
                echo '<p><span class="highlight">Model:</span> ' . htmlspecialchars($row['model']) . '</p>';
                echo '<p><span class="highlight">Material:</span> ' . htmlspecialchars($row['material']) . '</p>';
                echo '<p><span class="highlight">Finish:</span> ' . htmlspecialchars($row['finish']) . '</p>';
                echo '<p><span class="highlight">Estimated delivery date:</span> ' . htmlspecialchars($row['delivery_date']) . '</p>';
                echo "<a href='write_review.php?payment_id=" . $row['id'] . "' 
        style='
            display: inline-block;
            background-color: #27ae60;
            color: white;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
            margin-top: 38px;
        ' 
        onmouseover='this.style.backgroundColor=\"#219150\"' 
        onmouseout='this.style.backgroundColor=\"#27ae60\"'>
        Write a Review
      </a>";

                echo '</div>';
                echo '</div>'; // Close order-details
                echo '</div>'; // Close order-card
            }
        } else {
            echo "<p>No paid orders found.</p>";
        }
        ?>
    </div>
</body>

</html>

<?php
$stmt->close();
$con->close();
?>
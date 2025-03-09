<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
include("config.php"); // Include database connection

// Handle delivery date update
if (isset($_POST['update_delivery'])) {
    $order_id = $_POST['order_id'];
    $delivery_date = $_POST['delivery_date'];
    $update_query = "UPDATE payment SET delivery_date='$delivery_date' WHERE id='$order_id'";
    mysqli_query($con, $update_query);
    header("Location: manage_orders.php");
    exit();
}

// Fetch payment details with image data from the payment table
$query = "SELECT id, Username, amount, payment_status, added_on, image, delivery_date 
          FROM payment 
          ORDER BY added_on DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #27ae60;
            color: white;
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .back-btn:hover {
            background-color: #218c54;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Manage Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Payment Date</th>
                <th>Design</th>
                <th>Delivery Date</th>
                <th>Set Delivery Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['Username']; ?></td>
                    <td><?php echo '$' . $row['amount']; ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td><?php echo $row['added_on']; ?></td>
                    <td>
    <?php if (!empty($row['image'])) { ?>
        <a href="view_image.php?id=<?php echo $row['id']; ?>" target="_blank">Click Here</a>
    <?php } else { echo "No Image"; } ?>
</td>
                    <td><?php echo $row['delivery_date'] ? $row['delivery_date'] : 'Not Set'; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <input type="datetime-local" name="delivery_date" required>
                            <button type="submit" name="update_delivery">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>

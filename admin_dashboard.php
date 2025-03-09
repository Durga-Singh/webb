<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .btn{
            width: 40vw;
        }
        h2{
            text-align: center;
        }
        .logout{
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="contain">
    <h2>Welcome, Admin</h2>
        <div class="admin-actions" style="display: flex; flex-direction: column; align-items: center; margin-top: 20px;">
            <a href="manage_users.php"><button class="btn">Manage Users</button></a>
            <a href="manage_orders.php"><button class="btn">Manage Orders</button></a>
            <a href="manage_products.php"><button class="btn">Manage Products</button></a>
        </div>

        <div class="logout" style="border-top: 2px solid #ddd">
            <a href="logout.php"><button class="logout-btn">Log Out</button></a>
        </div>
    </div>
</body>

</html>
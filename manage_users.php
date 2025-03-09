<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
include("config.php"); // Include database connection

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM users WHERE Id='$id'");
    header("Location: manage_users.php");
    exit();
}

// Fetch unique user data
$query = "SELECT DISTINCT users.Id, users.Username, users.Email FROM users";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
        .back-btn, .edit-btn, .delete-btn {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #f0ad4e;
            color: white;
        }
        .delete-btn {
            background-color: red;
            color: white;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
        .edit-btn:hover {
            background-color: #ec971f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo $row['Username']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['Id']; ?>" class="edit-btn">Edit</a>
                        <a href="manage_users.php?delete=<?php echo $row['Id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="add_user.php" class="back-btn" style="background-color: green; color: white;">Add New User</a>
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>

</html>

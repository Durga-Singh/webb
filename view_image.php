<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
include("config.php"); // Database connection

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);
$query = "SELECT image FROM payment WHERE id = '$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if (!$row || empty($row['image'])) {
    die("Image not found.");
}

// Display the image
header("Content-Type: image/jpeg"); // Change based on the image type stored
echo file_get_contents($row['image']);
exit();
?>

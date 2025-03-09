<?php
session_start();
include('config.php');

if (isset($_POST['amt'])) {
    $amt = $_POST['amt'];
    $username = $_SESSION['username']; // Fetch username from session 
    $model = $_POST['model']; 
    $material = $_POST['material']; 
    $finish = $_POST['finish']; 
    $image = $_POST['image']; 

    $payment_status = "pending";
    $added_on = date('Y-m-d h:i:s');
    
    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_SESSION['username']);
    $model = mysqli_real_escape_string($con, $model);
    $material = mysqli_real_escape_string($con, $material);
    $finish = mysqli_real_escape_string($con, $finish);
    $image = mysqli_real_escape_string($con, $image);

    mysqli_query($con, "INSERT INTO payment(username, amount, payment_status, added_on, model, material, finish, image) 
                        VALUES('$username', '$amt', '$payment_status', '$added_on', '$model', '$material', '$finish', '$image')");
    
    $_SESSION['OID'] = mysqli_insert_id($con);
    $user_id = $_SESSION['id'];
    mysqli_query($con, "UPDATE payment SET user_id = $user_id WHERE id = {$_SESSION['OID']}");
}

if (isset($_POST['payment_id']) && isset($_SESSION['OID'])) {
    $payment_id = $_POST['payment_id'];
    mysqli_query($con, "UPDATE payment SET payment_status='complete', payment_id='$payment_id' WHERE id='" . $_SESSION['OID'] . "'");
}
?>
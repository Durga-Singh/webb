<?php
include 'config.php'; // Ensure DB connection is available

$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'];

if ($image) {
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = base64_decode($image);
    
    $stmt = $conn->prepare("INSERT INTO designs (user_id, image_data) VALUES (?, ?)");
    $stmt->bind_param("ib", $user_id, $image);
    
    $user_id = 1; // Replace with session user ID
    $stmt->execute();

    echo "Design saved successfully!";
} else {
    echo "Failed to save design.";
}
?>

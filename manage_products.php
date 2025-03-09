<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

// File to store materials and finishes
$products_file = 'products.json';

// Load existing materials and finishes
if (file_exists($products_file)) {
    $data = json_decode(file_get_contents($products_file), true);
} else {
    $data = [
        'materials' => ['Silicone', 'Polycarbonate'],
        'finishes' => ['Glossy', 'Matte']
    ];
    file_put_contents($products_file, json_encode($data));
}

// Handle adding material
if (isset($_POST['add_material'])) {
    $new_material = trim($_POST['material']);
    if (!in_array($new_material, $data['materials']) && !empty($new_material)) {
        $data['materials'][] = $new_material;
        file_put_contents($products_file, json_encode($data));
    }
    header("Location: manage_products.php");
    exit();
}

// Handle deleting material
if (isset($_GET['delete_material'])) {
    $delete_material = $_GET['delete_material'];
    $data['materials'] = array_values(array_diff($data['materials'], [$delete_material]));
    file_put_contents($products_file, json_encode($data));
    header("Location: manage_products.php");
    exit();
}

// Handle adding finish
if (isset($_POST['add_finish'])) {
    $new_finish = trim($_POST['finish']);
    if (!in_array($new_finish, $data['finishes']) && !empty($new_finish)) {
        $data['finishes'][] = $new_finish;
        file_put_contents($products_file, json_encode($data));
    }
    header("Location: manage_products.php");
    exit();
}

// Handle deleting finish
if (isset($_GET['delete_finish'])) {
    $delete_finish = $_GET['delete_finish'];
    $data['finishes'] = array_values(array_diff($data['finishes'], [$delete_finish]));
    file_put_contents($products_file, json_encode($data));
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            width: 50%;
            margin: auto;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            background-color: #27ae60;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218c54;
        }
        .delete-btn {
            background-color: red;
            padding: 5px 10px;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Materials & Finishes</h2>
        
        <h3>Materials</h3>
        <ul>
            <?php foreach ($data['materials'] as $material) { ?>
                <li><?php echo $material; ?> 
                    <a href="?delete_material=<?php echo urlencode($material); ?>" class="delete-btn">Delete</a>
                </li>
            <?php } ?>
        </ul>
        <form method="POST">
            <input type="text" name="material" placeholder="New Material" required>
            <button type="submit" name="add_material" class="btn">Add Material</button>
        </form>
        
        <h3>Finishes</h3>
        <ul>
            <?php foreach ($data['finishes'] as $finish) { ?>
                <li><?php echo $finish; ?> 
                    <a href="?delete_finish=<?php echo urlencode($finish); ?>" class="delete-btn">Delete</a>
                </li>
            <?php } ?>
        </ul>
        <form method="POST">
            <input type="text" name="finish" placeholder="New Finish" required>
            <button type="submit" name="add_finish" class="btn">Add Finish</button>
        </form>
        
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
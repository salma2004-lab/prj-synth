<?php
session_start();
// Ensure the user is logged in and is an admin
if (! isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'db.php'; // Include the database connection

// Create upload directory if it doesn't exist
$target_dir = '../images/menu/';
if (! is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $category_id = (int) $_POST['category_id'];
    $image_url   = ''; // Default image_url is empty

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name  = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        // Check if the file is an actual image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            die("The file is not a valid image.");
        }

                                                  // Check file size (limit to 5MB)
        if ($_FILES['image']['size'] > 5242880) { // 5MB
            die("The file is too large. Please upload an image smaller than 5MB.");
        }

        // Move the uploaded file to the images folder
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = $target_dir . $image_name;
        } else {
            die("Error uploading file. Check directory permissions.");
        }
    }

    // Insert the new menu item into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, image_url, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image_url, $category_id]);
        header('Location: menu_items.php?status=added');
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

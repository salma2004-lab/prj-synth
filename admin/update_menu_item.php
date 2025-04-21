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

    // Fetch the menu item to edit
    if (! isset($_GET['id'])) {
        header('Location: menu_items.php');
        exit;
    }
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (! $item) {
        header('Location: menu_items.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name        = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price       = floatval($_POST['price']);
        $category_id = (int) $_POST['category_id'];
        $image_url   = $item['image_url']; // Keep the existing image URL if no new image is provided

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
                // Remove the old image if it exists
                if (! empty($image_url) && file_exists($image_url)) {
                    unlink($image_url);
                }
                $image_url = $target_dir . $image_name;
            } else {
                die("Error uploading file. Check directory permissions.");
            }
        }

        // Update the menu item in the database
        try {
            $stmt = $pdo->prepare("UPDATE menu_items SET name = ?, description = ?, price = ?, image_url = ?, category_id = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $image_url, $category_id, $id]);
            header('Location: menu_items.php?status=updated');
            exit;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
?>
<?php include_once 'includes/header.php'; ?>
    <div class="container mt-5">
        <h2>Edit Menu Item:                                                                                                             <?php echo htmlspecialchars($item['name']); ?></h2>
        <form method="POST" action="update_menu_item.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price (DH)</label>
                <input type="number" step="1"  min="0" min="0" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                        $stmt       = $pdo->query("SELECT * FROM categories ORDER BY name");
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"<?php echo($category['id'] == $item['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                    <label class="custom-file-label" for="image">Choose file</label>
                </div>
                <small class="form-text text-muted">Leave empty to keep current image. Max 5MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
    <?php include_once 'includes/scripts.php'; ?>
</body>
</html>
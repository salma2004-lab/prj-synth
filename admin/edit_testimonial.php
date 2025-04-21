<?php
    session_start();

    // Redirect to login page if user is not logged in
    if (! isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once 'db.php'; // Include database connection

    // Fetch testimonial ID from the query string
    $testimonial_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Fetch the testimonial data
    try {
        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->execute([$testimonial_id]);
        $testimonial_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $testimonial_data) {
            echo '<script>alert("Témoignage introuvable.");</script>';

        }
    } catch (PDOException $e) {
        echo '<script>alert("Erreur lors de la récupération du témoignage : ' . htmlspecialchars($e->getMessage()) . '");</script>';

    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name             = trim($_POST['name']);
        $testimonial_text = trim($_POST['testimonial']);
        $image_url        = $testimonial_data['image_url']; // Retain the existing image by default

        // Handle image upload (if a new image is provided)
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir  = '../images/client_avis/';
            $fileName   = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['image']['name']));
            $targetFile = $targetDir . $fileName;

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Delete the old image if it exists
                    if ($testimonial_data['image_url'] && file_exists('../' . $testimonial_data['image_url'])) {
                        unlink('../' . $testimonial_data['image_url']);
                    }
                    $image_url = '../images/client_avis/' . $fileName; // Update image URL
                } else {
                    echo '<script>alert("Erreur lors du téléchargement de l\'image.");</script>';

                }
            } else {
                echo '<script>alert("Type d\'image non autorisé. Formats acceptés : JPG, PNG, GIF.");</script>';
            }
        }

        try {
            // Update the testimonial in the database
            $stmt = $pdo->prepare("
            UPDATE testimonials
            SET name = ?, testimonial = ?, image_url = ?
            WHERE id = ?
        ");
            $stmt->execute([$name, $testimonial_text, $image_url, $testimonial_id]);

            echo '<script>alert("Témoignage mis à jour avec succès.");</script>';
            echo '<script>window.location.href = "testimonials.php";</script>';

        } catch (Exception $e) {
            echo '<script>alert("Erreur lors de la mise à jour du témoignage : ' . htmlspecialchars($e->getMessage()) . '");</script>';
            echo '<script>window.location.href = "testimonials.php";</script>';

        }
    }
?>

<?php include_once 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Modifier un Témoignage</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($testimonial_data['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="testimonial" class="form-label">Témoignage</label>
            <textarea class="form-control" id="testimonial" name="testimonial" rows="5" required><?php echo htmlspecialchars($testimonial_data['testimonial']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (Facultatif)</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if (! empty($testimonial_data['image_url'])): ?>
                <div class="mt-2">
                    <strong>Image actuelle :</strong><br>
                    <img src="<?php echo htmlspecialchars($testimonial_data['image_url']); ?>" alt="Image actuelle" style="max-width: 200px; margin-top: 10px;">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="testimonials.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>
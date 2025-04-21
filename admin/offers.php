<?php
    session_start();

    // Redirect to login page if user is not logged in
    if (! isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once 'db.php'; // Include database connection

    // Handle form submission (Add/Update/Delete)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            // Add a new offer
            $name        = trim($_POST['name']);
            $description = trim($_POST['description']);
            $discount    = floatval($_POST['discount']);
            $image_url   = '';

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $targetDir  = '../images/offers/';
                $fileName   = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['image']['name']));
                $targetFile = $targetDir . $fileName;

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['image']['type'], $allowedTypes)) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $image_url = '../images/offers/' . $fileName; // Update image URL
                    } else {
                        echo '<script>alert("Erreur lors du téléchargement de l\'image.");</script>';
                    }
                } else {
                    echo '<script>alert("Type d\'image non autorisé. Formats acceptés : JPG, PNG, GIF.");</script>';
                }
            }

            try {
                // Insert the new offer into the database
                $stmt = $pdo->prepare("
                INSERT INTO offers (name, description, discount, image_url)
                VALUES (?, ?, ?, ?)
            ");
                $stmt->execute([$name, $description, $discount, $image_url]);

                echo '<script>alert("Offre ajoutée avec succès.");</script>';
                echo '<script>window.location.href = "offers.php";</script>';

            } catch (Exception $e) {
                echo '<script>alert("Erreur lors de la l\'ajout de l\'offre : ' . htmlspecialchars($e->getMessage()) . '");</script>';

            }
        } elseif ($action === 'delete') {
            // Delete an offer by ID
            $id = intval($_POST['id']);

            try {
                $stmt = $pdo->prepare("DELETE FROM offers WHERE id = ?");
                $stmt->execute([$id]);

                echo '<script>alert("Offre supprimée avec succès.");</script>';
                echo '<script>window.location.href = "offers.php";</script>';

            } catch (Exception $e) {
                echo '<script>alert("Erreur lors de la suppression de l\'offre : ' . htmlspecialchars($e->getMessage()) . '");</script>';

            }
        }
    }

    // Fetch all offers from the database
    try {
        $stmt   = $pdo->query("SELECT * FROM offers ORDER BY id DESC");
        $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des offres : " . $e->getMessage());
    }
?>

<?php include_once 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestion des Offres</h2>

    <!-- Form to Add/Edit Offers -->
    <?php if (count($offers) < 4): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ajouter une Nouvelle Offre</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'Offre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="discount" class="form-label">Réduction (%)</label>
                        <input type="number" step="1"  min="0" max="100" class="form-control" id="discount" name="discount" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image (Facultatif)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Vous avez atteint le nombre maximum d'offres (4). Veuillez supprimer une offre pour en ajouter une nouvelle.</div>
    <?php endif; ?>

    <!-- List of Offers -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Offres</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Réduction (%)</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (! empty($offers)): ?>
<?php foreach ($offers as $offer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($offer['name']); ?></td>
                                    <td><?php echo htmlspecialchars($offer['description']); ?></td>
                                    <td><?php echo number_format($offer['discount'], 2); ?> %</td>
                                    <td>
                                        <?php if (! empty($offer['image_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($offer['image_url']); ?>" alt="Image de l'offre" style="max-width: 100px;">
                                        <?php else: ?>
                                            Aucune image
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($offer['id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
<?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Aucune offre disponible</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
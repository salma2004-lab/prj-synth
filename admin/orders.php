<?php
    session_start();

    // Ensure the user is logged in and is an admin
    if (! isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once 'db.php'; // Include the database connection

    // Fetch all orders
    $stmt   = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Update order status logic (for example, mark as confirmed)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = (int) $_POST['order_id'];
        $status   = $_POST['status'];

        // Fetch the current status of the order
        $stmt = $pdo->prepare("SELECT status FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $current_status = $order['status'];

            // Check if the current status is "pending" or "confirmed"
            if ($current_status === 'pending' || $current_status === 'confirmed') {
                // Update the order status
                $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
                $stmt->execute([$status, $order_id]);

                // If the status is 'delivered', update sales count for all menu items in the order
                if ($status === 'delivered') {
                    // Fetch all items in this order
                    $stmt = $pdo->prepare("SELECT product_id, quantity FROM order_items WHERE order_id = ?");
                    $stmt->execute([$order_id]);
                    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Begin a transaction to ensure all updates happen atomically
                    $pdo->beginTransaction();

                    try {
                        // Loop through each order item and update the sales count in the menu_items table
                        foreach ($order_items as $item) {
                            $product_id = $item['product_id'];
                            $quantity   = $item['quantity'];

                            // Update sales_count by adding the quantity of items sold
                            $stmt = $pdo->prepare("UPDATE menu_items SET sales_count = sales_count + ? WHERE id = ?");
                            $stmt->execute([$quantity, $product_id]);
                        }

                        // Commit the transaction after all updates are done
                        $pdo->commit();
                    } catch (Exception $e) {
                        // If any error occurs, rollback the transaction
                        $pdo->rollBack();
                        // Optionally, log the error or handle it as needed
                        echo "Failed to update sales count: " . $e->getMessage();
                    }
                }

                // Redirect to the same page after updating the status
                header("Location: orders.php");
                exit;
            } else {
                // Show error message if the order is already delivered or cancelled
                $error_message = "Vous ne pouvez pas modifier l'état d'une commande déjà livrée ou annulée.";
            }
        } else {
            // Show error message if the order does not exist
            $error_message = "Commande non trouvée.";
        }
    }
?>

<?php include_once 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gérer les Commandes</h2>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Commandes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID de Commande</th>
                            <th>Client</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['total']); ?> DH</td>
                                <td>
                                    <span class="badge
                                        <?php
                                            switch ($order['status']) {
                                                case 'pending':
                                                    echo 'bg-warning';
                                                    break;
                                                case 'confirmed':
                                                    echo 'bg-primary';
                                                    break;
                                                case 'delivered':
                                                    echo 'bg-success';
                                                    break;
                                                case 'cancelled':
                                                    echo 'bg-danger';
                                                    break;
                                        }
                                        ?>">
                                        <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                                <td>
                                    <a href="order_details.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Only show the update button if status is 'pending' or 'confirmed' -->
                                    <?php if ($order['status'] === 'pending' || $order['status'] === 'confirmed'): ?>
                                    <form method="POST" action="orders.php" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                        <select name="status" class="form-control form-control-sm" style="width: 150px;">
                                            <option value="pending"                                                                                                                                                                                                                                                                             <?php echo($order['status'] == 'pending') ? 'selected' : ''; ?>>En attente</option>
                                            <option value="confirmed"                                                                                                                                                                                                                                                                                     <?php echo($order['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmée</option>
                                            <option value="delivered"                                                                                                                                                                                                                                                                                     <?php echo($order['status'] == 'delivered') ? 'selected' : ''; ?>>Livrée</option>
                                            <option value="cancelled"                                                                                                                                                                                                                                                                                     <?php echo($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Annulée</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success mt-2">Mettre à jour</button>
                                    </form>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
<?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucune commande trouvée</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
y
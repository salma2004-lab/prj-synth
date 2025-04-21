<?php
    // Include the database connection
    require_once 'db.php';

    // Function to fetch all menu items
    function getMenuItems()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM menu_items limit 12");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch menu items
    $menuItems = getMenuItems();
?>
<section class="food_section layout_padding-bottom">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Menu populaire</h2>
        </div>
        <div class="filters-content">
            <div class="row grid">
                <?php foreach ($menuItems as $item): ?>
                    <div class="col-sm-6 col-lg-4 all<?php echo($item['category']); ?>">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo $item['name'] ?>" />
                                </div>
                                <div class="detail-box">
                                    <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                                    <div class="options">
                                        <h6><?php echo htmlspecialchars(number_format($item['price'], 2)); ?> DH</h6>
                                        <button class="add-to-cart" onclick="addToCart(<?php echo htmlspecialchars($item['id']); ?>)">
                                            <img src="icons/cart.png" alt="Add to cart" width="22px">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
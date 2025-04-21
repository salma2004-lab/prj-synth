<?php include_once 'header.php'; ?>

<body class="sub_page show-pagination">
    <div class="hero_area">
        <div class="bg-box">
            <img src="../images/hero-bg.jpg" alt="">
        </div>

        <!-- Header Section -->
        <header class="header_section">
            <div class="container">
                <?php include_once 'nav.php'; ?>
            </div>
        </header>
    </div>

    <!-- Food Section -->
    <section class="food_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Notre Menu</h2>
            </div>

            <!-- Category Filters -->
            <?php include_once 'category_filter.php'?>

            <!-- Menu Items -->
            <div class="filters-content">
                <div class="row grid">
                    <?php
                        require_once 'db.php';

                        // Fetch all menu items with their corresponding category names
                        $stmt = $pdo->query("
                        SELECT mi.id, mi.name AS item_name, mi.description, mi.price, mi.image_url, c.name AS category_name
                        FROM menu_items mi
                        LEFT JOIN categories c ON mi.category_id = c.id
                    ");
                        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($menuItems as $item):
                            // Sanitize category name for use in HTML classes
                            $sanitizedCategoryName = strtolower(str_replace(' ', '-', $item['category_name'] ?? 'uncategorized'));
                        ?>
			                    <div class="col-sm-6 col-lg-4 all<?php echo htmlspecialchars($sanitizedCategoryName); ?>">
			                        <div class="box" data-id="<?php echo htmlspecialchars($item['id']); ?>">
			                            <div>
			                                <div class="img-box">
			                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" />
			                                </div>
			                                <div class="detail-box">
			                                    <h5><?php echo htmlspecialchars($item['item_name']); ?></h5>
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

    <?php include_once 'footer.php'; ?>

    <!-- Scripts -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/cart.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var grid = document.querySelector('.grid');
            if (!grid) {
                console.error('Grid element not found!');
                return;
            }

            var iso = new Isotope(grid, {
                itemSelector: '.col-sm-6',
                layoutMode: 'fitRows'
            });

            // Filter items on button click
            var filterButtons = document.querySelectorAll('.filters_menu li');
            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var filterValue = this.getAttribute('data-filter');
                    console.log('Filter clicked:', filterValue);

                    iso.arrange({ filter: filterValue });

                    // Remove active class from all buttons
                    filterButtons.forEach(function (btn) {
                        btn.classList.remove('active');
                    });

                    // Add active class to the clicked button
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
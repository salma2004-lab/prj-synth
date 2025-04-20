<?php
    $current_page = basename($_SERVER['PHP_SELF']);

    $page_title = '';
    switch ($current_page) {
        case 'index.php':
            $page_title = 'Accueil';
            break;
        case 'menu.php':
            $page_title = 'Menu';
            break;
        case 'about.php':
            $page_title = 'A Propos';
            break;
        case 'book.php':
            $page_title = 'Réserver';
            break;
        default:
            $page_title = 'ELBARAKA';
    }

?>
    <title><?php echo $page_title; ?> - ELBARAKA</title>

<nav class="navbar navbar-expand-lg custom_nav-container">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
        <span> ELBARAKA </span>
    </a>

    <!-- Navbar Toggler -->
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span></span>
    </button>

    <!-- Navbar Content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <!-- Home -->
            <li class="nav-item                                                                                              <?php echo($current_page == 'index.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>

            <!-- Menu -->
            <li class="nav-item                                                                                              <?php echo($current_page == 'menu.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="menu.php">Menu</a>
            </li>

            <!-- About -->
            <li class="nav-item                                                                                              <?php echo($current_page == 'about.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="about.php">A Propos</a>
            </li>

            <!-- Book -->
            <li class="nav-item                                                                                              <?php echo($current_page == 'book.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="book.php">Réserver</a>
            </li>
        </ul>

        <!-- User Options -->
        <div class="user_option">
            <a class="cart_link" href="#">
                <img src="icons/cart-light.png" alt="" style="width: 22px" />
            </a>
        </div>
    </div>
</nav>
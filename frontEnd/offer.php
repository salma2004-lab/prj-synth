<?php

    require_once 'db.php';

    function getOffers()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM offers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $offers = getOffers();
?>
<section class="offer_section layout_padding-bottom">
    <div class="container">
        <div class="row">
            <?php foreach ($offers as $offer): ?>
                <div class="col-md-6">
                    <div class="box">
                        <div class="img-box">
                            <img src="<?php echo htmlspecialchars($offer['image_url']); ?>" alt="<?php echo htmlspecialchars($offer['name']); ?>" />
                        </div>
                        <div class="detail-box">
                            <h5><?php echo htmlspecialchars($offer['name']); ?></h5>
                            <h6><span><?php echo htmlspecialchars(number_format($offer['discount'], 0)); ?>%</span> Off</h6>
                            <a href="#">
                                Commander Maintenant
                                <img src="icons/cart.png" alt="Add to Cart" style="width: 22px;" />
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php

    require_once 'db.php';

    function getFooterData($key_name)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT value FROM footer WHERE key_name = :key_name");
        $stmt->execute(['key_name' => $key_name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? htmlspecialchars($result['value']) : '';
    }

    $address    = getFooterData('address');
    $phone      = getFooterData('phone');
    $email      = getFooterData('email');
    $hours_days = getFooterData('hours_days');
    $hours_time = getFooterData('hours_time');

    $facebook  = getFooterData('facebook');
    $instagram = getFooterData('instagram');
    $twitter   = getFooterData('twitter');
?>

<footer class="footer_section">
  <div class="container">
    <div class="footer_content">

      <!-- Contact Section -->
      <div class="footer-col">
        <div class="footer_contact">
          <h4>Contactez-nous</h4>
          <div class="contact_link_box">
            <a href="book.html" class="contact-link">
              <div class="icon-container">
                <img
                  src="icons/location.png"
                  alt="Location icon"
                  class="contact-icon"
                />
              </div>
              <span><?php echo $address; ?></span>
            </a>
            <a href="tel:<?php echo $phone; ?>" class="contact-link">
              <div class="icon-container">
                <img
                  src="icons/phone.png"
                  alt="Phone icon"
                  class="contact-icon"
                />
              </div>
              <span><?php echo $phone; ?></span>
            </a>
            <a href="mailto:<?php echo $email; ?>" class="contact-link">
              <div class="icon-container">
                <img
                  src="icons/email.png"
                  alt="Email icon"
                  class="contact-icon"
                />
              </div>
              <span><?php echo $email; ?></span>
            </a>
          </div>
        </div>
      </div>

      <!-- Logo & Social Section -->
      <div class="footer-col">
        <div class="footer_detail">
          <a href="" class="footer-logo">ELBARAKA</a>
          <p class="footer-tagline">Cuisine authentique et savoureuse</p>
          <div class="footer_social">
            <?php if ($facebook): ?>
              <a
                href="<?php echo $facebook; ?>"
                target="_blank"
                aria-label="Facebook"
              >
                <img
                  src="icons/facebook.png"
                  alt="Facebook icon"
                  style="width: 22px"
                />
              </a>
            <?php endif; ?>

            <?php if ($instagram): ?>
              <a
                href="<?php echo $instagram; ?>"
                target="_blank"
                aria-label="Instagram"
              >
                <img
                  src="icons/instagram.png"
                  alt="Instagram icon"
                  style="width: 22px"
                />
              </a>
            <?php endif; ?>

            <?php if ($twitter): ?>
              <a
                href="<?php echo $twitter; ?>"
                target="_blank"
                aria-label="Twitter"
              >
                <img
                  src="icons/twitter.png"
                  alt="Twitter icon"
                  style="width: 22px"
                />
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Hours Section -->
      <div class="footer-col">
        <h4>Heures d'ouverture</h4>
        <div class="hours-container">
          <p><?php echo $hours_days; ?></p>
          <p class="hours"><?php echo $hours_time; ?></p>
        </div>
      </div>
    </div>

    <div class="footer-divider"></div>

    <div class="footer-info">
      <p>
        &copy; <span id="displayYear"><?php echo date('Y'); ?></span> ELBARAKA. Tous droits réservés.
      </p>
    </div>
  </div>
</footer>
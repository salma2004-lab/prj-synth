function addToCart(productId) {
  // Send AJAX request to add item to cart
  fetch('update_cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      product_id: productId,
      quantity: 1,
      action: 'update'
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Show notification
        showCartNotification('Produit ajouté au panier!');

        // Update cart count in nav if it exists
        updateCartCount(data.cart);
      } else {
        alert('Erreur lors de l\'ajout au panier');
      }
    });
}

function showCartNotification(message) {
  // Create notification element
  const notification = document.createElement('div');
  notification.className = 'cart-notification';

  const notificationContent = `
        <div class="notification-icon">
            <img src="icons/check.png" alt="Success">
        </div>
        <div class="notification-message">${message}</div>
    `;

  notification.innerHTML = notificationContent;
  document.body.appendChild(notification);

  // Show notification with animation
  setTimeout(() => {
    notification.classList.add('show');
  }, 10);

  // Hide after 3 seconds
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

function updateCartCount(cart) {
  const cartCountElement = document.querySelector('.cart-count');
  if (cartCountElement) {
    const itemCount = Object.values(cart).reduce((sum, qty) => sum + parseInt(qty), 0);
    cartCountElement.textContent = itemCount;
    cartCountElement.style.display = itemCount > 0 ? 'flex' : 'none';
  }
}
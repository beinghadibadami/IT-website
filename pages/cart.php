<?php
// Handle Cart Actions
$cartToastMessage = '';
$cartToastType = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item'])) {
        removeFromCart($_POST['remove_item']);
        $cartToastMessage = 'Item removed from cart';
        $cartToastType = 'warning';
    }
    if (isset($_POST['update_qty'])) {
        $id = $_POST['item_id'];
        $qty = intval($_POST['qty']);
        $action = $_POST['update_qty'];

        if ($action === 'increase') {
            updateCartQuantity($id, $qty + 1);
        } elseif ($action === 'decrease') {
            updateCartQuantity($id, max(1, $qty - 1));
        }

        $cartToastMessage = 'Cart updated';
        $cartToastType = 'success';
    }
    if (isset($_POST['clear_cart'])) {
        clearCart();
        $cartToastMessage = 'Cart cleared';
        $cartToastType = 'warning';
    }
}

// Also show toast when redirected after Buy Now
if (isset($_GET['added']) && !$cartToastMessage) {
    $cartToastMessage = 'Item added to cart';
    $cartToastType = 'success';
}

$cartItems = getCart();
$total = getCartTotal();
$currentUser = function_exists('auth_current_user') ? auth_current_user() : null;

?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold mb-0">Your Cart</h1>
        <span class="text-muted">Review your items before checkout</span>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="cart-empty text-center py-5 d-flex flex-column justify-content-center align-items-center" 
     style="min-height: 70vh;">
    <div class="cart-empty-icon mb-4">
        <div class="icon-circle d-flex align-items-center justify-content-center mx-auto" 
             style="width: 100px; height: 100px; border-radius: 50%; background-color: #f0f0f0;">
            <i class="fas fa-shopping-cart" style="font-size: 2.5rem; color: #6c757d;"></i>
        </div>
    </div>
    <br>
    <h3 class="fw-bold mb-2">Your cart is empty</h3>
    <br>
    <p class="text-muted mb-4" style="max-width: 500px;">Looks like you haven't added any templates yet. Explore our collection and find the perfect design for your next project.</p>
    <br>
    <a href="index.php?page=templates" class="btn btn-dark btn-lg rounded-3 px-5 fw-bold">
        Browse Templates
    </a>
</div>
    <?php else: ?>
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Cart Items (<?php echo getCartCount(); ?>)</h5>
                    </div>
                    <div class="card-body p-0">

                        <?php foreach ($cartItems as $id => $qty):
                            $item = getTemplateById($id);
                            if (!$item)
                                continue;
                            ?>
                            <div class="cart-item p-4 border-bottom bg-light">
                                <div class="row align-items-center">

                                    <div class="col-md-2">
                                        <img src="<?php echo $item['images'][0]; ?>"
                                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                                            class="img-fluid rounded-3 shadow-sm" style="max-height: 72px; object-fit: cover;">

                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="fw-bold md-4"><?php echo htmlspecialchars($item['name']); ?></h5>
                                        <p class="text-muted small mb-0">Single License</p>
                                    </div>
                                    <div class="col-md-3">
                                        <form method="POST" class="d-flex align-items-center">
                                            <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="qty" value="<?php echo $qty; ?>">

                                            <button type="submit" name="update_qty" value="decrease"
                                                class="btn btn-dark btn-sm rounded-1"
                                                style="width: 30px; height: 30px; padding: 0;">
                                                <i class="fas fa-minus small"></i>
                                            </button>

                                            <span class="mx-3 fw-bold"><?php echo $qty; ?></span>

                                            <button type="submit" name="update_qty" value="increase"
                                                class="btn btn-dark btn-sm rounded-1"
                                                style="width: 30px; height: 30px; padding: 0;">
                                                <i class="fas fa-plus small"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="fw-bold h5 mb-2">₹<?php echo number_format($item['price'] * $qty, 2); ?>
                                        </div>
                                        <form method="POST">
                                            <input type="hidden" name="remove_item" value="<?php echo $id; ?>">
                                            <button type="submit" class="btn btn-dark btn-sm rounded-1"
                                                style="width: 30px; height: 30px; padding: 0;">
                                                <i class="fas fa-times small"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer bg-white p-4">
                        <div class="d-flex justify-content-between align-items-center cart-actions">

                            <form method="POST">
                                <input type="hidden" name="clear_cart" value="1">
                                <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3">
                                    Clear Cart
                                </button>
                            </form>
                             <?php echo "<br>"?>
                            <a href="index.php?page=templates"
                                class="btn btn-dark btn-sm rounded-3 px-3 text-decoration-none">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 100px; z-index: 1;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Order Summary</h4>

                        <div class="d-flex justify-content-between mb-3">
                             <?php echo "<br>"?>
                            <span class="text-muted">Subtotal</span><br>
                            <span class="fw-bold">₹<?php echo number_format($total, 2); ?></span>
                        </div>

                        <hr class="my-4 border-secondary opacity-10">

                        <!-- <div class="d-flex justify-content-between mb-4">
                             <?php echo "<br>"?>
                            <span class="h5 fw-bold">Total</span>
                            <span class="h4 fw-bold text-dark">₹<?php echo number_format($total, 2); ?></span>
                        </div> -->

                        <!-- Checkout Form -->
                        <?php if ($currentUser): ?>
                            <form action="payment/process.php" method="POST">
                                <input type="hidden" name="service" value="Cart Checkout">
                                <input type="hidden" name="amount" value="<?php echo $total; ?>">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($currentUser['full_name']); ?>">
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>">
                                <input type="hidden" name="phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>">

                                <div class="alert alert-danger small mb-3">
                                    After successful payment, your templates will be available in the "My Account" section.
                                </div>

                                <!-- <div class="form-group mb-4">
    <label class="mb-2 fw-semibold">Select Payment Gateway</label>
    <div class="gateway-cards">
        <label class="gateway-card">
    <input type="radio" name="payment_gateway" value="payu" checked>
    <span class="custom-radio"></span>
    <div class="gateway-logo-center">
        <img src="/assets/img/payu-logo.png" alt="PayU" class="gateway-logo">
    </div>
</label>
        <label class="gateway-card">
    <input type="radio" name="payment_gateway" value="hdfc_smart_gateway">
    <span class="custom-radio"></span>
    <div class="gateway-logo-center">
        <img src="/assets/img/hdfc-logo.png" alt="HDFC SmartPay" class="gateway-logo">
    </div>
</label>
    </div> -->
</div>
<button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow-sm mb-1">
    Proceed to Payment
</button>
<style>
.gateway-cards {
  display: flex;
  flex-direction: column;
  gap: 18px;
}
.gateway-card {
  display: flex;
  align-items: center;
  border: 2px solid #aaa;
  border-radius: 16px;
  padding: 18px 22px;
  cursor: pointer;
  position: relative;
  transition: border-color 0.2s;
  background: #fff;
}
.gateway-card input[type="radio"] {
  opacity: 0;
  position: absolute;
}
.gateway-card .custom-radio {
  width: 22px;
  height: 22px;
  border: 2px solid #222;
  border-radius: 50%;
  margin-right: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
}
.gateway-card input[type="radio"]:checked + .custom-radio::after {
  content: '';
  display: block;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #222;
}
.gateway-logo-center {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 80px;
}
.gateway-card .gateway-logo {
  width: 80px;
  height: 48px;
  object-fit: contain;
  margin: 0;
}
.gateway-card .gateway-name {
  font-size: 1.1rem;
  font-weight: 500;
  letter-spacing: 0.03em;
  color: #222;
}
.gateway-card input[type="radio"]:checked ~ .gateway-name {
  font-weight: 700;
  color: #007bff;
}
.gateway-card input[type="radio"]:checked ~ .custom-radio {
  border-color: #007bff;
}
</style>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-danger small mb-3">
                                Please login to complete your purchase.
                            </div>
                            <a href="index.php?page=login" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow-sm mb-1">
                                Login to Checkout
                            </a>
                        <?php endif; ?>

                        <div class="mt-4">
                            <!-- <h6 class="fw-bold mb-2">Secure Checkout</h6> -->
                             <?php echo "<br>"?>
                            <p class="text-muted small mb-0">We use secure payment processing to ensure your information is
                                always protected.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($cartToastMessage)): ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            if (typeof showToast === 'function') {
                showToast('<?php echo addslashes($cartToastMessage); ?>', '<?php echo $cartToastType; ?>');
            }
        });
    </script>
<?php endif; ?>

<style>
    .cart-item:last-child {
        border-bottom: none !important;
    }
</style>
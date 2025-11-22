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
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold mb-0">Your Cart</h1>
        <span class="text-muted">Review your items before checkout</span>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5">
            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                    style="width: 100px; height: 100px;">
                    <i class="fas fa-shopping-cart fa-3x text-muted opacity-50"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark mb-3">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added any templates to your cart yet.<br>Find the perfect
                template for your project!</p>
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
                                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($item['name']); ?></h5>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <form method="POST">
                                <input type="hidden" name="clear_cart" value="1">
                                <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3">
                                    Clear Cart
                                </button>
                            </form>
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
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">₹<?php echo number_format($total, 2); ?></span>
                        </div>

                        <hr class="my-4 border-secondary opacity-10">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total</span>
                            <span class="h4 fw-bold text-dark">₹<?php echo number_format($total, 2); ?></span>
                        </div>

                        <!-- Checkout Form -->
                        <form action="payment/process.php" method="POST">
                            <input type="hidden" name="service" value="Cart Checkout">
                            <input type="hidden" name="amount" value="<?php echo $total; ?>">

                            <div class="alert alert-danger small mb-3">
                                After Successful Payment! Download your Templates from "My Account" Section.
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold shadow-sm mb-1">
                                Proceed to Checkout With PayU
                            </button>
                        </form>

                        <div class="mt-4">
                            <h6 class="fw-bold mb-2">Secure Checkout</h6>
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
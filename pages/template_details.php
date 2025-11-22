<?php
$templateId = $_GET['id'] ?? '';
$template = getTemplateById($templateId);

if (!$template) {
    echo '<div class="container my-5"><div class="alert alert-danger">Template not found. <a href="index.php?page=templates">Browse all templates</a></div></div>';
    return;
}
?>

<div class="container my-5">
    <?php if (isset($_GET['added'])): ?>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                if (typeof showToast === 'function') {
                    showToast('Item added to cart successfully!', 'success');
                }
            });
        </script>
    <?php endif; ?>

    <div class="row g-5">
        <div class="col-lg-8">
            <!-- Main Image -->
            <div class="template-gallery mb-5">
                <div class="main-image-wrapper mb-3 rounded-3 overflow-hidden shadow-sm border">
                    <img src="<?php echo $template['images'][0]; ?>"
                        alt="<?php echo htmlspecialchars($template['name']); ?>" id="mainImage" class="img-fluid w-100">
                </div>
                <div class="thumbnails d-flex gap-3 overflow-auto pb-2">
                    <?php foreach ($template['images'] as $img): ?>
                        <div class="thumbnail rounded-3 overflow-hidden border"
                            onclick="document.getElementById('mainImage').src='<?php echo $img; ?>'">
                            <img src="<?php echo $img; ?>" alt="Thumbnail" class="img-fluid">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Description -->
            <!-- <div class="template-content">
                <h3 class="mb-4 fw-bold">About this Template</h3>
                <p class="lead text-muted mb-5"><?php echo htmlspecialchars($template['description']); ?></p>

                <h4 class="mb-4 fw-bold">Key Features</h4>
                <div class="row g-3">
                    <?php foreach ($template['features'] as $feature): ?>
                        <div class="col-md-6">
                            <div class="feature-item d-flex align-items-center p-3 rounded-3 bg-light">
                                <i class="fas fa-check-circle text-primary me-3 fa-lg"></i>
                                <span class="fw-medium"><?php echo htmlspecialchars($feature); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div> -->
        </div>

        <div class="col-lg-4">
    <div class="template-sidebar" style="top: 100px; z-index: 1;">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <span class="badge bg-primary-subtle text-primary border-primary-subtle px-3 py-2 rounded-pill mb-3 d-inline-block">
                    <?php echo $CATEGORIES[$template['category_slug']] ?? 'Template'; ?>
                </span>

                <h1 class="h3 fw-bold mb-1"><?php echo htmlspecialchars($template['name']); ?></h1>
                <p class="text-muted mb-3">Barber Shop</p>

                <div class="d-flex align-items-baseline mb-5"> 
                    <span class="h2 fw-bold me-2">₹<?php echo number_format($template['price'], 2); ?></span>
                </div>

                <form method="POST" class="mb-5">
                    <div class="d-grid">
                        <button type="submit" name="buy_now" value="1"
                            class="btn btn-primary btn-lg fw-semibold rounded-3">
                            Buy Now
                        </button>
                        <button type="submit" name="add_to_cart" value="1"
                            class="btn btn-outline-dark btn-lg fw-semibold rounded-3 mt-2"> <i class="fas fa-cart-plus me-2"></i> Add to Cart
                        </button>
                    </div>
                </form>

                <h5 class="fw-bold mb-3">Template Features</h5>
                <ul class="list-unstyled mb-5"> 
                    <?php foreach ($template['features'] as $feature): ?>
                        <li class="d-flex align-items-start mb-2">
                            <span><?php echo htmlspecialchars($feature); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="row small text-muted">
                    <div class="col-6 mb-2">
                        <div class="fw-semibold">File Format</div>
                        <div><?php echo htmlspecialchars($template['file_format']); ?></div>
                    </div>
                    </div>
            </div>
            <div class="card-footer bg-light p-3 text-center small text-muted">
                <i class="fas fa-lock me-1"></i> Secure payment via PayU
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<style>
    .thumbnail {
        width: 100px;
        height: 70px;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.2s ease;
    }

    .thumbnail:hover {
        opacity: 1;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .feature-item {
        transition: transform 0.2s;
    }

    .feature-item:hover {
        transform: translateX(5px);
    }

    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .border-primary-subtle {
        border-color: rgba(13, 110, 253, 0.2) !important;
    }
</style>
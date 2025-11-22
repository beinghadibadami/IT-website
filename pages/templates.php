<?php
// templates.php
?>
<div class="page-header">
    <div class="container">
        <h1>Find the Perfect Template for Your Next Project</h1>
        <p>Thousands of high-quality templates created by world-class designers</p>
    </div>
</div>

<div class="container my-5">
    <!-- Search and Filter -->
    <div class="search-filter-container mb-5">
        <form action="index.php" method="GET" class="search-form">
            <input type="hidden" name="page" value="templates">
            <div class="search-input-group">
                <input type="text" name="q" placeholder="Search for templates..."
                    value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                <button type="submit" class="btn btn-primary">Search Templates</button>
            </div>
        </form>
    </div>

    <!-- Categories -->
    <div class="categories-section mb-5 text-center">
        <h2 class="section-title mb-2">Browse by Category</h2>
        <p class="section-subtitle mb-4">Find the perfect template for your specific needs</p>

        <div class="categories-grid">
            <a href="index.php?page=templates"
                class="category-pill <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
                All Categories
            </a>
            <?php foreach ($CATEGORIES as $slug => $name): ?>
                <a href="index.php?page=templates&category=<?php echo $slug; ?>"
                    class="category-pill <?php echo (isset($_GET['category']) && $_GET['category'] === $slug) ? 'active' : ''; ?>">
                    <?php echo $name; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!isset($_GET['category']) && !isset($_GET['q'])): ?>
        <!-- Featured Templates -->
        <div class="featured-section mb-5">
            <h2 class="section-title mb-4">Featured Templates</h2>
            <div class="templates-grid">
                <?php
                $featuredTemplates = getFeaturedTemplates();
                foreach ($featuredTemplates as $template):
                    ?>
                    <div class="template-card featured-card">
                        <div class="template-image">
                            <img src="<?php echo $template['images'][0]; ?>"
                                alt="<?php echo htmlspecialchars($template['name']); ?>">
                            <div class="template-overlay">
                                <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>"
                                    class="btn btn-light btn-sm">View Details</a>
                            </div>
                            <div class="featured-badge">Featured</div>
                        </div>
                        <div class="template-info">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="badge badge-light"><?php echo $CATEGORIES[$template['category_slug']] ?? 'Template'; ?></span>
                                <div class="rating">
                                    <i class="fas fa-star text-warning"></i>
                                    <span><?php echo $template['rating']; ?></span>
                                </div>
                            </div>
                            <h3 class="template-title">
                                <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>">
                                    <?php echo htmlspecialchars($template['name']); ?>
                                </a>
                            </h3>
                            <div class="template-footer mt-3 d-flex justify-content-between align-items-center">
                                <span class="price">₹<?php echo number_format($template['price'], 2); ?></span>
                                <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>"
                                    class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr class="my-5">
    <?php endif; ?>

    <!-- All Templates Grid -->
    <h2 class="section-title mb-4">
        <?php echo isset($_GET['category']) ? $CATEGORIES[$_GET['category']] : 'All Templates'; ?></h2>
    <div class="templates-grid">
        <?php
        $category = $_GET['category'] ?? 'all';
        $search = $_GET['q'] ?? '';

        $templates = getTemplatesByCategory($category);

        if (!empty($search)) {
            $templates = array_filter($templates, function ($t) use ($search) {
                return stripos($t['name'], $search) !== false || stripos($t['description'], $search) !== false;
            });
        }

        if (empty($templates)): ?>
            <div class="no-results">
                <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                <h3>No templates found</h3>
                <p>Try adjusting your search or filter to find what you're looking for.</p>
                <a href="index.php?page=templates" class="btn btn-secondary mt-3">View All Templates</a>
            </div>
        <?php else: ?>
            <?php foreach ($templates as $template): ?>
                <div class="template-card">
                    <div class="template-image">
                        <img src="<?php echo $template['images'][0]; ?>"
                            alt="<?php echo htmlspecialchars($template['name']); ?>">
                        <div class="template-overlay">
                            <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>"
                                class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                    <div class="template-info">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span
                                class="badge badge-light"><?php echo $CATEGORIES[$template['category_slug']] ?? 'Template'; ?></span>
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <span><?php echo $template['rating']; ?></span>
                            </div>
                        </div>
                        <h3 class="template-title">
                            <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>">
                                <?php echo htmlspecialchars($template['name']); ?>
                            </a>
                        </h3>
                        <div class="template-footer mt-3 d-flex justify-content-between align-items-center">
                            <span class="price">₹<?php echo number_format($template['price'], 2); ?></span>
                            <a href="index.php?page=template_details&id=<?php echo $template['id']; ?>"
                                class="btn btn-outline-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .search-filter-container {
        max-width: 600px;
        margin: -70px auto 40px;
        position: relative;
        z-index: 10;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .search-input-group {
        display: flex;
        gap: 10px;
    }

    .search-input-group input {
        flex: 1;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        font-size: 1rem;
    }

    .categories-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .category-pill {
        padding: 10px 20px;
        background: #f8f9fa;
        border-radius: 50px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .category-pill:hover,
    .category-pill.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
    }

    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .template-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .template-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .template-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .template-card:hover .template-image img {
        transform: scale(1.1);
    }

    .template-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .template-card:hover .template-overlay {
        opacity: 1;
    }

    .template-info {
        padding: 20px;
    }

    .template-title {
        font-size: 1.1rem;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .template-title a {
        color: #333;
        text-decoration: none;
    }

    .price {
        font-weight: 700;
        font-size: 1.2rem;
        color: #333;
    }

    .badge-light {
        background: #f0f2f5;
        color: #666;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .featured-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ffc107;
        color: #000;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.8rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 50px;
        background: #f9f9f9;
        border-radius: 10px;
    }
</style>
<?php
require_once 'includes/db.php';

$pdo = getDbConnection();

if (!$pdo) {
    die("Could not connect to the database.\n");
}

try {
    // Create Categories Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (
        slug VARCHAR(50) PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    )");

    // Create Templates Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS templates (
        id VARCHAR(50) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category_slug VARCHAR(50) REFERENCES categories(slug),
        price DECIMAL(10, 2) NOT NULL,
        description TEXT,
        features TEXT, -- JSON stored as text
        images TEXT, -- JSON stored as text
        author VARCHAR(100),
        rating DECIMAL(3, 1),
        sales INT DEFAULT 0,
        published VARCHAR(50),
        file_format VARCHAR(100),
        is_featured BOOLEAN DEFAULT FALSE
    )");

    echo "Tables created successfully.\n";

    // Insert Categories
    $categories = [
        'website-templates' => 'Website Templates',
        'ecommerce-templates' => 'eCommerce Templates',
        'app-ui-kits' => 'App UI Kits & Templates',
        'cms-templates' => 'CMS Templates',
        'page-builders' => 'Page Builders & Layouts',
        'business-assets' => 'Business Assets',
        'data-visualization' => 'Data Visualization',
        'web-templates' => 'Web Templates',
        'document-templates' => 'Document Templates',
        'educational-templates' => 'Educational Templates',
        'marketing-templates' => 'Marketing Templates',
        'design-resources' => 'Design Resources'
    ];

    $stmt = $pdo->prepare("INSERT INTO categories (slug, name) VALUES (:slug, :name) ON CONFLICT (slug) DO NOTHING");
    foreach ($categories as $slug => $name) {
        $stmt->execute([':slug' => $slug, ':name' => $name]);
    }
    echo "Categories inserted.\n";

    // Insert Templates
    $templates = [
        [
            'id' => 'tpl_001',
            'name' => 'Barber Shop',
            'category' => 'website-templates',
            'price' => 10000,
            'description' => 'A modern and stylish HTML5 template for salon and barber websites. Features include appointment booking form, service catalog, and gallery.',
            'features' => json_encode([
                'Service catalog with pricing and duration',
                'Appointment booking form with time slots',
                'Instagram feed integration for style previews',
                'Dark/retro theme with bold typography'
            ]),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=800&q=80',
                'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=800&q=80',
                'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=800&q=80'
            ]),
            'author' => 'JINCY MATHEW',
            'rating' => 3.5,
            'sales' => 0,
            'published' => '6/9/2025',
            'file_format' => 'HTML, CSS, JavaScript, Bootstrap',
            'is_featured' => true
        ],
        [
            'id' => 'tpl_002',
            'name' => 'Office Master',
            'category' => 'website-templates',
            'price' => 11000,
            'description' => 'Professional corporate website template suitable for agencies, consulting firms, and businesses.',
            'features' => json_encode(['Responsive Design', 'Contact Form', 'About Us Page', 'Team Section']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
                'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&q=80'
            ]),
            'author' => 'JINCY MATHEW',
            'rating' => 4.0,
            'sales' => 12,
            'published' => '1/10/2025',
            'file_format' => 'HTML, CSS, JS',
            'is_featured' => false
        ],
        [
            'id' => 'tpl_003',
            'name' => 'Medlife Master',
            'category' => 'website-templates',
            'price' => 10000,
            'description' => 'Clean and trustworthy template for medical clinics, hospitals, and doctors.',
            'features' => json_encode(['Appointment Booking', 'Doctor Profiles', 'Department Services', 'Emergency Contacts']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80',
                'https://images.unsplash.com/photo-1516549655169-df83a092fc43?w=800&q=80'
            ]),
            'author' => 'JINCY MATHEW',
            'rating' => 4.0,
            'sales' => 5,
            'published' => '15/8/2025',
            'file_format' => 'HTML, Bootstrap',
            'is_featured' => true
        ],
        [
            'id' => 'tpl_004',
            'name' => 'Landscape Master',
            'category' => 'website-templates',
            'price' => 12000,
            'description' => 'Beautiful template for landscaping, gardening, and outdoor services.',
            'features' => json_encode(['Portfolio Gallery', 'Service Request Form', 'Testimonials', 'Green Theme']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1558904541-efa843a96f01?w=800&q=80',
                'https://images.unsplash.com/photo-1585320806297-117951f4c483?w=800&q=80'
            ]),
            'author' => 'JINCY MATHEW',
            'rating' => 4.5,
            'sales' => 8,
            'published' => '20/9/2025',
            'file_format' => 'HTML, CSS',
            'is_featured' => false
        ],
        [
            'id' => 'tpl_005',
            'name' => 'Shopify Pro',
            'category' => 'ecommerce-templates',
            'price' => 15000,
            'description' => 'High-converting eCommerce template optimized for sales and user experience.',
            'features' => json_encode(['Product Filtering', 'Quick View', 'Cart Drawer', 'Mobile Optimized']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1556742049-0cfed4f7a07d?w=800&q=80',
                'https://images.unsplash.com/photo-1556742102-803317507187?w=800&q=80'
            ]),
            'author' => 'DesignHero',
            'rating' => 4.8,
            'sales' => 45,
            'published' => '10/10/2025',
            'file_format' => 'Shopify Theme',
            'is_featured' => true
        ],
        [
            'id' => 'tpl_006',
            'name' => 'Fashion Store',
            'category' => 'ecommerce-templates',
            'price' => 14000,
            'description' => 'Trendy fashion store template with lookbook features and instagram integration.',
            'features' => json_encode(['Lookbook', 'Size Guide', 'Newsletter Popup', 'Social Sharing']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80',
                'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800&q=80'
            ]),
            'author' => 'StyleWorks',
            'rating' => 4.2,
            'sales' => 22,
            'published' => '5/11/2025',
            'file_format' => 'HTML, CSS, JS',
            'is_featured' => false
        ],
        [
            'id' => 'tpl_007',
            'name' => 'Mobile App UI Kit',
            'category' => 'app-ui-kits',
            'price' => 8000,
            'description' => 'Comprehensive UI kit for mobile app design with over 50 screens.',
            'features' => json_encode(['50+ Screens', 'Light & Dark Mode', 'Figma Source', 'Vector Icons']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80',
                'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&q=80'
            ]),
            'author' => 'UI Master',
            'rating' => 4.9,
            'sales' => 150,
            'published' => '1/12/2025',
            'file_format' => 'Figma, Sketch',
            'is_featured' => true
        ],
        [
            'id' => 'tpl_008',
            'name' => 'Dashboard Admin',
            'category' => 'cms-templates',
            'price' => 12500,
            'description' => 'Powerful admin dashboard template with charts, tables, and widgets.',
            'features' => json_encode(['Analytics Charts', 'User Management', 'Data Tables', 'Notifications']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80',
                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80'
            ]),
            'author' => 'AdminPro',
            'rating' => 4.6,
            'sales' => 88,
            'published' => '15/1/2026',
            'file_format' => 'HTML, Bootstrap 5',
            'is_featured' => false
        ],
        [
            'id' => 'tpl_009',
            'name' => 'Corporate Presentation',
            'category' => 'business-assets',
            'price' => 5000,
            'description' => 'Professional presentation template for business meetings and pitches.',
            'features' => json_encode(['30 Unique Slides', 'Editable Charts', 'Master Slides', '16:9 Ratio']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=800&q=80',
                'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=80'
            ]),
            'author' => 'SlideDeck',
            'rating' => 4.3,
            'sales' => 200,
            'published' => '20/2/2026',
            'file_format' => 'PowerPoint, Keynote',
            'is_featured' => false
        ],
        [
            'id' => 'tpl_010',
            'name' => 'SEO Report Template',
            'category' => 'marketing-templates',
            'price' => 4500,
            'description' => 'Comprehensive SEO reporting template for agencies and freelancers.',
            'features' => json_encode(['Traffic Analysis', 'Keyword Rankings', 'Backlink Profile', 'Competitor Analysis']),
            'images' => json_encode([
                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80',
                'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=80'
            ]),
            'author' => 'MarketerPro',
            'rating' => 4.4,
            'sales' => 60,
            'published' => '10/3/2026',
            'file_format' => 'PDF, Word',
            'is_featured' => false
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO templates (id, name, category_slug, price, description, features, images, author, rating, sales, published, file_format, is_featured) 
        VALUES (:id, :name, :category, :price, :description, :features, :images, :author, :rating, :sales, :published, :file_format, :is_featured)
        ON CONFLICT (id) DO NOTHING");

    foreach ($templates as $tpl) {
        $stmt->execute([
            ':id' => $tpl['id'],
            ':name' => $tpl['name'],
            ':category' => $tpl['category'],
            ':price' => $tpl['price'],
            ':description' => $tpl['description'],
            ':features' => $tpl['features'],
            ':images' => $tpl['images'],
            ':author' => $tpl['author'],
            ':rating' => $tpl['rating'],
            ':sales' => $tpl['sales'],
            ':published' => $tpl['published'],
            ':file_format' => $tpl['file_format'],
            ':is_featured' => $tpl['is_featured'] ? 'true' : 'false'
        ]);
    }
    echo "Templates inserted.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
?>
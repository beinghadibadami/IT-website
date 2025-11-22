<?php
$CATEGORIES = [
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

$TEMPLATES = [
    [
        'id' => 'tpl_001',
        'name' => 'Barber Shop',
        'category_slug' => 'website-templates', 
        'price' => 10000,
        'description' => 'A modern and stylish HTML5 template for salon and barber websites. Features include appointment booking form, service catalog, and gallery.',
        'features' => [
            'Service catalog with pricing and duration',
            'Appointment booking form with time slots',
            'Instagram feed integration for style previews',
            'Dark/retro theme with bold typography'
        ],
        'images' => [
            'images/barber-1.png',
            'images/barber-2.png',
            'images/barber-3.png'
        ],
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
        'category_slug' => 'website-templates',
        'price' => 11000,
        'description' => 'Professional corporate website template suitable for agencies, consulting firms, and businesses.',
        'features' => ['Responsive Design', 'Contact Form', 'About Us Page', 'Team Section'],
        'images' => [
            'images/prst-1.png',
            'images/prst-2.png',
            'images/prst-3.png'
        ],
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
        'category_slug' => 'website-templates',
        'price' => 10000,
        'description' => 'Clean and trustworthy template for medical clinics, hospitals, and doctors.',
        'features' => ['Appointment Booking', 'Doctor Profiles', 'Department Services', 'Emergency Contacts'],
        'images' => [
            'images/med-1.png',
            'images/med-2.png',
            'images/med-3.png'
        ],
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
        'category_slug' => 'website-templates',
        'price' => 12000,
        'description' => 'Beautiful template for landscaping, gardening, and outdoor services.',
        'features' => ['Portfolio Gallery', 'Service Request Form', 'Testimonials', 'Green Theme'],
        'images' => [
            'images/land-1.png',
            'images/land-2.png',
            'images/land-3.png'
        ],
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
        'category_slug' => 'ecommerce-templates',
        'price' => 15000,
        'description' => 'High-converting eCommerce template optimized for sales and user experience.',
        'features' => ['Product Filtering', 'Quick View', 'Cart Drawer', 'Mobile Optimized'],
        'images' => [
            'images/shop-1.png',
            'images/shop2.png',
            'images/shop3.png'
        ],
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
        'category_slug' => 'ecommerce-templates',
        'price' => 14000,
        'description' => 'Trendy fashion store template with lookbook features and instagram integration.',
        'features' => ['Lookbook', 'Size Guide', 'Newsletter Popup', 'Social Sharing'],
        'images' => [
            'images/fash-1.png',
            'images/fash-2.png',
            'images/fash-3.png'
        ],
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
        'category_slug' => 'app-ui-kits',
        'price' => 8000,
        'description' => 'Comprehensive UI kit for mobile app design with over 50 screens.',
        'features' => ['50+ Screens', 'Light & Dark Mode', 'Figma Source', 'Vector Icons'],
        'images' => [
            'images/mob-1.png'
        ],
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
        'category_slug' => 'cms-templates',
        'price' => 12500,
        'description' => 'Powerful admin dashboard template with charts, tables, and widgets.',
        'features' => ['Analytics Charts', 'User Management', 'Data Tables', 'Notifications'],
        'images' => [
            'images/dash-1.png',
            'images/dash-2.png',
            'images/dash-3.png'
        ],
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
        'category_slug' => 'business-assets',
        'price' => 5000,
        'description' => 'Professional presentation template for business meetings and pitches.',
        'features' => ['30 Unique Slides', 'Editable Charts', 'Master Slides', '16:9 Ratio'],
        'images' => [
            'images/prst-1.png',
            'images/prst-2.png',
            'images/prst-3.png'
        ],
        'author' => 'SlideDeck',
        'rating' => 4.3,
        'sales' => 200,
        'published' => '20/2/2026',
        'file_format' => 'PowerPoint, Keynote',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_10',
        'name' => 'SEO Report Template',
        'category_slug' => 'marketing-templates',
        'price' => 4500,
        'description' => 'Comprehensive SEO reporting template for agencies and freelancers.',
        'features' => ['Traffic Analysis', 'Keyword Rankings', 'Backlink Profile', 'Competitor Analysis'],
        'images' => [
            'images/seo-1.png',
            'images/seo-2.png',
            'images/seo-3.png'
        ],
        'author' => 'MarketerPro',
        'rating' => 4.4,
        'sales' => 60,
        'published' => '10/3/2026',
        'file_format' => 'PDF, Word',
        'is_featured' => false
    ]
];

function getTemplateById($id)
{
    global $TEMPLATES;
    foreach ($TEMPLATES as $template) {
        if ($template['id'] === $id) {
            return $template;
        }
    }
    return null;
}

function getTemplatesByCategory($category)
{
    global $TEMPLATES;
    if ($category === 'all' || empty($category)) {
        return $TEMPLATES;
    }
    return array_filter($TEMPLATES, function ($t) use ($category) {
        return $t['category_slug'] === $category;
    });
}

function getFeaturedTemplates()
{
    global $TEMPLATES;
    return array_filter($TEMPLATES, function ($t) {
        return isset($t['is_featured']) && $t['is_featured'] === true;
    });
}
?>
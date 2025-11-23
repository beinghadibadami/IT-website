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
        'name' => 'Logo Design',
        'category_slug' => 'website-templates',
        'price' => 1000,
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
        'price' => 1500,
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
        'price' => 500,
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
        'price' => 1500,
        'description' => 'High-converting eCommerce template optimized for sales and user experience.',
        'features' => ['Product Filtering', 'Quick View', 'Cart Drawer', 'Mobile Optimized'],
        'images' => [
            'images/shop-1.png',
            'images/shop2.png',
            'images/shop 3.png'
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
        'price' => 2000,
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
        'price' => 1250,
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
    ],
    [
        'id' => 'tpl_011',
        'name' => 'Creative Agency One Page',
        'category_slug' => 'website-templates',
        'price' => 2000,
        'description' => 'Single-page creative agency website with hero section, portfolio grid and testimonials.',
        'features' => ['One-page Layout', 'Portfolio Grid', 'Client Logos', 'Contact Form'],
        'images' => [
            'images/agency1.png',
            'images/agency2.png',
            'images/agency3.png'
        ],
        'author' => 'Divine Studio',
        'rating' => 4.1,
        'sales' => 15,
        'published' => '05/04/2026',
        'file_format' => 'HTML, CSS, JavaScript',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_012',
        'name' => 'SaaS Landing Page',
        'category_slug' => 'web-templates',
        'price' => 10000,
        'description' => 'High-conversion SaaS landing page with pricing tables, FAQs and app screenshots.',
        'features' => ['Hero with CTA', 'Pricing Tables', 'FAQ Accordion', 'Testimonial Slider'],
        'images' => [
            'images/saas1.png',
            'images/saas2.png',
            'images/saas3.png'
        ],
        'author' => 'LaunchKit',
        'rating' => 4.7,
        'sales' => 70,
        'published' => '18/04/2026',
        'file_format' => 'HTML, Bootstrap 5',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_013',
        'name' => 'Portfolio Personal Site',
        'category_slug' => 'website-templates',
        'price' => 6500,
        'description' => 'Minimal personal portfolio template for designers, developers and freelancers.',
        'features' => ['About Me Section', 'Skills Timeline', 'Projects Showcase', 'Contact Form'],
        'images' => [
            'images/port-1.png',
            'images/port-2.png',
            'images/port-3.png'
        ],
        'author' => 'PixelCraft',
        'rating' => 4.5,
        'sales' => 35,
        'published' => '25/04/2026',
        'file_format' => 'HTML, CSS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_014',
        'name' => 'Restaurant & Cafe',
        'category_slug' => 'website-templates',
        'price' => 10500,
        'description' => 'Elegant restaurant template with menu, reservations and gallery sections.',
        'features' => ['Online Reservation Form', 'Food Menu Grid', 'Image Gallery', 'Google Maps'],
        'images' => [
            'images/cafe-1.png',
            'images/cafe-2.png',
            'images/cafe-3.png'
        ],
        'author' => 'GourmetThemes',
        'rating' => 4.3,
        'sales' => 28,
        'published' => '30/04/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_015',
        'name' => 'Education LMS Dashboard',
        'category_slug' => 'data-visualization',
        'price' => 1500,
        'description' => 'Analytics dashboard UI for online learning platforms and academies.',
        'features' => ['Course Analytics', 'Student Progress', 'Revenue Charts', 'Dark Mode'],
        'images' => [
            'images/dash-1.png',
            'images/dash-3.png'
        ],
        'author' => 'EduAnalytics',
        'rating' => 4.8,
        'sales' => 52,
        'published' => '07/05/2026',
        'file_format' => 'HTML, Bootstrap 5',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_016',
        'name' => 'E-book Landing Page',
        'category_slug' => 'document-templates',
        'price' => 5500,
        'description' => 'Clean landing page for promoting e-books, guides and digital downloads.',
        'features' => ['Author Bio', 'Chapter Preview', 'Email Capture', 'Testimonials'],
        'images' => [
            'images/prst-1.png',
            'images/prst-2.png'
        ],
        'author' => 'WriteFlow',
        'rating' => 4.2,
        'sales' => 22,
        'published' => '12/05/2026',
        'file_format' => 'HTML, CSS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_017',
        'name' => 'Marketing Funnel Kit',
        'category_slug' => 'marketing-templates',
        'price' => 12500,
        'description' => 'Set of landing, thank-you and upsell pages for high-performing marketing funnels.',
        'features' => ['Lead Capture Page', 'Thank You Page', 'Upsell Page', 'Responsive Layout'],
        'images' => [
            'images/seo-1.png',
            'images/seo-2.png'
        ],
        'author' => 'GrowthStack',
        'rating' => 4.6,
        'sales' => 40,
        'published' => '20/05/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_018',
        'name' => 'Corporate Brochure Template',
        'category_slug' => 'business-assets',
        'price' => 4800,
        'description' => 'Multi-page corporate brochure for company profiles and presentations.',
        'features' => ['A4 Size Layout', 'Print Ready', 'Editable Colors', 'Vector Icons'],
        'images' => [
            'images/prst-2.png',
            'images/prst-3.png'
        ],
        'author' => 'BrandDeck',
        'rating' => 4.0,
        'sales' => 19,
        'published' => '25/05/2026',
        'file_format' => 'PowerPoint, Keynote, PDF',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_019',
        'name' => 'Medical Appointment App UI',
        'category_slug' => 'app-ui-kits',
        'price' => 9000,
        'description' => 'Mobile app UI kit for clinics and hospitals with booking and consultation flows.',
        'features' => ['Appointment Flow', 'Doctor Profiles', 'Chat Screens', 'Light & Dark Variants'],
        'images' => [
            'images/med-1.png',
            'images/med-3.png'
        ],
        'author' => 'HealthUX',
        'rating' => 4.7,
        'published' => '30/05/2026',
        'file_format' => 'Figma, XD',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_020',
        'name' => 'Fashion Lookbook Deck',
        'category_slug' => 'design-resources',
        'price' => 7200,
        'description' => 'Stylish presentation template for seasonal fashion collections and lookbooks.',
        'features' => ['Image-first Layouts', 'Editable Typography', 'Color Palettes', 'Drag & Drop Image Holders'],
        'images' => [
            'images/fash-1.png',
            'images/fash-2.png',
            'images/fash-3.png'
        ],
        'author' => 'StyleDeck',
        'rating' => 4.5,
        'sales' => 27,
        'published' => '02/06/2026',
        'file_format' => 'PowerPoint, Keynote',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_021',
        'name' => 'Online Course Landing',
        'category_slug' => 'educational-templates',
        'price' => 9500,
        'description' => 'Landing page for selling online courses with curriculum, instructor bio and pricing.',
        'features' => ['Course Curriculum', 'Instructor Bio', 'Student Testimonials', 'Pricing Plans'],
        'images' => [
            'images/edu1.png',
            'images/edu2.png'
        ],
        'author' => 'LearnFlow',
        'rating' => 4.6,
        'sales' => 38,
        'published' => '08/06/2026',
        'file_format' => 'HTML, Bootstrap 5',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_022',
        'name' => 'School Website Template',
        'category_slug' => 'educational-templates',
        'price' => 8800,
        'description' => 'Modern school website with admissions, classes, events and staff pages.',
        'features' => ['Admissions Page', 'Class Timetable', 'Events Calendar', 'Faculty Profiles'],
        'images' => [
            'images/edu1.png',
            'images/edu2.png'
        ],
        'author' => 'CampusWeb',
        'rating' => 4.3,
        'sales' => 24,
        'published' => '12/06/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_023',
        'name' => 'University Program Brochure',
        'category_slug' => 'educational-templates',
        'price' => 5200,
        'description' => 'Brochure-style template for promoting university programs and departments.',
        'features' => ['Program Overview', 'Curriculum Outline', 'Alumni Stories', 'Contact Details'],
        'images' => [
            'images/edu2.png'
        ],
        'author' => 'AcademiaDeck',
        'rating' => 4.1,
        'sales' => 18,
        'published' => '15/06/2026',
        'file_format' => 'PDF, PowerPoint',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_024',
        'name' => 'Drag & Drop Page Builder Kit',
        'category_slug' => 'page-builders',
        'price' => 7000,
        'description' => 'Block-based layout kit with reusable sections for landing pages and marketing sites.',
        'features' => ['Header & Hero Blocks', 'Pricing Sections', 'FAQ Blocks', 'Footer Variants'],
        'images' => [
            'images/saas1.png',
            'images/saas2.png',
            'images/saas3.png'
        ],
        'author' => 'LayoutLab',
        'rating' => 4.7,
        'sales' => 41,
        'published' => '18/06/2026',
        'file_format' => 'HTML, CSS',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_025',
        'name' => 'Landing Blocks Library',
        'category_slug' => 'page-builders',
        'price' => 8000,
        'description' => 'Collection of ready-to-use landing page sections for any industry.',
        'features' => ['Hero Variants', 'Feature Grids', 'CTA Sections', 'Contact Blocks'],
        'images' => [
            'images/fashion1.png',
            'images/fashion2.png',
            'images/fashion3.png'
        ],
        'author' => 'BlockForge',
        'rating' => 4.4,
        'sales' => 29,
        'published' => '20/06/2026',
        'file_format' => 'HTML, Figma',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_026',
        'name' => 'Medical Info Microsite',
        'category_slug' => 'educational-templates',
        'price' => 7800,
        'description' => 'Informational microsite template for hospitals and health campaigns.',
        'features' => ['Condition Library', 'Doctor Profiles', 'Appointment CTA', 'FAQ Section'],
        'images' => [
            'images/medical1.png',
            'images/medical2.png',
            'images/medical3.png'
        ],
        'author' => 'HealthEdu',
        'rating' => 4.5,
        'sales' => 21,
        'published' => '22/06/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_027',
        'name' => 'Digital Marketing Agency',
        'category_slug' => 'website-templates',
        'price' => 11200,
        'description' => 'Full-service digital marketing agency site with services, case studies and lead forms.',
        'features' => ['Services Overview', 'Case Studies', 'Blog Section', 'Lead Capture Form'],
        'images' => [
            'images/agency1.png',
            'images/seo-1.png'
        ],
        'author' => 'GrowthStudio',
        'rating' => 4.4,
        'sales' => 26,
        'published' => '24/06/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_028',
        'name' => 'Fashion E‑Commerce Lookbook',
        'category_slug' => 'ecommerce-templates',
        'price' => 1400,
        'description' => 'Lookbook‑style fashion e‑commerce template with collection pages and product highlights.',
        'features' => ['Collection Pages', 'Lookbook Grid', 'Product Highlights', 'Newsletter Signup'],
        'images' => [
            'images/fashion1.png',
            'images/fashion2.png',
            'images/fashion3.png'
        ],
        'author' => 'StyleLab',
        'rating' => 4.5,
        'sales' => 31,
        'published' => '26/06/2026',
        'file_format' => 'HTML, CSS, JS',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_029',
        'name' => 'Clinic Landing Page',
        'category_slug' => 'website-templates',
        'price' => 9800,
        'description' => 'Landing page for clinics and small hospitals with services, doctors and appointment form.',
        'features' => ['Services Overview', 'Doctor Profiles', 'Appointment Form', 'Location Map'],
        'images' => [
            'images/medical1.png',
            'images/medical2.png'
        ],
        'author' => 'MediWeb',
        'rating' => 4.3,
        'sales' => 23,
        'published' => '28/06/2026',
        'file_format' => 'HTML, Bootstrap 5',
        'is_featured' => false
    ],
    [
        'id' => 'tpl_030',
        'name' => 'Startup Pitch Deck',
        'category_slug' => 'business-assets',
        'price' => 6000,
        'description' => 'Investor‑ready pitch deck template for startups to present vision, traction and roadmap.',
        'features' => ['Problem & Solution Slides', 'Market Size', 'Roadmap', 'Financial Overview'],
        'images' => [
            'images/prst-1.png',
            'images/prst-3.png'
        ],
        'author' => 'PitchCraft',
        'rating' => 4.6,
        'sales' => 34,
        'published' => '30/06/2026',
        'file_format' => 'PowerPoint, Keynote, PDF',
        'is_featured' => true
    ],
    [
        'id' => 'tpl_031',
        'name' => 'Analytics Reporting Dashboard',
        'category_slug' => 'data-visualization',
        'price' => 13800,
        'description' => 'Analytics dashboard layout for marketing and product teams with multiple KPI views.',
        'features' => ['KPI Overview', 'Channel Breakdown', 'Trend Charts', 'Custom Filters'],
        'images' => [
            'images/dash-1.png',
            'images/dash-2.png',
            'images/dash-3.png'
        ],
        'author' => 'DataForge',
        'rating' => 4.7,
        'sales' => 37,
        'published' => '02/07/2026',
        'file_format' => 'HTML, Bootstrap 5',
        'is_featured' => true
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
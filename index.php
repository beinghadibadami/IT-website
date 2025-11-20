<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$title = "TechVista - Innovative IT Solutions";

switch($page) {
    case 'services':
        $title = "Our Services - TechVista";
        break;
    case 'about':
        $title = "About Us - TechVista";
        break;
    case 'contact':
        $title = "Contact Us - TechVista";
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <?php
        switch($page) {
            case 'services':
                include 'pages/services.php';
                break;
            case 'about':
                include 'pages/about.php';
                break;
            case 'contact':
                include 'pages/contact.php';
                break;
            default:
                include 'pages/home.php';
                break;
        }
        ?>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/main.js"></script>
</body>
</html>

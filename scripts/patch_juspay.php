<?php
// scripts/patch_juspay.php

$file = __DIR__ . '/../vendor/juspay/expresscheckout-php-sdk/lib/RequestOptions.php';

if (!file_exists($file)) {
    echo "Juspay SDK RequestOptions.php not found at $file. Skipping patch.\n";
    exit(0);
}

$content = file_get_contents($file);

// The patch: add explicit nullable type hint ?IJuspayJWT
$search = 'public function __construct(IJuspayJWT $juspayJWT = null, $merchantId = null)';
$replace = 'public function __construct(?IJuspayJWT $juspayJWT = null, $merchantId = null)';

if (strpos($content, $search) !== false) {
    $newContent = str_replace($search, $replace, $content);
    file_put_contents($file, $newContent);
    echo "Successfully patched Juspay RequestOptions.php\n";
} else {
    echo "Juspay RequestOptions.php already patched or pattern not found.\n";
}

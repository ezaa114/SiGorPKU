<?php

// Initialize writeable folders and log channels when running on Vercel
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    // Create view compilation folder in writeable /tmp directory
    $viewPath = '/tmp/framework/views';
    if (!is_dir($viewPath)) {
        mkdir($viewPath, 0755, true);
    }
    
    // Override log channel to output directly to Vercel dashboard console
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

// Forward Vercel requests to normal index.php with try-catch for debugging
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1>Fatal Error during boot:</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " on line " . htmlspecialchars($e->getLine()) . "</p>";
    echo "<h2>Stack Trace:</h2>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}


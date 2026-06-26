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

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';

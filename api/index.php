<?php
/**
 * Vercel PHP Proxy / Router
 * This script routes all PHP requests to the original files in the root directory.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Simple routing map
if ($uri === '/' || $uri === '') {
    $uri = '/index.php';
}

// Security: Prevent direct access to includes folder or config folder
if (preg_match('/^\/(config|functions|includes|assets)\//', $uri)) {
    // Let static assets (css/js/images) be handled by Vercel if in /assets
    if (strpos($uri, '/assets/') === 0) {
        return false;
    }
    http_response_code(403);
    echo "403 Forbidden";
    exit;
}

$file = __DIR__ . '/..' . $uri;

// Support URLs without .php extension (common on Vercel)
if (!file_exists($file) && file_exists($file . '.php')) {
    $file .= '.php';
}

if (file_exists($file) && is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    // Very important: Set current working directory to the file's directory
    // so that relative includes work correctly.
    chdir(dirname($file));
    require $file;
} else {
    // Return false to let Vercel handle static files or return 404
    return false;
}

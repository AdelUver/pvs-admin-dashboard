<?php
declare(strict_types=1);

$host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? 'localhost')[0]);
define('IS_LOCAL', in_array($host, ['localhost', '127.0.0.1'], true));
define('PROJECT_ROOT', dirname(__DIR__)); // C:\xampp\htdocs\Uver\pvs-admin-dashboard

/* Base URL
 * Wird automatisch aus dem Ordner berechnet, in dem das Projekt liegt:
 *   XAMPP  htdocs/Uver/pvs-admin-dashboard  ->  "/Uver/pvs-admin-dashboard"
 *   Live   Webroot          ->  ""
 * Ohne Schrägstrich am Ende – alle URLs unten hängen "/..." an. */
$documentRoot = str_replace('\\', '/', (string) realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));
$projectRoot = str_replace('\\', '/', PROJECT_ROOT);

if ($documentRoot !== '' && stripos($projectRoot, $documentRoot) === 0) {
    define('BASE_URL', rtrim(substr($projectRoot, strlen($documentRoot)), '/'));
} else {
    define('BASE_URL', '');
}


/* App URL / Dashboard */
if (IS_LOCAL) {
    define('APP_URL', 'http://localhost' . BASE_URL);
} else {
    define('APP_URL', 'https://admin.private-value-society.com');
}


/* Paths (Dateisystem) */
define('CONFIG_PATH', PROJECT_ROOT . '/config');
define('BACKEND_PATH', PROJECT_ROOT . '/backend');
define('ASSETS_PATH', PROJECT_ROOT . '/assets');
define('INCLUDES_PATH', PROJECT_ROOT . '/includes');
define('FUNCTIONS_PATH', PROJECT_ROOT . '/functions');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');
define('ICONS_PATH', ASSETS_PATH . '/icons');
define('TEMPLATES_PATH', PROJECT_ROOT . '/templates');
define('PAGES_PATH', TEMPLATES_PATH . '/pages');
define('SECTIONS_PATH', TEMPLATES_PATH . '/sections');
define('DASHBOARD_MODALS_PATH', SECTIONS_PATH . '/dashboard-modals');
define('MODALS_PATH', SECTIONS_PATH . '/modals');


/* Asset URLs (Browser) */
define('CSS_URL', BASE_URL . '/assets/css');
define('JS_URL', BASE_URL . '/assets/js');
define('IMAGES_URL', BASE_URL . '/assets/images');
define('ICONS_URL', BASE_URL . '/assets/icons');
define('BACKEND_URL', BASE_URL . '/backend');

/* Project */
define('PROJECT_NAME', 'pvs-admin-dashbaord');



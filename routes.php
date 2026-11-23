<?php
declare(strict_types=1);

/* Session */
if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();

// Die angeforderte URL aus der GET-Variablen 'url' extrahieren
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';


// Die Anfrage routen
routeRequest($url);

function routeRequest(mixed $url)
{
    // Routen-Tabelle
    $routes = [
        '' => 'page-home.php',
        'dashboard' => 'page-home.php',
        'events' => 'page-home.php',
        'users' => 'page-home.php',
        'courses' => 'page-home.php',
        'profile' => 'page-home.php',
        'settings' => 'page-home.php',
        'home' => 'page-home.php',
        'login' => 'page-login.php',
        'logout' => 'page-logout.php',
        '404' => 'page-404.php'
    ];

    /* Default */
    $requestedRoute = isset($routes[$url]) ? $url : '404';


    /* Datei */
    $file = PAGES_PATH . '/' . $routes[$requestedRoute];

    /* Laden */
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    /* Fallback */
    $fallback = PAGES_PATH . '/' . $routes['404'];

    if (file_exists($fallback)) {
        require_once $fallback;
        return;
    }

    echo '404 - Seite nicht gefunden';
}

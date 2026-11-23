<?php

// Die angeforderte URL aus der GET-Variablen 'url' extrahieren
$url = isset($_GET['url']) ? $_GET['url'] : '';


// Die Anfrage routen
routeRequest($url);

function routeRequest(mixed $url)
{
    // Routen-Tabelle
    $routes = [
        'dashboard' => 'page-home.php',
        'login' => 'page-login.php',
        'logout' => 'page-logout.php',
        'events' => 'page-home.php',
        'users' => 'page-home.php',
        'profile' => 'page-home.php',
        'courses' => 'page-home.php',
        'settings' => 'page-home.php',
        '404' => 'page-404.php',
    ];

    // Standardseite, falls keine spezifische Route gefunden wird
    if ($url === '') {
        $defaultRoute = 'dashboard';
    } else {
        $defaultRoute = '404';
    }

    // Überprüfen, ob die angeforderte Route vorhanden ist
    $requestedRoute = isset($routes[$url]) ? $url : $defaultRoute;

    // Datei für die angeforderte Route laden
    $file = 'templates/pages/' . $routes[$requestedRoute];

    // Überprüfen, ob die Datei existiert
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Fehlerseite oder Weiterleitung auf die Startseite anzeigen
        $file = 'templates/pages/' . $routes[$defaultRoute];
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "404 - Seite nicht gefunden";
        }
    }
}

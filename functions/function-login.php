<?php
global $baseurl;

$allowed_routes = [
    $baseurl . '/login',
    $baseurl . '/404'
];
$currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Wenn der Benutzer nicht angemeldet ist UND die Seite nicht öffentlich zugänglich ist
if (!isset($_SESSION['userId']) && !in_array($currentRoute, $allowed_routes)) {
    header('Location: ' . $baseurl . '/login');
    exit();
}

if (!isset($_GET['url'])) {
    header('Location: ' . $baseurl . '/dashboard');
    exit();
}

?>
<?php
require_once BACKEND_PATH . '/backend-functions/dashboard.php';
require_once FUNCTIONS_PATH . '/function-db.php';

$pdo = getDB();
$userId = $_SESSION['userId'];

if (isset($_POST["loadAllEvents"])) {

    $upcomingEvents = getUpcomingEvents($pdo, 9999);
    exit();
}


//Daten


$upcomingEvents = getUpcomingEvents($pdo);

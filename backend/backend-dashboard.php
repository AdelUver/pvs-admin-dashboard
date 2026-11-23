<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/backend-functions/dashboard.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/function-db.php';

$pdo = getDB();
$userId = $_SESSION['userId'];

if (isset($_POST["loadAllEvents"])) {

    $upcomingEvents = getUpcomingEvents($pdo, 9999);
    exit();
}


//Daten


$upcomingEvents = getUpcomingEvents($pdo);

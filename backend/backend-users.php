<?php

declare(strict_types=1);

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/Uver/loginPVS/functions/function-db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Uver/loginPVS/backend/backend-functions/users.php';

$pdo = getDB();



// Benutzer muss angemeldet sein
if (!isset($_SESSION['userId'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Keine gültige Sitzung.'
    ]);

    exit();
}

$currentUserId = (int)$_SESSION['userId'];
$userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// -----------------------------------------------------
// Benutzer anzeigen
// -----------------------------------------------------
if (isset($_POST['showUser'])) {
    header('Content-Type: application/json');
    $user = getUserById($pdo, $userId);

    if (!$user) {

        echo json_encode([
            'success' => false,
            'message' => 'Benutzer nicht gefunden.'
        ]);

        exit();
    }

    echo json_encode($user);
    exit();
}

// -----------------------------------------------------
// Benutzer zum Bearbeiten laden
// -----------------------------------------------------
if (isset($_POST['updateUser']) && isset($_POST['load'])) {
    header('Content-Type: application/json');
    $user = getUserById($pdo, $userId);

    if (!$user) {

        echo json_encode([
            'success' => false,
            'message' => 'Benutzer nicht gefunden.'
        ]);

        exit();
    }

    echo json_encode($user);
    exit();
}

// -----------------------------------------------------
// Benutzer speichern
// -----------------------------------------------------
if (isset($_POST['createUser'])) {

    $data = validateUserData($_POST);

    $newId = createUser($pdo, $currentUserId, $data);

    if ($newId > 0) {

        echo "success";
    } else {

        echo "Fehler beim Speichern.";
    }

    exit();
}

// -----------------------------------------------------
// Benutzer aktualisieren
// -----------------------------------------------------
if (isset($_POST['updateUser']) && !isset($_POST['load'])) {
    //header('Content-Type: application/json');
    $data = validateUserData($_POST);

    if (updateUser($pdo, $userId, $currentUserId, $data)) {

        echo "success";
    } else {

        echo "Fehler beim Aktualisieren.";
    }

    exit();
}

// -----------------------------------------------------
// Benutzer löschen
// -----------------------------------------------------
if (isset($_POST['deleteUser'])) {

    if (deleteUser($pdo, $userId)) {

        echo "success";
    } else {

        echo "Fehler beim Löschen.";
    }

    exit();
}
header('Content-Type: application/json');
echo json_encode([
    'success' => false,
    'message' => 'Ungültige Anfrage.'
]);

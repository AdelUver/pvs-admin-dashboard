<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Ungültige Anfragemethode.';
    exit();
}

if (!isset($_SESSION['userId'])) {
    http_response_code(401);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'session';
    exit();
}

require_once FUNCTIONS_PATH . '/function-db.php';
require_once FUNCTIONS_PATH . '/users.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo = getDB();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    echo 'Die Datenbank ist derzeit nicht erreichbar.';
    exit();
}

$currentUserId = (int) $_SESSION['userId'];
$userId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$isLoadRequest = isset($_POST['updateUser'], $_POST['load']);

if (isset($_POST['showUser']) || $isLoadRequest) {
    header('Content-Type: application/json; charset=utf-8');

    if ($userId === false || $userId === null || $userId < 1) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Ungültige Benutzer-ID.']);
        exit();
    }

    try {
        $user = getUserById($pdo, $userId);
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Benutzerdaten konnten nicht geladen werden.']);
        exit();
    }

    if (!$user) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Benutzer nicht gefunden.']);
        exit();
    }

    echo json_encode($user);
    exit();
}

$isCreate = isset($_POST['createUser']);
$isUpdate = isset($_POST['updateUser']) && !$isLoadRequest;
$isDelete = isset($_POST['deleteUser']);

if (!$isCreate && !$isUpdate && !$isDelete) {
    http_response_code(400);
    echo 'Ungültige Anfrage.';
    exit();
}

if (!$isCreate && ($userId === false || $userId === null || $userId < 1)) {
    http_response_code(400);
    echo 'Ungültige Benutzer-ID.';
    exit();
}

if ($isDelete) {
    try {
        if (deleteUser($pdo, $userId)) {
            echo 'success';
        } else {
            http_response_code(404);
            echo 'Benutzer nicht gefunden.';
        }
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        http_response_code(500);
        echo 'Benutzer konnte nicht gelöscht werden.';
    }
    exit();
}

$data = validateUserData($_POST);

if ($data['username'] === '' || $data['first_name'] === '' || $data['last_name'] === '') {
    http_response_code(400);
    echo 'Bitte Benutzername, Vorname und Nachname eingeben.';
    exit();
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Bitte eine gültige E-Mail-Adresse eingeben.';
    exit();
}

if (!in_array($data['role'], ['super_admin', 'admin', 'editor', 'user'], true)) {
    http_response_code(400);
    echo 'Ungültige Benutzerrolle.';
    exit();
}

if (!in_array($data['is_active'], [0, 1], true)) {
    http_response_code(400);
    echo 'Ungültiger Benutzerstatus.';
    exit();
}

if (($isCreate && strlen($data['password']) < 3)
    || ($isUpdate && $data['password'] !== '' && strlen($data['password']) < 3)) {
    http_response_code(400);
    echo 'Das Passwort muss mindestens 3 Zeichen lang sein.';
    exit();
}

$exceptUserId = $isUpdate ? $userId : 0;
try {
    if (userUsernameExists($pdo, $data['username'], $exceptUserId)) {
        http_response_code(409);
        echo 'Dieser Benutzername wird bereits verwendet.';
        exit();
    }

    if (userEmailExists($pdo, $data['email'], $exceptUserId)) {
        http_response_code(409);
        echo 'Diese E-Mail-Adresse wird bereits verwendet.';
        exit();
    }

    $saved = $isCreate
        ? createUser($pdo, $currentUserId, $data) > 0
        : updateUser($pdo, $userId, $currentUserId, $data);
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    echo $isCreate ? 'Benutzer konnte nicht erstellt werden.' : 'Benutzer konnte nicht aktualisiert werden.';
    exit();
}

if (!$saved) {
    http_response_code($isUpdate ? 404 : 500);
    echo $isUpdate ? 'Benutzer nicht gefunden.' : 'Benutzer konnte nicht erstellt werden.';
    exit();
}

echo 'success';

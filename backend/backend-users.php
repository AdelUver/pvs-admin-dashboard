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
$currentUserRole = getUserRole($pdo, $currentUserId);
if ($currentUserRole === null) {
    http_response_code(403);
    exit('Kein gültiges Benutzerkonto.');
}

$actions = [];
if (isset($_POST['showUser'])) {
    $actions[] = 'show';
}
if (isset($_POST['createUser'])) {
    $actions[] = 'create';
}
if (isset($_POST['updateUser'])) {
    $actions[] = isset($_POST['load']) ? 'load' : 'update';
}
if (isset($_POST['deleteUser'])) {
    $actions[] = 'delete';
}

if (count($actions) !== 1) {
    http_response_code(400);
    echo 'Ungültige Anfrage.';
    exit();
}

$action = $actions[0];
$userId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

if (in_array($action, ['show', 'load'], true)) {
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

if (!canManageUsers($currentUserRole)) {
    http_response_code(403);
    exit('Du darfst Benutzer nur ansehen.');
}

if ($action !== 'create' && ($userId === false || $userId === null || $userId < 1)) {
    http_response_code(400);
    echo 'Ungültige Benutzer-ID.';
    exit();
}

if ($action !== 'create') {
    try {
        $targetUser = getUserById($pdo, $userId);
    } catch (PDOException $exception) {
        error_log($exception->getMessage());
        http_response_code(500);
        exit('Benutzerdaten konnten nicht geladen werden.');
    }

    if (!$targetUser) {
        http_response_code(404);
        exit('Benutzer nicht gefunden.');
    }

    if (!canManageUserRole($currentUserRole, $targetUser['role'])) {
        http_response_code(403);
        exit('Du darfst Benutzer mit dieser Rolle nicht bearbeiten.');
    }
}

if ($action === 'delete') {
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
$isUpdate = $action === 'update';

if (!userFieldsFitSchema($data)) {
    http_response_code(400);
    echo 'Benutzername, E-Mail, Vor- und Nachname überschreiten die erlaubte Feldlänge.';
    exit();
}

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

if (!canManageUserRole($currentUserRole, $data['role'])) {
    http_response_code(403);
    echo 'Du darfst keine Benutzer mit dieser Rolle erstellen oder zuweisen.';
    exit();
}

if (!in_array($data['is_active'], [0, 1], true)) {
    http_response_code(400);
    echo 'Ungültiger Benutzerstatus.';
    exit();
}

if (($action === 'create' && strlen($data['password']) < 3)
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

    $saved = !$isUpdate
        ? createUser($pdo, $currentUserId, $data) > 0
        : updateUser($pdo, $userId, $currentUserId, $data);
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    echo $isUpdate ? 'Benutzer konnte nicht aktualisiert werden.' : 'Benutzer konnte nicht erstellt werden.';
    exit();
}

if (!$saved) {
    http_response_code($isUpdate ? 404 : 500);
    echo $isUpdate ? 'Benutzer nicht gefunden.' : 'Benutzer konnte nicht erstellt werden.';
    exit();
}

echo 'success';

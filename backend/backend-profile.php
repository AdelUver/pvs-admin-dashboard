<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: text/plain; charset=utf-8');

// Benutzer muss angemeldet sein
if (!isset($_SESSION['userId'])) {
    http_response_code(401);
    echo "session";
    exit();
}

$userId = (int) $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo 'Ungültige Anfragemethode.';
    exit();
}

require_once FUNCTIONS_PATH . '/function-db.php';
require_once FUNCTIONS_PATH . '/profile.php';

$pdo = getDB();
$action = $_POST["action"] ?? "";

switch ($action) {
    case "updateProfile":
        $username = is_string($_POST["username"] ?? null) ? trim($_POST["username"]) : "";
        $firstName = is_string($_POST["first_name"] ?? null) ? trim($_POST["first_name"]) : "";
        $lastName = is_string($_POST["last_name"] ?? null) ? trim($_POST["last_name"]) : "";

        if ($username === "") {
            echo "Bitte einen Benutzernamen eingeben.";
            exit();
        }

        if ($firstName === "") {
            echo "Bitte den Vornamen eingeben.";
            exit();
        }

        if ($lastName === "") {
            echo "Bitte den Nachnamen eingeben.";
            exit();
        }

        if (profileUsernameExists($pdo, $username, $userId)) {
            echo "Dieser Benutzername wird bereits verwendet.";
            exit();
        }

        if (updateProfile($pdo, $userId, $username, $firstName, $lastName)) {
            echo "success";
        } else {
            echo "Profil konnte nicht gespeichert werden.";
        }
        break;

    case "changeEmail":
        $email = is_string($_POST["email"] ?? null) ? trim($_POST["email"]) : "";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Ungültige E-Mail-Adresse.";
            exit();
        }

        if (emailExists($pdo, $email, $userId)) {
            echo "Diese E-Mail-Adresse wird bereits verwendet.";
            exit();
        }

        if (updateEmail($pdo, $userId, $email)) {
            $_SESSION['email'] = $email;
            echo "success";
        } else {
            echo "E-Mail konnte nicht geändert werden.";
        }
        break;

    case "changePassword":
        $currentPassword = is_string($_POST["current_password"] ?? null) ? $_POST["current_password"] : "";
        $newPassword = is_string($_POST["new_password"] ?? null) ? $_POST["new_password"] : "";
        $repeatPassword = is_string($_POST["repeat_password"] ?? null) ? $_POST["repeat_password"] : "";

        if (!verifyCurrentPassword($pdo, $userId, $currentPassword)) {
            echo "Das aktuelle Passwort ist falsch.";
            exit();
        }

        if (strlen($newPassword) < 3) {
            echo "Das neue Passwort muss mindestens 3 Zeichen lang sein.";
            exit();
        }

        if ($newPassword !== $repeatPassword) {
            echo "Die Passwörter stimmen nicht überein.";
            exit();
        }

        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        if (updatePassword($pdo, $userId, $passwordHash)) {
            echo "success";
        } else {
            echo "Passwort konnte nicht geändert werden.";
        }
        break;

    default:
        http_response_code(400);
        echo "Ungültige Anfrage.";
        break;
}

<?php

require_once dirname(__DIR__) . '/config/config.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once FUNCTIONS_PATH . '/function-db.php';

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo 'Ungültige Anfragemethode.';
    exit();
}

//Formulardaten
$password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
$email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';

if (empty($email) || empty($password)) {
    echo 'Bitte alle Felder ausfüllen.';
    exit();
}

//Datenbankverbindung herstellen
$pdo = getDB();

//Benutzer in Datenbank suchen
$sql = "SELECT user_id, email, password_hash, is_active
    FROM admin_users
    WHERE email = :email
    LIMIT 1";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":email" => $email
    ]);

    $user = $stmt->fetch();
} catch (PDOException $e) {
    echo "Fehler bei der Datenbankabfrage.";
    exit();
}

// User gefunden? 
if (!$user) {
    echo "Benutzer existiert nicht.";
    exit();
}

if (!(int)$user['is_active']) {
    echo "Dieses Benutzerkonto ist deaktiviert.";
    exit();
}

//Passwort prüfen
if (!password_verify($password, $user['password_hash'])) {
    echo "Falsches Passwort.";
    exit();
}

try {
    $loginUpdate = $pdo->prepare("
        UPDATE admin_users
        SET last_login_at = NOW()
        WHERE user_id = :user_id
    ");
    $loginUpdate->execute([':user_id' => $user['user_id']]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo 'Anmeldung konnte nicht abgeschlossen werden.';
    exit();
}

$_SESSION['userId'] = $user['user_id'];
$_SESSION["loggedin"] = true;
$_SESSION["email"] = $user["email"];


echo 'success';

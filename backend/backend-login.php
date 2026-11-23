<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/Uver/LoginPVS/functions/function-db.php';



//Nur POST Daten erlauben
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo 'Serverfehler';
    exit();
}

//Formulardaten
$password = trim($_POST['password'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($email) || empty($password)) {
    echo 'Bitte alle Felder ausfüllen.';
    exit();
}

//Datenbankverbindung herstellen
$pdo = getDB();

//Benutzer in Datenbank suchen
$sql = "SELECT user_id, email, password_hash
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

//Passwort prüfen
if (!password_verify($password, $user['password_hash'])) {
    echo "Falsches Passwort.";
    exit();
}

//Login erfolgreich
$_SESSION['userId'] = $user['user_id'];
$_SESSION["loggedin"] = true;
$_SESSION["email"] = $user["email"];


echo 'success';

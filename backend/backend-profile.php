<?php

declare(strict_types=1);

session_start();

//Abhängigkeiten
require_once $_SERVER['DOCUMENT_ROOT'] . '/Uver/loginPVS/functions/function-db.php';
require_once "backend-functions/profile.php";

$pdo = getDb();

// Benutzer muss angemeldet sein
if (!isset($_SESSION['userId'])) {
    echo "session";
    exit();
}


//Initialisierung
$userId = (int) $_SESSION['userId'];



//Es dürfen nur POST-Anfragen verarbeitet werden.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo 'Server-Request Fehler';
    exit();
}

//Aktion bestimmen
$action = $_POST["action"] ?? "";

switch ($action) {

    //Persönliche Daten aktualisieren
    case "updateProfile":

        $username   = trim($_POST["username"] ?? "");
        $firstName  = trim($_POST["first_name"] ?? "");
        $lastName   = trim($_POST["last_name"] ?? "");

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

        //Weitere valdidirungen für persönliche Daten hier    !!!!!!!!!!!!!!!!!!!!!!


        if (
            updateProfile(
                $pdo,
                $userId,
                $username,
                $firstName,
                $lastName
            )
        ) {

            echo "success";
            exit();
        } else {

            echo "Profil konnte nicht gespeichert werden.";
            exit();
        }

        break;

    //E-Mail ändern
    case "changeEmail":

        $email = trim($_POST["email"] ?? "");

        //Email korrekt?
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            echo "Ungültige E-Mail-Adresse.";
            exit();
        }

        if (emailExists($pdo, $email, $userId)) {

            echo "Diese E-Mail-Adresse wird bereits verwendet.";
            exit();
        }

        //Weitere valdidirungen für Email hier    !!!!!!!!!!!!!!!!!!!!!!

        if (updateEmail($pdo, $userId, $email)) {

            echo "E-Mail erfolgreich geändert.";
            exit();
        } else {

            echo "E-Mail konnte nicht geändert werden.";
            exit();
        }

        break;

    //Passwort ändern
    case "changePassword":

        $currentPassword = $_POST["current_password"] ?? "";
        $newPassword     = $_POST["new_password"] ?? "";
        $repeatPassword  = $_POST["repeat_password"] ?? "";

        if (!verifyCurrentPassword(
            $pdo,
            $userId,
            $currentPassword
        )) {

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

        //Weitere valdidirungen für Password hier    !!!!!!!!!!!!!!!!!!!!!!


        $passwordHash = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        if (
            updatePassword(
                $pdo,
                $userId,
                $passwordHash
            )
        ) {

            echo "Passwort erfolgreich geändert.";
            exit();
        } else {

            echo "Passwort konnte nicht geändert werden.";
            exit();
        }

        break;

    //Unbekannte Aktion
    default:

        echo "Ungültige Anfrage.";
        exit();

        break;
}

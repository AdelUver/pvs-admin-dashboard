<?php

declare(strict_types=1);




//Lädt die Profildaten des aktuell angemeldeten Benutzers.
function getProfile(PDO $pdo, int $userId): array|false
{
    $sql = "
        SELECT
            user_id,
            username,
            first_name,
            last_name,
            email,
            role,
            is_active,
            created_at,
            last_login_at
        FROM admin_users
        WHERE user_id = :userId
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':userId' => $userId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



//Aktualisiert die persönlichen Daten.
function updateProfile(
    PDO $pdo,
    int $userId,
    string $username,
    string $firstName,
    string $lastName
): bool {

    $sql = "
        UPDATE admin_users
        SET
            username = :username,
            first_name = :firstName,
            last_name = :lastName
        WHERE user_id = :userId
    ";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':username'  => trim($username),
        ':firstName' => trim($firstName),
        ':lastName'  => trim($lastName),
        ':userId'    => $userId
    ]);
}



//Aktualisiert die E-Mail-Adresse.
function updateEmail(
    PDO $pdo,
    int $userId,
    string $email
): bool {

    $sql = "
        UPDATE admin_users
        SET email = :email
        WHERE user_id = :userId
    ";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':email'  => trim($email),
        ':userId' => $userId
    ]);
}



//Prüft, ob die E-Mail bereits vergeben ist.
function emailExists(
    PDO $pdo,
    string $email,
    int $userId
): bool {

    $sql = "
        SELECT user_id
        FROM admin_users
        WHERE email = :email
        AND user_id != :userId
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':email'  => trim($email),
        ':userId' => $userId
    ]);

    return (bool)$stmt->fetch();
}



//Prüft das aktuelle Passwort.
function verifyCurrentPassword(
    PDO $pdo,
    int $userId,
    string $password
): bool {

    $sql = "
        SELECT password_hash
        FROM admin_users
        WHERE user_id = :userId
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':userId' => $userId
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    return password_verify($password, $user['password_hash']);
}



//Aktualisiert das Passwort.
function updatePassword(
    PDO $pdo,
    int $userId,
    string $passwordHash
): bool {

    $sql = "
        UPDATE admin_users
        SET password_hash = :passwordHash
        WHERE user_id = :userId
    ";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':passwordHash' => $passwordHash,
        ':userId'       => $userId
    ]);
}


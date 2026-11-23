<?php

declare(strict_types=1);

//data validieren
function validateUserData(array $data): array
{
    return [
        'username'   => is_string($data['username'] ?? null) ? trim($data['username']) : '',
        'email'      => is_string($data['email'] ?? null) ? trim($data['email']) : '',
        'password'   => is_string($data['password'] ?? null) ? $data['password'] : '',
        'first_name' => is_string($data['first_name'] ?? null) ? trim($data['first_name']) : '',
        'last_name'  => is_string($data['last_name'] ?? null) ? trim($data['last_name']) : '',
        'role'       => is_string($data['role'] ?? null) ? $data['role'] : '',
        'is_active'  => filter_var($data['is_active'] ?? null, FILTER_VALIDATE_INT)
    ];
}

function userUsernameExists(PDO $pdo, string $username, int $exceptUserId = 0): bool
{
    $stmt = $pdo->prepare("
        SELECT user_id
        FROM admin_users
        WHERE username = :username
          AND user_id != :user_id
        LIMIT 1
    ");
    $stmt->execute([
        ':username' => trim($username),
        ':user_id' => $exceptUserId
    ]);

    return (bool)$stmt->fetchColumn();
}

function userEmailExists(PDO $pdo, string $email, int $exceptUserId = 0): bool
{
    $stmt = $pdo->prepare("
        SELECT user_id
        FROM admin_users
        WHERE email = :email
          AND user_id != :user_id
        LIMIT 1
    ");
    $stmt->execute([
        ':email' => trim($email),
        ':user_id' => $exceptUserId
    ]);

    return (bool)$stmt->fetchColumn();
}

//alle user lesen
function getAllUsers(PDO $pdo): array
{
    $sql = "
        SELECT
            user_id,
            username,
            email,
            first_name,
            last_name,
            role,
            is_active,
            created_at,
            updated_at,
            last_login_at
        FROM admin_users
        ORDER BY last_name, first_name
    ";
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//user anhand id lesen
function getUserById(PDO $pdo, int $userId): array|false
{
    $stmt = $pdo->prepare("
        SELECT
            user_id,
            username,
            email,
            first_name,
            last_name,
            role,
            is_active,
            created_at,
            updated_at,
            last_login_at
        FROM admin_users
        WHERE user_id = :id
    ");

    $stmt->execute([
        ':id' => $userId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//user erstellen
function createUser(PDO $pdo, int $createdBy, array $data): int
{
    $stmt = $pdo->prepare("
        INSERT INTO admin_users
        (
            username,
            email,
            first_name,
            last_name,
            password_hash,
            role,
            is_active,
            created_by,
            updated_by
        )
        VALUES
        (
            :username,
            :email,
            :first_name,
            :last_name,
            :password_hash,
            :role,
            :is_active,
            :created_by,
            :updated_by
        )
    ");

    $stmt->execute([

        ':username'   => $data['username'],
        ':email'      => $data['email'],
        ':first_name' => $data['first_name'],
        ':last_name'  => $data['last_name'],
        ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        ':role'       => $data['role'],
        ':is_active'  => $data['is_active'],
        ':created_by' => $createdBy,
        ':updated_by' => $createdBy

    ]);

    return (int)$pdo->lastInsertId();
}

//user aktulisiern
function updateUser(PDO $pdo, int $userId, int $updatedBy, array $data): bool
{
    if (!empty($data['password'])) {
        $sql = "
            UPDATE admin_users
            SET
                username = :username,
                email = :email,
                password_hash = :password_hash,
                first_name = :first_name,
                last_name = :last_name,
                role = :role,
                is_active = :is_active,
                updated_at = NOW(),
                updated_by = :updated_by
            WHERE user_id = :id
        ";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':username'   => $data['username'],
            ':email'      => $data['email'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':role'       => $data['role'],
            ':is_active'  => $data['is_active'],
            ':updated_by' => $updatedBy,
            ':id'         => $userId
        ]);
    }

    $sql = "
        UPDATE admin_users
        SET
            username = :username,
            email = :email,
            first_name = :first_name,
            last_name = :last_name,
            role = :role,
            is_active = :is_active,
            updated_at = NOW(),
            updated_by = :updated_by
        WHERE user_id = :id
    ";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':username'   => $data['username'],
        ':email'      => $data['email'],
        ':first_name' => $data['first_name'],
        ':last_name'  => $data['last_name'],
        ':role'       => $data['role'],
        ':is_active'  => $data['is_active'],
        ':updated_by' => $updatedBy,
        ':id'         => $userId
    ]);
}

//user löschen
function deleteUser(PDO $pdo, int $userId): bool
{
    $stmt = $pdo->prepare("
        DELETE FROM admin_users
        WHERE user_id = :id
    ");

    return $stmt->execute([
        ':id' => $userId
    ]) && $stmt->rowCount() > 0;
}

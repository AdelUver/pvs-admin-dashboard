<?php

//data validieren
function validateUserData(array $data): array
{
    return [

        'username'   => trim($data['username'] ?? ''),
        'email'      => trim($data['email'] ?? ''),
        'password'   => $data['password'] ?? '',
        'first_name' => trim($data['first_name'] ?? ''),
        'last_name'  => trim($data['last_name'] ?? ''),
        'role'       => $data['role'] ?? 'user',
        'is_active'  => isset($data['is_active']) ? (int)$data['is_active'] : 1

    ];
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
            role,
            is_active,
            created_by
        )
        VALUES
        (
            :username,
            :email,
            :first_name,
            :last_name,
            :role,
            :is_active,
            :created_by
        )
    ");

    $stmt->execute([

        ':username'   => $data['username'],
        ':email'      => $data['email'],
        ':first_name' => $data['first_name'],
        ':last_name'  => $data['last_name'],
        ':role'       => $data['role'],
        ':is_active'  => $data['is_active'],
        ':created_by' => $createdBy

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
                password = :password,
                first_name = :first_name,
                last_name = :last_name,
                role = :role,
                is_active = :is_active,
                updated_at = NOW()
            WHERE user_id = :id
        ";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([

            ':username'   => $data['username'],
            ':email'      => $data['email'],
            ':password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            ':first_name' => $data['first_name'],
            ':last_name'  => $data['last_name'],
            ':role'       => $data['role'],
            ':is_active'  => $data['is_active'],
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
            updated_at = NOW()
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
    ]);
}

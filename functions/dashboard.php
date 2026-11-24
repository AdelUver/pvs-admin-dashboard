<?php

/**
 * Zählt alle aktiven Mitglieder.
 *
 * @param PDO $pdo
 * @return int
 */
function countActiveMembers(PDO $pdo): int
{
    $sql = "
        SELECT COUNT(*) 
        FROM memberships
          WHERE is_active = :is_active
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':is_active' => 1
    ]);

    return (int) $stmt->fetchColumn();
}


/**
 * Zählt alle gesperrten Mitglieder.
 *
 * @param PDO $pdo
 * @return int
 */
function countBlockedMembers(PDO $pdo): int
{
    $sql = "
        SELECT COUNT(*)
        FROM memberships
        WHERE is_active = :is_active
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':is_active' => 0
    ]);

    return (int) $stmt->fetchColumn();
}

/**
 * Zählt alle neuen Mitglieder des aktuellen Monats.
 *
 * @param PDO $pdo
 * @return int
 */
function countNewMembersThisMonth(PDO $pdo): int
{
    $sql = "
        SELECT COUNT(*)
        FROM memberships
        WHERE YEAR(created_at) = YEAR(CURDATE())
          AND MONTH(created_at) = MONTH(CURDATE())
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return (int) $stmt->fetchColumn();
}

// Zählt alle nicht gelöschte Events && event-status
function getEventsData(PDO $pdo): array
{
    // Event-Statistik
    $eventSql = "
        SELECT
            COUNT(*) AS events,
            SUM(status = 'planned') AS planned,
            SUM(status = 'full') AS full,
            SUM(status = 'completed') AS completed,
            SUM(status = 'cancelled') AS cancelled
        FROM events
        WHERE deleted = 0
    ";
    $stmt = $pdo->prepare($eventSql);

    $stmt->execute();

    $events = $stmt->fetch(PDO::FETCH_ASSOC);

    return [
        // Events
        'events' => (int) $events['events'],
        'planned' => (int) $events['planned'],
        'full' => (int) $events['full'],
        'completed' => (int) $events['completed'],
        'cancelled' => (int) $events['cancelled']
    ];
}

// Zählt alle Events
function countAlleEvents(PDO $pdo): int
{
    $stmt = $pdo->prepare("
    SELECT COUNT(*) FROM events"
    );

    $stmt->execute();
    return (int) $stmt->fetchColumn();
}

// Zählt alle gelöschte Events
function getDeletedEvents(PDO $pdo): int
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM events WHERE deleted = 1"
    );

    $stmt->execute();
    return (int) $stmt->fetchColumn();
}

// Zählt alle kommende aktive Events
function getUpcomingEvents(PDO $pdo, int $limit = 5): array
{
    $stmt = $pdo->prepare("
        SELECT
            event_id,
            title,
            event_date,
            event_time,
            location,
            status
        FROM events
        WHERE deleted = 0
          AND event_date >= CURDATE()
        ORDER BY event_date ASC, event_time ASC
        LIMIT :limit
    ");

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Zählt alle aktive Admins && admin-rolle
function getAdmisData(PDO $pdo): array
{
    // Benutzer-Statistik
    $userSql = "
        SELECT
            COUNT(*) AS users,
            SUM(role = 'super_admin') AS super_admins,
            SUM(role = 'admin') AS admins,
            SUM(role = 'editor') AS editors
        FROM admin_users
        WHERE is_active = 1
    ";
    $stmt = $pdo->prepare($userSql);

    $stmt->execute();

    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    return [
        // Benutzer
        'users' => (int) $users['users'],
        'super_admins' => (int) $users['super_admins'],
        'admins' => (int) $users['admins'],
        'editors' => (int) $users['editors']
    ];
}


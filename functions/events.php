<?php

//Event Registration
function getEventRegistrations(PDO $pdo, int $eventId): array
{
    $sql = "
        SELECT

            r.registration_id,
            r.status,
            r.registered_at,

            u.user_id,
            u.first_name,
            u.last_name,
            u.email

        FROM event_registrations r

        INNER JOIN admin_users u
            ON u.user_id = r.user_id

        WHERE r.event_id = :event_id

        ORDER BY
            r.registered_at ASC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'event_id' => $eventId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Teilnehmer eines Events zählen
function countRegisteredParticipants(PDO $pdo, int $eventId): int
{
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM event_registrations
        WHERE event_id = :event_id
          AND status = 'registered'
    ");

    $stmt->execute([
        'event_id' => $eventId
    ]);

    return (int)$stmt->fetchColumn();
}

//Max. Teilnehmer eines Events finden
function getMaxParticipants(PDO $pdo, int $eventId): int
{
    $stmt = $pdo->prepare("
        SELECT max_participants
        FROM events
        WHERE event_id = :event_id
    ");

    $stmt->execute([
        'event_id' => $eventId
    ]);

    return (int)$stmt->fetchColumn();
}

//Prüfen, ob das Event voll ist
function isEventFull(PDO $pdo, int $eventId): bool
{
    return countRegisteredParticipants($pdo, $eventId)
        >= getMaxParticipants($pdo, $eventId);
}

//Status automatisch setzen
function updateEventStatus(PDO $pdo, int $eventId): void
{
    $status = isEventFull($pdo, $eventId)
        ? 'full'
        : 'planned';

    $stmt = $pdo->prepare("
        UPDATE events
        SET status = :status
        WHERE event_id = :event_id
    ");

    $stmt->execute([
        'status' => $status,
        'event_id' => $eventId
    ]);
}

//Alle Teilnehmer eines Events laden
function getEventParticipants(PDO $pdo, int $eventId): array
{
    $sql = "
        SELECT
            u.user_id,
            u.first_name,
            u.last_name,
            u.email,
            r.status,
            r.registered_at

        FROM event_registrations r

        INNER JOIN admin_users u
            ON u.user_id = r.user_id

        WHERE r.event_id = :event_id
          AND r.status = 'registered'

        ORDER BY u.last_name ASC,
                 u.first_name ASC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'event_id' => $eventId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//$_POST validieren
function validateData(array $input): array
{
    // Titel
    $title = trim($input['title'] ?? '');
    if ($title === '') {
        echo 'Bitte einen Eventtitel eingeben.';
        exit();
    }

    // Status
    $allowedStatus = ['planned', 'full', 'completed', 'cancelled'];

    $status = $input['status'] ?? 'planned';
    if (!in_array($status, $allowedStatus, true)) {
        echo 'Ungültiger Status.';
        exit();
    }

    // Beschreibung
    $description = trim($input['description'] ?? '');

    // Datum
    $date = trim($input['event_date'] ?? '');

    if ($date === '') {
        echo 'Bitte ein Datum auswählen.';
        exit();
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $date);

    if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
        echo 'Ungültiges Datum.';
        exit();
    }

    // Uhrzeit
    $time = trim($input['event_time'] ?? '');

    if ($time === '') {
        echo 'Bitte eine Uhrzeit auswählen.';
        exit();
    }

    $timeObj = DateTime::createFromFormat('H:i', $time);

    if (!$timeObj || $timeObj->format('H:i') !== $time) {
        echo 'Ungültige Uhrzeit.';
        exit();
    }

    // Ort
    $location = trim($input['location'] ?? '');
    if ($location === '') {
        echo 'Bitte einen Ort eingeben.';
        exit();
    }

    // Straße
    $street = trim($input['street'] ?? '');
    if ($street === '') {
        echo 'Bitte eine Straße eingeben.';
        exit();
    }

    // PLZ
    $postCode = trim($input['post_code'] ?? '');
    if ($postCode === '' && !preg_match('/^\d{4,5}$/', $postCode)) {
        echo 'Ungültige Postleitzahl.';
        exit();
    }

    // Stadt
    $city = trim($input['city'] ?? '');
    if ($city === '') {
        echo 'Bitte eine Stadt eingeben.';
        exit();
    }

    // Max. Teilnehmer
    if ($input['max_participants'] === '') {
        echo 'Bitte eine Max. Teilnehmerzahl eingeben.';
        exit();
    }

    $maxParticipants = filter_input(INPUT_POST, 'max_participants', FILTER_VALIDATE_INT);

    if ($maxParticipants === false) {
        echo 'Max. Teilnehmer muss eine ganze Zahl sein.';
        exit();
    }


    // Letzter Anmeldetag
    $lastRegisterDate = $input['registration_deadline'] ?? '';
    if ($lastRegisterDate === '' || !DateTime::createFromFormat('Y-m-d', $lastRegisterDate)) {
        echo 'Ungültiger Anmeldeschluss.';
        exit();
    }

    // Optional: Anmeldeschluss darf nicht nach dem Event liegen
    if (
        $date !== '' &&
        $lastRegisterDate !== '' &&
        strtotime($lastRegisterDate) > strtotime($date)
    ) {
        echo 'Der Anmeldeschluss darf nicht nach dem Eventdatum liegen.';
        exit();
    }

    // Alles erfolgreich?
    $data = [
        'title' => $title,
        'event_date' => $date,
        'event_time' => $time,
        'location' => $location,
        'street' => $street,
        'post_code' => $postCode,
        'city' => $city,
        'description' => $description,
        'max_participants' => $maxParticipants,
        'registration_deadline' => $lastRegisterDate,
        'status' => $status,
        'created_by' => $_SESSION['userId'],
        'updated_by' => $_SESSION['userId']
    ];
    return $data;
}

//Alle nicht gelöschten Events laden
function getAllEvents(PDO $pdo): array
{
    $sql = "
        SELECT * FROM events
        WHERE deleted  = 0
        ORDER BY event_date ASC, event_time ASC";

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

//Nur zukünftige Events laden
function getUpcomingEvents(PDO $pdo): array
{
    $sql = "SELECT * FROM events
            WHERE deleted = 0
              AND event_date >= CURDATE()
            ORDER BY event_date ASC, event_time ASC";

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

//Event anhand der ID laden
function getEventById(PDO $pdo, int $eventId): array|false
{
    $stmt = $pdo->prepare("
    SELECT
        events.*,

        created.first_name AS created_first_name,
        created.last_name AS created_last_name,

        updated.first_name AS updated_first_name,
        updated.last_name AS updated_last_name

    FROM events

    LEFT JOIN admin_users AS created
        ON events.created_by = created.user_id

    LEFT JOIN admin_users AS updated
        ON events.updated_by = updated.user_id

    WHERE events.event_id = :id

    LIMIT 1");

    $stmt->execute([
        'id' => $eventId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//Neues Event anlegen -> Gibt die neue event_id zurück
function createEvent(PDO $pdo, int $userId, array $data): int
{
    $sql = "INSERT INTO events (
                title,
                event_date,
                event_time,
                location,
                street,
                post_code,
                city,
                description,
                max_participants,
                registration_deadline,
                status,
                created_by,
                updated_by
            ) VALUES (
                :title,
                :event_date,
                :event_time,
                :location,
                :street,
                :post_code,
                :city,
                :description,
                :max_participants,
                :registration_deadline,
                :status,
                :created_by,
                :updated_by
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'event_date' => $data['event_date'],
        'event_time' => $data['event_time'],
        'location' => $data['location'],
        'street' => $data['street'],
        'post_code' => $data['post_code'],
        'city' => $data['city'],
        'description' => $data['description'],
        'max_participants' => $data['max_participants'],
        'registration_deadline' => $data['registration_deadline'],
        'status' => $data['status'] ?? 'planned',
        'created_by' => $userId,
        'updated_by' => $userId
    ]);

    return (int)$pdo->lastInsertId();
}


//Event aktualisieren
function updateEvent(PDO $pdo, int $eventId, int $userId, array $data): bool
{
    $sql = "UPDATE events SET
                title = :title,
                event_date = :event_date,
                event_time = :event_time,
                location = :location,
                street = :street,
                post_code = :post_code,
                city = :city,
                description = :description,
                max_participants = :max_participants,
                registration_deadline = :registration_deadline,
                status = :status,
                updated_by = :updated_by
            WHERE event_id = :event_id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'title' => $data['title'],
        'event_date' => $data['event_date'],
        'event_time' => $data['event_time'],
        'location' => $data['location'],
        'street' => $data['street'],
        'post_code' => $data['post_code'],
        'city' => $data['city'],
        'description' => $data['description'],
        'max_participants' => $data['max_participants'],
        'registration_deadline' => $data['registration_deadline'],
        'status' => $data['status'],
        'updated_by' => $userId,
        'event_id' => $eventId
    ]);
}

//Event soft löschen
function deleteEvent(PDO $pdo, int $eventId, int $userId): bool
{
    $sql = "UPDATE events
            SET deleted = 1,
                updated_by = :updated_by
            WHERE event_id = :event_id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'event_id' => $eventId,
        'updated_by' => $userId
    ]);
}

//Gelöschtes Event wiederherstellen
function restoreEvent(PDO $pdo, int $eventId, int $updatedBy): bool
{
    $sql = "UPDATE events
            SET deleted = 0,
                updated_by = :updated_by
            WHERE event_id = :event_id";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        'event_id' => $eventId,
        'updated_by' => $updatedBy
    ]);
}

//Events suchen (Titel, Ort oder Stadt)
function searchEvents(PDO $pdo, string $search): array
{
    $sql = "SELECT * FROM events
            WHERE deleted = 0
              AND (
                    title LIKE :search
                 OR location LIKE :search
                 OR city LIKE :search
              )
            ORDER BY event_date ASC, event_time ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'search' => '%' . $search . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Events nach Status laden
function getEventsByStatus(PDO $pdo, string $status): array
{
    $allowed = ['planned', 'full', 'completed', 'cancelled'];

    if (!in_array($status, $allowed, true)) {
        return [];
    }

    $sql = "SELECT * FROM events
            WHERE deleted = 0
              AND status = :status
            ORDER BY event_date ASC, event_time ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Anzahl aller aktiven Events
function countEvents(PDO $pdo): int
{
    $sql = "SELECT COUNT(*) FROM events WHERE deleted = 0";

    return (int)$pdo->query($sql)->fetchColumn();
}

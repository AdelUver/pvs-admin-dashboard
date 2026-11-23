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
    $title = trim($input['title'] ?? '');
    if ($title === '') {
        throw new InvalidArgumentException('Bitte einen Eventtitel eingeben.');
    }

    $allowedStatus = ['planned', 'full', 'completed', 'cancelled'];
    $status = $input['status'] ?? 'planned';
    if (!in_array($status, $allowedStatus, true)) {
        throw new InvalidArgumentException('Ungültiger Status.');
    }

    $description = trim($input['description'] ?? '');
    $date = trim($input['event_date'] ?? '');
    $dateObj = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    $dateErrors = DateTimeImmutable::getLastErrors();
    if (
        !$dateObj ||
        ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)) ||
        $dateObj->format('Y-m-d') !== $date
    ) {
        throw new InvalidArgumentException('Bitte ein gültiges Datum auswählen.');
    }

    $time = trim($input['event_time'] ?? '');
    $timeObj = DateTimeImmutable::createFromFormat('!H:i', $time);
    $timeErrors = DateTimeImmutable::getLastErrors();
    if (
        !$timeObj ||
        ($timeErrors !== false && ($timeErrors['warning_count'] > 0 || $timeErrors['error_count'] > 0)) ||
        $timeObj->format('H:i') !== $time
    ) {
        throw new InvalidArgumentException('Bitte eine gültige Uhrzeit auswählen.');
    }

    $location = trim($input['location'] ?? '');
    if ($location === '') {
        throw new InvalidArgumentException('Bitte einen Ort eingeben.');
    }

    $street = trim($input['street'] ?? '');
    if ($street === '') {
        throw new InvalidArgumentException('Bitte eine Straße eingeben.');
    }

    $postCode = trim($input['post_code'] ?? '');
    if (preg_match('/^\d{4,5}$/D', $postCode) !== 1) {
        throw new InvalidArgumentException('Bitte eine gültige Postleitzahl eingeben.');
    }

    $city = trim($input['city'] ?? '');
    if ($city === '') {
        throw new InvalidArgumentException('Bitte eine Stadt eingeben.');
    }

    $maxParticipants = filter_var($input['max_participants'] ?? null, FILTER_VALIDATE_INT);
    if ($maxParticipants === false || $maxParticipants < 1) {
        throw new InvalidArgumentException('Die maximale Teilnehmerzahl muss eine positive ganze Zahl sein.');
    }

    $lastRegisterDate = trim($input['registration_deadline'] ?? '');
    $deadlineObj = DateTimeImmutable::createFromFormat('!Y-m-d', $lastRegisterDate);
    $deadlineErrors = DateTimeImmutable::getLastErrors();
    if (
        !$deadlineObj ||
        ($deadlineErrors !== false && ($deadlineErrors['warning_count'] > 0 || $deadlineErrors['error_count'] > 0)) ||
        $deadlineObj->format('Y-m-d') !== $lastRegisterDate
    ) {
        throw new InvalidArgumentException('Bitte einen gültigen Anmeldeschluss auswählen.');
    }

    if ($lastRegisterDate > $date) {
        throw new InvalidArgumentException('Der Anmeldeschluss darf nicht nach dem Eventdatum liegen.');
    }

    return [
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
        'status' => $status
    ];
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
      AND events.deleted = 0

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
            WHERE event_id = :event_id
              AND deleted = 0";

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
            WHERE event_id = :event_id
              AND deleted = 0";

    $stmt = $pdo->prepare($sql);

    $success = $stmt->execute([
        'event_id' => $eventId,
        'updated_by' => $userId
    ]);

    return $success && $stmt->rowCount() > 0;
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

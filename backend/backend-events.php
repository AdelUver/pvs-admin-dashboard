<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once FUNCTIONS_PATH . '/function-db.php';
require_once FUNCTIONS_PATH . '/events.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Methode nicht erlaubt.');
}

if (!isset($_SESSION['userId'])) {
    http_response_code(401);
    exit('session');
}

$actions = ['createEvent', 'deleteEvent', 'updateEvent', 'showEvent', 'exportParticipants', 'showRegistrations'];
$requestedActions = array_values(array_filter($actions, static fn(string $action): bool => isset($_POST[$action])));

if (count($requestedActions) !== 1) {
    http_response_code(400);
    exit('Ungültige Event-Anfrage.');
}

$action = $requestedActions[0];
$userId = (int) $_SESSION['userId'];
$pdo = getDB();

if ($action === 'createEvent') {
    try {
        $data = validateData($_POST);
    } catch (InvalidArgumentException $exception) {
        http_response_code(422);
        exit($exception->getMessage());
    }

    if (createEvent($pdo, $userId, $data) > 0) {
        exit('success');
    }

    http_response_code(500);
    exit('Das Event konnte nicht gespeichert werden.');
}

$eventId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($eventId === false || $eventId === null || $eventId < 1) {
    http_response_code(400);
    exit('Ungültige Event-ID.');
}

$event = getEventById($pdo, $eventId);
if ($event === false) {
    http_response_code(404);
    exit('Event nicht gefunden.');
}

switch ($action) {
    case 'deleteEvent':
        if (!deleteEvent($pdo, $eventId, $userId)) {
            http_response_code(500);
            exit('Das Event konnte nicht gelöscht werden.');
        }

        exit('success');

    case 'updateEvent':
        if (isset($_POST['load'])) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($event, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
            exit();
        }

        try {
            $data = validateData($_POST);
        } catch (InvalidArgumentException $exception) {
            http_response_code(422);
            exit($exception->getMessage());
        }

        if (!updateEvent($pdo, $eventId, $userId, $data)) {
            http_response_code(500);
            exit('Das Event konnte nicht bearbeitet werden.');
        }

        exit('success');

    case 'showEvent':
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($event, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        exit();

    case 'exportParticipants':
        $participants = getEventParticipants($pdo, $eventId);
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="teilnehmer_event_' . $eventId . '.csv"');
        echo "\xEF\xBB\xBF";

        $output = fopen('php://output', 'w');
        if ($output === false) {
            http_response_code(500);
            exit('Der Export konnte nicht erstellt werden.');
        }

        fputcsv($output, ['ID', 'Vorname', 'Nachname', 'E-Mail', 'Angemeldet am'], ';');
        foreach ($participants as $participant) {
            fputcsv($output, [
                $participant['user_id'],
                $participant['first_name'],
                $participant['last_name'],
                $participant['email'],
                $participant['registered_at']
            ], ';');
        }

        fclose($output);
        exit();

    case 'showRegistrations':
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(getEventRegistrations($pdo, $eventId), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        exit();
}

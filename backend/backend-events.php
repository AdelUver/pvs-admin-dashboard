<?php

declare(strict_types=1);


error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();


//Abhängigkeiten
require_once FUNCTIONS_PATH . '/function-db.php';
require_once FUNCTIONS_PATH . "/events.php";

$pdo = getDb();

// Benutzer muss angemeldet sein
if (!isset($_SESSION['userId'])) {
    echo "session";
    exit();
}


//Initialisierung
$userId = (int) $_SESSION['userId'];

$action = isset($_POST['deleteEvent']) ? 'deleteEvent'
    : (isset($_POST['updateEvent']) ? 'updateEvent'
        : (isset($_POST['showEvent']) ? 'showEvent'
            : (isset($_POST['exportParticipants']) ? 'exportParticipants'
                : (isset($_POST['showRegistrations']) ? 'showRegistrations'
                    : ''))));

//delete edit oder show
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$action])) {

    $eventId = (int)$_POST['id'];
    switch ($action) {


        //delete Event
        case 'deleteEvent':
            if (deleteEvent($pdo, $eventId, $userId)) {
                echo "Event wurde gelöscht.";
            } else {
                echo "Fehler beim Versuch Event zu löschen";
            }
            break;


        //updateEvent
        case 'updateEvent':
            if (isset($_POST['load'])) {

                echo json_encode(
                    getEventById($pdo, $eventId)
                );

                exit();
            }


            //input validieren
            $data = validateData($_POST);

            if (updateEvent($pdo, $eventId, $userId, $data)) {

                echo "success";
            } else {

                echo "Fehler beim Bearbeiten";
            }

            break;
        //show Event
        case 'showEvent':
            echo json_encode(getEventById($pdo, $eventId));
            break;

        //Export Teilnehmer
        case 'exportParticipants':

            $participants = getEventParticipants($pdo, $eventId);

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="teilnehmer_event_' . $eventId . '.csv"');

            echo "\xEF\xBB\xBF";

            $output = fopen("php://output", "w");

            fputcsv($output, [
                'ID',
                'Vorname',
                'Nachname',
                'E-Mail',
                'Angemeldet am'
            ], ';');

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

        //Register anzeigen
        case 'showRegistrations':

            echo json_encode(
                getEventRegistrations($pdo, $eventId)
            );

            exit();

        default:
            echo 'Aktion nicht erkannt';
    }

    exit();
}

// new Event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = validateData($_POST);



    $id = createEvent($pdo, $userId, $data);

    if ($id > 0) {
        echo "success";
    } else {
        echo "Fehler beim Speichern";
    }
}

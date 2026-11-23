<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'on');

require_once __DIR__ . '/functions/function-db.php';

$title = "event1";
$event_date = "2026-10-10";
$event_time = "20:00:00";
$location = "Restaurant";
$street = "Hauptstraße";
$street = "Hauptstraße";
$post_code = 4040;
$city = "Linz";
$description = "Nichts";
$max_participants = 120;
$registration_deadline = "2026-10-10";
$status = "planned";
$registration_deadline = "2026-10-10";
$registration_deadline = "2026-10-10";

$sql = "
INSERT INTO events (
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
    updated_by,
    deleted
) VALUES

(
    'Sommerfest 2026',
    '2026-08-15',
    '18:00:00',
    'Stadthalle',
    'Hauptstraße 15',
    4020,
    'Linz',
    'Gemeinsames Sommerfest mit Musik und Buffet.',
    120,
    '2026-08-10',
    'planned',
    1,
    1,
    0
),

(
    'Business Frühstück',
    '2026-09-03',
    '08:30:00',
    'Hotel Plaza',
    'Bahnhofstraße 5',
    4020,
    'Linz',
    'Networking bei Frühstück und Kaffee.',
    40,
    '2026-08-28',
    'planned',
    1,
    1,
    0
),

(
    'Workshop Vertrieb',
    '2026-09-18',
    '09:00:00',
    'Schulungszentrum',
    'Industriestraße 21',
    4600,
    'Wels',
    'Vertriebstechniken und Kundenkommunikation.',
    30,
    '2026-09-10',
    'planned',
    1,
    1,
    0
),

(
    'Infoabend',
    '2026-10-05',
    '19:00:00',
    'Kulturzentrum',
    'Kirchgasse 3',
    4810,
    'Gmunden',
    'Vorstellung neuer Projekte und Produkte.',
    80,
    '2026-09-30',
    'planned',
    1,
    1,
    0
),

(
    'Mitarbeiterschulung',
    '2026-10-20',
    '10:00:00',
    'Firmenzentrale',
    'Technologiepark 1',
    4020,
    'Linz',
    'Interne Schulung für neue Mitarbeiter.',
    25,
    '2026-10-15',
    'planned',
    1,
    1,
    0
),

(
    'Kundenabend',
    '2026-11-12',
    '18:30:00',
    'Eventhalle',
    'Donauufer 10',
    4040,
    'Linz',
    'Gemütlicher Abend mit Kunden und Partnern.',
    100,
    '2026-11-05',
    'planned',
    1,
    1,
    0
),

(
    'Weihnachtsfeier',
    '2026-12-18',
    '19:00:00',
    'Schlossrestaurant',
    'Schlossweg 1',
    4060,
    'Leonding',
    'Jährliche Weihnachtsfeier des Unternehmens.',
    150,
    '2026-12-10',
    'planned',
    1,
    1,
    0
),

(
    'Online Webinar',
    '2026-08-25',
    '17:00:00',
    'Microsoft Teams',
    '-',
    0,
    'Online',
    'Live-Webinar zu aktuellen Entwicklungen.',
    300,
    '2026-08-24',
    'planned',
    1,
    1,
    0
),

(
    'Marketing Meeting',
    '2026-09-28',
    '14:00:00',
    'Konferenzraum',
    'Innovationstraße 8',
    4020,
    'Linz',
    'Quartalsplanung Marketing.',
    15,
    '2026-09-25',
    'planned',
    1,
    1,
    0
),

(
    'Tag der offenen Tür',
    '2026-11-01',
    '11:00:00',
    'Firmengebäude',
    'Musterweg 50',
    4020,
    'Linz',
    'Besichtigung der Firma und Präsentationen.',
    250,
    '2026-10-25',
    'planned',
    1,
    1,
    0
);
";

$statement = getDB()->exec($sql);

if (!$statement) {
    echo "Fehler";
}

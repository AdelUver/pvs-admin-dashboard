<style>
    .page-title {

        font-size: 30px;
        font-weight: 700;
        color: #1f2937;

        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        width: 100px;

    }

    .event-card {

        border: none;
        border-radius: 15px;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

    }

    .table thead {

        background: #f8fafc;

    }

    .table th {

        color: #475569;
        font-weight: 600;

    }

    .badge {

        font-size: .85rem;

    }

    .action-btn {

        width: 36px;
        height: 36px;

        padding: 0;

    }


    colo .filter-box {

        background: white;

        padding: 20px;

        border-radius: 15px;

        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

        margin-bottom: 20px;

    }
</style>

<?php

require_once BACKEND_PATH . '/backend-functions/events.php';
require_once FUNCTIONS_PATH . '/function-db.php';


//Daten
$pdo = getDB();
$userId = $_SESSION['userId'];
$events = getAllEvents($pdo);

?>

<div class="container-fluid" id="eventsSection">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="page-title">

            Events

        </h2>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">

            <i class="bi bi-plus-circle"></i>

            Neues Event

        </button>

    </div>

    <div class="filter-box">

        <div class="row g-3">

            <div class="col-lg-4">

                <input type="text" class="form-control" placeholder="Event suchen..." id="eventTitle">

            </div>

            <div class="col-lg-2">

                <input type="date" class="form-control" id="eventDateFrom">

            </div>

            <div class="col-lg-2">

                <input type="date" class="form-control" id="eventDateTo">

            </div>

            <div class="col-lg-2">

                <select class="form-select" id="eventStatus">

                    <option>Alle Status</option>
                    <option>Geplant</option>
                    <option>Ausgebucht</option>
                    <option>Abgeschlossen</option>
                    <option>Abgesagt</option>

                </select>

            </div>

            <div class="col-lg-2">

                <button class="btn btn-outline-primary w-100" id="filterEvent">

                    <i class="bi bi-search"></i>

                    Filtern

                </button>

            </div>

        </div>

    </div>

    <div class="card event-card">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Titel</th>

                        <th>Datum</th>

                        <th>Uhrzeit</th>

                        <th>Ort</th>

                        <th>Max. Teilnehmer</th>

                        <th>Status</th>

                        <th class="text-center">

                            Aktionen

                        </th>

                    </tr>

                </thead>

                <tbody id="tableBody">

                    <?php foreach ($events as $event): ?>

                        <tr data-id="<?= $event['event_id'] ?>">

                            <td>

                                <?= $event["event_id"] ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["title"]) ?>

                            </td>

                            <td>

                                <?= $event["event_date"] ?>

                            </td>

                            <td>

                                <?= $event["event_time"] ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["location"]) ?>

                            </td>

                            <td>

                                <?= $event["max_participants"] ?>

                            </td>

                            <td>

                                <?php

                                switch ($event["status"]) {

                                    case "full":

                                        echo '<span class="badge bg-success">Ausgebucht</span>';

                                        break;

                                    case "planned":

                                        echo '<span class="badge bg-primary">Geplant</span>';

                                        break;

                                    case "completed":

                                        echo '<span class="badge bg-secondary">Abgeschlossen</span>';

                                        break;

                                    case "cancelled":
                                        echo '<span class="badge bg-danger">Abgesagt</span>';

                                        break;

                                    default:

                                        echo '<span class="badge bg-danger">Unbekant</span>';
                                }

                                ?>

                            </td>

                            <td class="text-center">

                                <button class="btn btn-outline-info btn-sm action-btn showEvent" title="show">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <button class="btn btn-outline-warning btn-sm action-btn updateEvent" title="update">

                                    <i class="bi bi-pencil"></i>

                                </button>

                                <button
                                    class="btn btn-outline-success btn-sm action-btn exportParticipants"
                                    title="Teilnehmer exportieren">

                                    <i class="bi bi-download"></i>

                                </button>

                                <button class="btn btn-outline-danger btn-sm action-btn deleteEvent" title="delete">

                                    <i class="bi bi-trash"></i>

                                </button>

                                <button
                                    class="btn btn-outline-primary btn-sm action-btn showRegistrations"
                                    title="Anmeldungen">

                                    <i class="bi bi-people"></i>

                                </button>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

            <!--
            <nav>

                <ul class="pagination justify-content-end">

                    <li class="page-item disabled">

                        <a class="page-link">

                            Zurück

                        </a>

                    </li>

                    <li class="page-item active">

                        <a class="page-link">

                            1

                        </a>

                    </li>

                    <li class="page-item">

                        <a class="page-link">

                            2

                        </a>

                    </li>

                    <li class="page-item">

                        <a class="page-link">

                            Weiter

                        </a>

                    </li>

                </ul>

            </nav>

                                    -->

        </div>

    </div>

</div>

<?php require_once MODALS_PATH . '/modal-event_form.php'; ?>

<?php require_once MODALS_PATH . '/modal-event_show.php'; ?>

<?php require_once MODALS_PATH . '/modal-register_show.php'; ?>


<?php include_once SCRIPT_PATH . '/script-event.php'; ?>


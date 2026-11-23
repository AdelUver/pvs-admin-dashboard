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

require_once FUNCTIONS_PATH . '/events.php';
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

                                <button class="btn btn-outline-success btn-sm action-btn exportParticipants"
                                    title="Teilnehmer exportieren">

                                    <i class="bi bi-download"></i>

                                </button>

                                <button class="btn btn-outline-danger btn-sm action-btn deleteEvent" title="delete">

                                    <i class="bi bi-trash"></i>

                                </button>

                                <button class="btn btn-outline-primary btn-sm action-btn showRegistrations"
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

<script>
    $(document).ready(function () {

        // Add new Event
        $("#addEvent").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            var eventId = $("#addEvent").data("id");

            if (eventId) {

                formData.append("updateEvent", 1);
                formData.append("id", eventId);

            } else {

                formData.append("createEvent", 1);

            }

            $.ajax({
                url: "/Uver/pvs-admin-dashboard/backend/backend-events.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {

                    if (response.trim() === "success") {

                        // Formular zurücksetzen
                        $("#addEvent").removeAttr("data-id");
                        $("#addEvent")[0].reset();

                        // Modal wieder auf "Neues Event" stellen
                        $(".modal-title").text("Neues Event erstellen");

                        $("#saveEvent").html(`
                        <i class="bi bi-floppy"></i>
                         Event speichern
                        `);

                        window.location.reload();

                    } else {

                        alert(response);

                    }

                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert("Unerwarteter Fehler.");
                }
            });
        });

        //show Event
        $(".showEvent").on("click", function () {
            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/pvs-admin-dashboard/backend/backend-events.php",

                method: "POST",

                data: {
                    showEvent: 1,
                    id: id
                },

                success: function (response) {

                    var event = JSON.parse(response);

                    $("#show_event_id").text(event.event_id);
                    $("#show_title").text(event.title);
                    $("#show_description").text(event.description);
                    $("#show_date").text(event.event_date);
                    $("#show_time").text(event.event_time);
                    $("#show_location").text(event.location);
                    $("#show_street").text(event.street);
                    $("#show_postcode").text(event.post_code);
                    $("#show_city").text(event.city);
                    $("#show_max").text(event.max_participants);
                    $("#show_deadline").text(event.registration_deadline);
                    $("#show_status").text(event.status);

                    $("#show_created_at").text(event.created_at);
                    $("#show_updated_at").text(event.updated_at);
                    $("#show_created_by").text(event.created_last_name + " " + event.created_first_name);
                    $("#show_updated_by").text(event.updated_last_name + " " + event.updated_first_name);

                    $("#showEventModal").modal("show");

                },

                error: function () {

                    alert("Fehler beim Laden.");

                }

            });
        });


        //update Event
        $(".updateEvent").on("click", function () {
            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/pvs-admin-dashboard/backend/backend-events.php",

                method: "POST",

                data: {
                    updateEvent: 1,
                    id: id,
                    load: 1
                },

                success: function (response) {
                    console.log(response);
                    var event = JSON.parse(response);
                    var modal = new bootstrap.Modal(document.getElementById("eventModal"));


                    $("#title").val(event.title);
                    $("#status").val(event.status);
                    $("#description").val(event.description);
                    $("#event_date").val(event.event_date);
                    $("#event_time").val(event.event_time.substring(0, 5));
                    $("#location").val(event.location);
                    $("#street").val(event.street);
                    $("#postCode").val(event.post_code);
                    $("#city").val(event.city);
                    $("#max_participants").val(event.max_participants);
                    $("#registration_deadline").val(event.registration_deadline);

                    $("#addEvent").attr("data-id", event.event_id);

                    $("#eventModal .modal-title").text("Event bearbeiten");

                    $("#saveEvent").html('<i class="bi bi-floppy"></i> Änderungen speichern');

                    console.log(event);

                    console.log($("#title").val());
                    console.log($("#date").val());
                    console.log($("#location").val());

                    console.log($("#date").length);
                    console.log($("#title").length);
                    console.log($("#eventModal").length);

                    modal.show();

                }

            });
        });


        //delete Event
        $(".deleteEvent").on("click", function () {
            if (!confirm("Möchtest du dieses Event wirklich löschen?")) {
                return;
            }

            var id = $(this).closest("tr").data("id");

            $.ajax({
                url: "/Uver/pvs-admin-dashboard/backend/backend-events.php",
                method: "POST",
                data: {
                    deleteEvent: 1,
                    id: id
                },
                success: function (response) {
                    if (response.trim() === "success") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function () {
                    alert("Unerwarteter Fehler.")
                }

            });
        });

        //Events Teilnehmer exportieren
        $(".exportParticipants").on("click", function () {

            var id = $(this).closest("tr").data("id");

            var form = $('<form>', {
                method: 'POST',
                action: '/Uver/pvs-admin-dashboard/backend/backend-events.php'
            });

            form.append($('<input>', {
                type: 'hidden',
                name: 'exportParticipants',
                value: 1
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            }));

            $('body').append(form);

            form.submit();

            form.remove();

        });

        //Show register
        $(".showRegistrations").on("click", function () {

            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/pvs-admin-dashboard/backend/backend-events.php",

                method: "POST",

                data: {

                    showRegistrations: 1,
                    id: id

                },

                success: function (response) {

                    var registrations = JSON.parse(response);

                    var html = "";

                    registrations.forEach(function (user) {

                        html += `
                    <tr>

                        <td>${user.user_id}</td>

                        <td>
                            ${user.last_name}
                            ${user.first_name}
                        </td>

                        <td>${user.email}</td>

                        <td>${user.phone}</td>

                        <td>${user.status}</td>

                        <td>${user.registered_at}</td>

                    </tr>
                `;

                    });

                    $("#registrationTableBody").html(html);

                    var modal = new bootstrap.Modal(
                        document.getElementById("registrationModal")
                    );

                    modal.show();

                }

            });

        });


        //filter Events
        $("#filterEvent").on("click", function () {

            var eventTitle = $("#eventTitle").val().trim().toLowerCase();
            var eventDateFrom = $("#eventDateFrom").val();
            var eventDateTo = $("#eventDateTo").val();
            var eventStatus = $("#eventStatus").val();

            console.log(eventDateFrom);
            console.log(eventDateTo);

            $("#tableBody tr").each(function () {

                var row = $(this);

                var title = row.children().eq(1).text().trim().toLowerCase();
                var date = row.children().eq(2).text().trim(); // Must be YYYY-MM-DD
                var status = row.children().eq(6).text().trim();

                var matches = true;

                // Title filter
                if (eventTitle !== "" && !title.includes(eventTitle)) {
                    matches = false;
                }

                // Status filter
                if (eventStatus !== "" && eventStatus !== "Alle Status" && status !== eventStatus) {
                    matches = false;
                }

                // Date From filter
                if (eventDateFrom !== "" && date < eventDateFrom) {
                    matches = false;
                }

                // Date To filter
                if (eventDateTo !== "" && date > eventDateTo) {
                    matches = false;
                }

                row.toggle(matches);
            });

        });
    });
</script>

<?php require_once MODALS_PATH . '/modal-event_form.php'; ?>

<?php require_once MODALS_PATH . '/modal-event_show.php'; ?>

<?php require_once MODALS_PATH . '/modal-register_show.php'; ?>
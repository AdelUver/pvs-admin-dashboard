<style>
    .page-title {

        font-size: 30px;
        font-weight: 700;
        color: #1f2937;

        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: auto;
        width: auto;
        margin: 0;

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


    .filter-box {

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
$events = getAllEvents($pdo);

?>

<div class="container-fluid" id="eventsSection">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="page-title">

            Events

        </h2>

        <button type="button" class="btn btn-primary" id="addEventButton">

            <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>

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

                    <option value="">Alle Status</option>
                    <option value="planned">Geplant</option>
                    <option value="full">Ausgebucht</option>
                    <option value="completed">Abgeschlossen</option>
                    <option value="cancelled">Abgesagt</option>

                </select>

            </div>

            <div class="col-lg-2">

                <button type="button" class="btn btn-outline-primary w-100" id="filterEvent">

                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>

                    Filtern

                </button>

            </div>

        </div>

    </div>

    <div class="card event-card">

        <div class="card-body">

            <div class="table-responsive">
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

                    <tr id="eventEmptyState" <?= $events ? 'hidden' : '' ?>>
                        <td colspan="8">Keine Events gefunden.</td>
                    </tr>

                    <?php foreach ($events as $event): ?>

                        <tr data-id="<?= (int) $event['event_id'] ?>"
                            data-status="<?= htmlspecialchars($event['status'], ENT_QUOTES, 'UTF-8') ?>">

                            <td>

                                <?= $event["event_id"] ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["title"], ENT_QUOTES, 'UTF-8') ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["event_date"], ENT_QUOTES, 'UTF-8') ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["event_time"], ENT_QUOTES, 'UTF-8') ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($event["location"], ENT_QUOTES, 'UTF-8') ?>

                            </td>

                            <td>

                                <?= (int) $event["max_participants"] ?>

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
                                        echo '<span class="badge bg-danger">Unbekannt</span>';
                                }

                                ?>

                            </td>

                            <td class="text-center">

                                <button type="button" class="btn btn-outline-info btn-sm action-btn showEvent"
                                    title="Details anzeigen" aria-label="Details anzeigen">

                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>

                                </button>

                                <button type="button" class="btn btn-outline-warning btn-sm action-btn updateEvent"
                                    title="Event bearbeiten" aria-label="Event bearbeiten">

                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>

                                </button>

                                <button type="button" class="btn btn-outline-success btn-sm action-btn exportParticipants"
                                    title="Teilnehmer exportieren" aria-label="Teilnehmer exportieren">

                                    <i class="fa-solid fa-download" aria-hidden="true"></i>

                                </button>

                                <button type="button" class="btn btn-outline-danger btn-sm action-btn deleteEvent"
                                    title="Event löschen" aria-label="Event löschen">

                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>

                                </button>

                                <button type="button" class="btn btn-outline-primary btn-sm action-btn showRegistrations"
                                    title="Anmeldungen anzeigen" aria-label="Anmeldungen anzeigen">

                                    <i class="fa-solid fa-users" aria-hidden="true"></i>

                                </button>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

                </table>
            </div>

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
    const eventEndpoint = <?= json_encode(BACKEND_URL . '/backend-events.php', JSON_UNESCAPED_SLASHES) ?>;
    const loginUrl = <?= json_encode(BASE_URL . '/login', JSON_UNESCAPED_SLASHES) ?>;

    $(document).ready(function () {
        const eventForm = $("#addEvent");
        const eventDialog = document.getElementById("eventModal");

        function showRequestError(xhr, fallbackMessage) {
            if (xhr.status === 401) {
                window.location.href = loginUrl;
                return;
            }

            alert((xhr.responseText || "").trim() || fallbackMessage);
        }

        function resetEventForm() {
            eventForm[0].reset();
            eventForm.removeAttr("data-event-id");
            $("#eventModalTitle").text("Neues Event erstellen");
            $("#saveEvent").html(
                '<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Event speichern'
            );
        }

        $("#addEventButton").on("click", function () {
            resetEventForm();
            eventDialog.showModal();
        });

        eventForm.on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            var eventId = eventForm.attr("data-event-id");

            if (eventId) {
                formData.append("updateEvent", 1);
                formData.append("id", eventId);
            } else {
                formData.append("createEvent", 1);
            }

            $.ajax({
                url: eventEndpoint,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.trim() === "success") {
                        resetEventForm();
                        eventDialog.close();
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function (xhr) {
                    showRequestError(xhr, "Das Event konnte nicht gespeichert werden.");
                }
            });
        });

        $(".showEvent").on("click", function () {
            var id = $(this).closest("tr").attr("data-id");
            $.ajax({
                url: eventEndpoint,
                method: "POST",
                dataType: "json",
                data: {
                    showEvent: 1,
                    id: id
                },
                success: function (response) {
                    var event = response;
                    var statusLabels = {
                        planned: "Geplant",
                        full: "Ausgebucht",
                        completed: "Abgeschlossen",
                        cancelled: "Abgesagt"
                    };
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
                    $("#show_status").text(statusLabels[event.status] || event.status);

                    $("#show_created_at").text(event.created_at);
                    $("#show_updated_at").text(event.updated_at);
                    $("#show_created_by").text([event.created_last_name, event.created_first_name].filter(Boolean).join(" "));
                    $("#show_updated_by").text([event.updated_last_name, event.updated_first_name].filter(Boolean).join(" "));
                    document.getElementById("showEventModal").showModal();
                },
                error: function (xhr) {
                    showRequestError(xhr, "Die Eventdetails konnten nicht geladen werden.");
                }
            });
        });

        $(".updateEvent").on("click", function () {
            var id = $(this).closest("tr").attr("data-id");
            $.ajax({
                url: eventEndpoint,
                method: "POST",
                dataType: "json",
                data: {
                    updateEvent: 1,
                    id: id,
                    load: 1
                },
                success: function (event) {
                    $("#title").val(event.title);
                    $("#status").val(event.status);
                    $("#description").val(event.description);
                    $("#event_date").val(event.event_date);
                    $("#event_time").val(String(event.event_time || "").slice(0, 5));
                    $("#location").val(event.location);
                    $("#street").val(event.street);
                    $("#postCode").val(event.post_code);
                    $("#city").val(event.city);
                    $("#max_participants").val(event.max_participants);
                    $("#registration_deadline").val(event.registration_deadline);

                    eventForm.attr("data-event-id", event.event_id);
                    $("#eventModalTitle").text("Event bearbeiten");
                    $("#saveEvent").html('<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Änderungen speichern');
                    eventDialog.showModal();
                },
                error: function (xhr) {
                    showRequestError(xhr, "Das Event konnte nicht zum Bearbeiten geladen werden.");
                }
            });
        });

        $(".deleteEvent").on("click", function () {
            if (!confirm("Möchtest du dieses Event wirklich löschen?")) {
                return;
            }

            var id = $(this).closest("tr").attr("data-id");
            $.ajax({
                url: eventEndpoint,
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
                error: function (xhr) {
                    showRequestError(xhr, "Das Event konnte nicht gelöscht werden.");
                }
            });
        });

        $(".exportParticipants").on("click", function () {
            var form = document.createElement("form");
            form.method = "POST";
            form.action = eventEndpoint;
            form.hidden = true;

            [["exportParticipants", 1], ["id", $(this).closest("tr").attr("data-id")]].forEach(function (item) {
                var input = document.createElement("input");
                input.type = "hidden";
                input.name = item[0];
                input.value = item[1];
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        });

        $(".showRegistrations").on("click", function () {
            var id = $(this).closest("tr").attr("data-id");
            $.ajax({
                url: eventEndpoint,
                method: "POST",
                dataType: "json",
                data: {
                    showRegistrations: 1,
                    id: id
                },
                success: function (response) {
                    var body = document.getElementById("registrationTableBody");
                    body.replaceChildren();

                    response.forEach(function (registration) {
                        var row = document.createElement("tr");
                        var statusLabels = {
                            registered: "Angemeldet",
                            cancelled: "Storniert",
                            waitlisted: "Warteliste"
                        };
                        var values = [
                            registration.user_id,
                            [registration.last_name, registration.first_name].filter(Boolean).join(" "),
                            registration.email,
                            statusLabels[registration.status] || registration.status,
                            registration.registered_at
                        ];

                        values.forEach(function (value) {
                            var cell = document.createElement("td");
                            cell.textContent = value == null ? "" : value;
                            row.appendChild(cell);
                        });

                        body.appendChild(row);
                    });

                    if (response.length === 0) {
                        var emptyRow = document.createElement("tr");
                        var emptyCell = document.createElement("td");
                        emptyCell.colSpan = 5;
                        emptyCell.textContent = "Für dieses Event gibt es keine Anmeldungen.";
                        emptyRow.appendChild(emptyCell);
                        body.appendChild(emptyRow);
                    }

                    document.getElementById("registrationModal").showModal();
                },
                error: function (xhr) {
                    showRequestError(xhr, "Die Eventanmeldungen konnten nicht geladen werden.");
                }
            });
        });

        $("#filterEvent").on("click", function () {
            var eventTitle = $("#eventTitle").val().trim().toLowerCase();
            var eventDateFrom = $("#eventDateFrom").val();
            var eventDateTo = $("#eventDateTo").val();
            var eventStatus = $("#eventStatus").val();

            if (eventDateFrom && eventDateTo && eventDateFrom > eventDateTo) {
                alert("Das Startdatum darf nicht nach dem Enddatum liegen.");
                return;
            }

            var visibleEvents = 0;
            $("#tableBody tr[data-id]").each(function () {
                var row = $(this);
                var title = row.children().eq(1).text().trim().toLowerCase();
                var date = row.children().eq(2).text().trim();
                var status = row.attr("data-status");
                var matches = (!eventTitle || title.includes(eventTitle)) &&
                    (!eventStatus || status === eventStatus) &&
                    (!eventDateFrom || date >= eventDateFrom) &&
                    (!eventDateTo || date <= eventDateTo);

                row.toggle(matches);
                if (matches) {
                    visibleEvents += 1;
                }
            });

            $("#eventEmptyState")
                .prop("hidden", visibleEvents > 0)
                .children("td")
                .text(visibleEvents === 0 ? "Keine passenden Events gefunden." : "");
        });
    });
</script>

<?php require_once MODALS_PATH . '/modal-event_form.php'; ?>

<?php require_once MODALS_PATH . '/modal-event_show.php'; ?>

<?php require_once MODALS_PATH . '/modal-register_show.php'; ?>
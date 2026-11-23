<?php
$pdo = getDB();
$upcomingEvents = getUpcomingEvents($pdo);

?>

<div class="row mt-5">

    <!-- Überschrift -->
    <div class="col-12 mb-4">

        <h3 class="fw-bold mb-1">Bevorstehende Events</h3>

        <p class="text-muted mb-0">
            Übersicht der nächsten geplanten Veranstaltungen.
        </p>

    </div>

    <div class="col-12">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="bi bi-calendar-event me-2"></i>

                    Bevorstehende Events

                </h5>

                <a href="/Uver/loginPVS/events#eventsSection"
                    class="btn btn-outline-primary rounded-pill px-3">

                    <i class="bi bi-arrow-right-circle me-2"></i>

                    Zur Eventverwaltung

                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Event-ID</th>
                                <th>Veranstaltung</th>
                                <th>Datum</th>
                                <th>Uhrzeit</th>
                                <th>Ort</th>
                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody id="upcomingEventsBody">

                            <?php foreach ($upcomingEvents as $event): ?>

                                <tr>

                                    <td><?= $event['event_id'] ?></td>

                                    <td><?= htmlspecialchars($event['title']) ?></td>

                                    <td><?= date("d.m.Y", strtotime($event['event_date'])) ?></td>

                                    <td><?= substr($event['event_time'], 0, 5) ?></td>

                                    <td><?= htmlspecialchars($event['location']) ?></td>

                                    <td>

                                        <?php

                                        switch ($event['status']) {

                                            case 'planned':
                                                echo '<span class="badge bg-primary">Geplant</span>';
                                                break;

                                            case 'full':
                                                echo '<span class="badge bg-success">Ausgebucht</span>';
                                                break;

                                            case 'completed':
                                                echo '<span class="badge bg-secondary">Abgeschlossen</span>';
                                                break;

                                            case 'cancelled':
                                                echo '<span class="badge bg-danger">Abgesagt</span>';
                                                break;
                                        }

                                        ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
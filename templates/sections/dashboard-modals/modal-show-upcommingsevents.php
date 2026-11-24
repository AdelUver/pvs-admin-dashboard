<?php
$pdo = getDB();
$upcomingEvents = getUpcomingEvents($pdo);

?>

<section class="row mt-5" aria-labelledby="dashboard-upcoming-heading">

    <!-- Überschrift -->
    <div class="col-12 mb-4">

        <h2 class="fw-bold mb-1" id="dashboard-upcoming-heading">Bevorstehende Events</h2>

        <p class="text-muted mb-0">
            Übersicht der nächsten geplanten Veranstaltungen.
        </p>

    </div>

    <div class="col-12">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="mb-0">

                    <i class="fa-solid fa-calendar-days me-2" aria-hidden="true"></i>

                    Bevorstehende Events

                </h3>

                <a href="<?= BASE_URL ?>/events#eventsSection"
                    class="btn btn-outline-primary rounded-pill px-3">

                    <i class="fa-solid fa-circle-arrow-right me-2" aria-hidden="true"></i>

                    Zur Eventverwaltung

                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive" role="region" aria-label="Bevorstehende Events" tabindex="0">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th scope="col">Event-ID</th>
                                <th scope="col">Veranstaltung</th>
                                <th scope="col">Datum</th>
                                <th scope="col">Uhrzeit</th>
                                <th scope="col">Ort</th>
                                <th scope="col">Status</th>

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

</section>
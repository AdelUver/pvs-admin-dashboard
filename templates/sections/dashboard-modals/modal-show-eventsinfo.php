<?php
$pdo = getDB();
$dashboard = getEventsData($pdo);
?>

<section class="row g-4 mt-4" aria-labelledby="dashboard-events-heading">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1" id="dashboard-events-heading">Eventverwaltung</h2>

                <p class="text-muted mb-0">
                    Übersicht über alle Events und deren aktuellen Status.
                </p>

            </div>

        </div>

    </div>

    <!-- Events gesamt -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Events gesamt</h3>

                <p class="dashboard-value"><?= countAlleEvents($pdo) ?></p>

            </div>

        </div>
    </div>

    <!-- Aktive Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="fa-solid fa-calendar-check text-success" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Aktive Events</h3>

                <p class="dashboard-value"><?= $dashboard['events'] ?></p>

            </div>

        </div>

    </div>

    <!-- Geplante Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-info">

            <div class="dashboard-icon text-info">
                <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Geplante Events</h3>

                <p class="dashboard-value"><?= $dashboard['planned'] ?></p>

            </div>

        </div>

    </div>

    <!-- Ausgebuchte Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="fa-solid fa-users" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Ausgebuchte Events</h3>

                <p class="dashboard-value"><?= $dashboard['full'] ?></p>

            </div>

        </div>

    </div>

    <!-- Abgeschlossene Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-secondary">

            <div class="dashboard-icon text-secondary">
                <i class="fa-solid fa-circle-check text-success" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Abgeschlossene Events</h3>

                <p class="dashboard-value"><?= $dashboard['completed'] ?></p>

            </div>

        </div>

    </div>

    <!-- Abgesagte Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="fa-solid fa-calendar-xmark" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Abgesagte Events</h3>

                <p class="dashboard-value"><?= $dashboard['cancelled'] ?></p>

            </div>

        </div>

    </div>

    <!-- Gelöschte Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="fa-solid fa-calendar-minus" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Gelöschte Events</h3>

                <p class="dashboard-value"><?= getDeletedEvents($pdo); ?></p>

            </div>

        </div>

    </div>

</section>
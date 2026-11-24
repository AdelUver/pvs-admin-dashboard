<?php
$pdo = getDB();
$dashboard = getEventsData($pdo);
?>

<div class="row g-4 mt-4">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">Eventverwaltung</h3>

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

                <h6>Events gesamt</h6>

                <h2><?= countAlleEvents($pdo) ?></h2>

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

                <h6>Aktive Events</h6>

                <h2><?= $dashboard['events'] ?></h2>

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

                <h6>Geplante Events</h6>

                <h2><?= $dashboard['planned'] ?></h2>

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

                <h6>Ausgebuchte Events</h6>

                <h2><?= $dashboard['full'] ?></h2>

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

                <h6>Abgeschlossene Events</h6>

                <h2><?= $dashboard['completed'] ?></h2>

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

                <h6>Abgesagte Events</h6>

                <h2><?= $dashboard['cancelled'] ?></h2>

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

                <h6>Gelöschte Events</h6>

                <h2><?= getDeletedEvents($pdo); ?></h2>

            </div>

        </div>

    </div>

</div>
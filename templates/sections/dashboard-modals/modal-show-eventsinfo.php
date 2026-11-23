<?php
$pdo = getDB();
$dashboard = getDashboardData($pdo);
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
                <i class="bi bi-calendar-event"></i>
            </div>

            <div class="dashboard-content">

                <h6>Events gesamt</h6>

                <h2><?= $dashboard['events'] ?></h2>

            </div>

        </div>

    </div>

    <!-- Geplante Events -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-info">

            <div class="dashboard-icon text-info">
                <i class="bi bi-calendar-check"></i>
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
                <i class="bi bi-people-fill"></i>
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
                <i class="bi bi-check2-circle"></i>
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
                <i class="bi bi-calendar-x"></i>
            </div>

            <div class="dashboard-content">

                <h6>Abgesagte Events</h6>

                <h2><?= $dashboard['cancelled'] ?></h2>

            </div>

        </div>

    </div>

</div>
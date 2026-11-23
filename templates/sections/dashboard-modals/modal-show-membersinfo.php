<?php
$pdo = getDB();
$dashboard = getDashboardData($pdo);
?>

<div class="row g-4 mt-5">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="mb-4">

            <h3 class="fw-bold mb-1">Mitglieder</h3>

            <p class="text-muted mb-0">
                Übersicht über den aktuellen Mitgliederbestand und dessen Entwicklung.
            </p>

        </div>

    </div>

    <!-- Aktive Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div class="dashboard-content">

                <h6>Aktive Mitglieder</h6>

                <h2><?=  countActiveMembers($pdo) ?></h2>

            </div>

        </div>

    </div>

    <!-- Gesperrte Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="bi bi-person-x-fill"></i>
            </div>

            <div class="dashboard-content">

                <h6>Gesperrte Mitglieder</h6>

                <h2><?= countBlockedMembers($pdo) ?></h2>

            </div>

        </div>

    </div>

    <!-- Neue Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <div class="dashboard-content">

                <h6>Neue Mitglieder (diesen Monat)</h6>

                <h2><?= countNewMembersThisMonth($pdo) ?></h2>

            </div>

        </div>

    </div>

</div>
<?php
$pdo = getDB();
$dashboard = getDashboardData($pdo);
?>

<div class="row g-4 mt-4">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">Benutzerverwaltung</h3>

                <p class="text-muted mb-0">
                    Übersicht über alle registrierten Benutzer und Administratorrollen.
                </p>

            </div>

        </div>

    </div>

    <!-- Benutzer gesamt -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="bi bi-people"></i>
            </div>

            <div class="dashboard-content">

                <h6>Benutzer gesamt</h6>

                <h2><?= $dashboard['users'] ?></h2>

            </div>

        </div>

    </div>

    <!-- Super Admins -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="bi bi-shield-fill-check"></i>
            </div>

            <div class="dashboard-content">

                <h6>Super Admins</h6>

                <h2><?= $dashboard['super_admins'] ?></h2>

            </div>

        </div>

    </div>

    <!-- Administratoren -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-warning">

            <div class="dashboard-icon text-warning">
                <i class="bi bi-person-badge"></i>
            </div>

            <div class="dashboard-content">

                <h6>Administratoren</h6>

                <h2><?= $dashboard['admins'] ?></h2>

            </div>

        </div>

    </div>

    <!-- Editoren -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div class="dashboard-content">

                <h6>Editoren</h6>

                <h2><?= $dashboard['editors'] ?></h2>

            </div>

        </div>

    </div>

</div>
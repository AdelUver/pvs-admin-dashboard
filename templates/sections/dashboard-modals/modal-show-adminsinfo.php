<?php
$pdo = getDB();
$dashboard = getAdmisData($pdo);
?>

<div class="row g-4 mt-4">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">Adminverwaltung</h3>

                <p class="text-muted mb-0">
                    Übersicht über alle registrierten Admins und Administratorrollen.
                </p>

            </div>

        </div>

    </div>

    <!-- Admins gesamt -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="fa-solid fa-users" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h6>Admins gesamt</h6>

                <h2><?= $dashboard['users'] ?></h2>

            </div>

        </div>

    </div>

    <!-- Super Admins -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
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
                <i class="fa-solid fa-id-badge" aria-hidden="true"></i>
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
                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h6>Editoren</h6>

                <h2><?= $dashboard['editors'] ?></h2>

            </div>

        </div>

    </div>

</div>
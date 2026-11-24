<?php
$pdo = getDB();
$dashboard = getAdmisData($pdo);
?>

<section class="row g-4 mt-4" aria-labelledby="dashboard-admins-heading">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1" id="dashboard-admins-heading">Adminverwaltung</h2>

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

                <h3>Admins gesamt</h3>

                <p class="dashboard-value"><?= $dashboard['users'] ?></p>

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

                <h3>Super Admins</h3>

                <p class="dashboard-value"><?= $dashboard['super_admins'] ?></p>

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

                <h3>Administratoren</h3>

                <p class="dashboard-value"><?= $dashboard['admins'] ?></p>

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

                <h3>Editoren</h3>

                <p class="dashboard-value"><?= $dashboard['editors'] ?></p>

            </div>

        </div>

    </div>

</section>
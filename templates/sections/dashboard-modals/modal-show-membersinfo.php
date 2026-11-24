<?php
$pdo = getDB();
// $dashboard = getEventsData($pdo);
?>

<section class="row g-4 mt-5" aria-labelledby="dashboard-members-heading">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="mb-4">

            <h2 class="fw-bold mb-1" id="dashboard-members-heading">Mitglieder</h2>

            <p class="text-muted mb-0">
                Übersicht über den aktuellen Mitgliederbestand und dessen Entwicklung.
            </p>

        </div>

    </div>

    <!-- Aktive Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="fa-solid fa-user-check" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Aktive Mitglieder</h3>

                <p class="dashboard-value"><?= countActiveMembers($pdo) ?></p>

            </div>

        </div>

    </div>

    <!-- Gesperrte Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="fa-solid fa-user-xmark" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Gesperrte Mitglieder</h3>

                <p class="dashboard-value"><?= countBlockedMembers($pdo) ?></p>

            </div>

        </div>

    </div>

    <!-- Neue Mitglieder -->
    <div class="col-xl-4 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Neue Mitglieder (diesen Monat)</h3>

                <p class="dashboard-value"><?= countNewMembersThisMonth($pdo) ?></p>

            </div>

        </div>

    </div>

</section>
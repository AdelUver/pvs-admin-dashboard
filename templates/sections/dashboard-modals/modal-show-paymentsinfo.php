<?php
$pdo = getDB();
$dashboard = getEventsData($pdo);
?>

<section class="row g-4 mt-5" aria-labelledby="dashboard-payments-heading">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="mb-4">

            <h2 class="fw-bold mb-1" id="dashboard-payments-heading">Finanzen & Zahlungen</h2>

            <p class="text-muted mb-0">
                Übersicht über Umsätze, offene Zahlungen und den aktuellen Zahlungsstatus.
            </p>

        </div>

    </div>

    <!-- Monatlicher Umsatz -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="fa-solid fa-coins" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Monatlicher Umsatz</h3>

                <p class="dashboard-value">Monatlicher Umsatz</p>

            </div>

        </div>

    </div>

    <!-- Jährlicher Umsatz -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Jährlicher Umsatz</h3>

                <p class="dashboard-value">Jährlicher Umsatz</p>

            </div>

        </div>

    </div>

    <!-- Offene Zahlungen -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-warning">

            <div class="dashboard-icon text-warning">
                <i class="fa-solid fa-credit-card" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Offene Zahlungen</h3>

                <p class="dashboard-value">Offene Zahlungen</p>

            </div>

        </div>

    </div>

    <!-- Zahlungsausfälle -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
            </div>

            <div class="dashboard-content">

                <h3>Zahlungsausfälle</h3>

                <p class="dashboard-value">Zahlungsausfälle</p>

            </div>

        </div>

    </div>

</section>
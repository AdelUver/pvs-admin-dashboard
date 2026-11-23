<?php
$pdo = getDB();
$dashboard = getDashboardData($pdo);
?>

<div class="row g-4 mt-5">

    <!-- Überschrift -->
    <div class="col-12">

        <div class="mb-4">

            <h3 class="fw-bold mb-1">Finanzen & Zahlungen</h3>

            <p class="text-muted mb-0">
                Übersicht über Umsätze, offene Zahlungen und den aktuellen Zahlungsstatus.
            </p>

        </div>

    </div>

    <!-- Monatlicher Umsatz -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-success">

            <div class="dashboard-icon text-success">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="dashboard-content">

                <h6>Monatlicher Umsatz</h6>

                <h2>Monatlicher Umsatz</h2>

            </div>

        </div>

    </div>

    <!-- Jährlicher Umsatz -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-primary">

            <div class="dashboard-icon text-primary">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div class="dashboard-content">

                <h6>Jährlicher Umsatz</h6>

                <h2>Jährlicher Umsatz</h2>

            </div>

        </div>

    </div>

    <!-- Offene Zahlungen -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-warning">

            <div class="dashboard-icon text-warning">
                <i class="bi bi-credit-card"></i>
            </div>

            <div class="dashboard-content">

                <h6>Offene Zahlungen</h6>

                <h2>Offene Zahlungen</h2>

            </div>

        </div>

    </div>

    <!-- Zahlungsausfälle -->
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="dashboard-card border-danger">

            <div class="dashboard-icon text-danger">
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <div class="dashboard-content">

                <h6>Zahlungsausfälle</h6>

                <h2>Zahlungsausfälle</h2>

            </div>

        </div>

    </div>

</div>
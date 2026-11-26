<?php

require_once FUNCTIONS_PATH . '/dashboard.php';
require_once FUNCTIONS_PATH . '/function-db.php';

$pdo = getDB();
$userId = $_SESSION['userId'];

if (isset($_POST["loadAllEvents"])) {
    $upcomingEvents = getUpcomingEvents($pdo, 9999);
    exit();
}


//Daten


$upcomingEvents = getUpcomingEvents($pdo);


?>

<style>
    .dashboard-ui .dashboard-card {
        display: flex;
        height: 100%;
        align-items: center;
        gap: 20px;
        padding: 25px;
        border-left: 5px solid;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 .15rem .75rem rgba(0, 0, 0, .08);
        transition: all .25s ease;
    }

    .dashboard-ui .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.25rem rgba(0, 0, 0, .15);
    }

    .dashboard-ui .dashboard-icon {
        width: 70px;
        text-align: center;
        font-size: 3rem;
    }

    .dashboard-ui .dashboard-content {
        min-width: 0;
        flex: 1;
        overflow-wrap: anywhere;
    }

    .dashboard-ui .dashboard-content p {
        overflow-wrap: anywhere;
    }

    .dashboard-ui .dashboard-content h3 {
        margin: 0;
        color: #6c757d;
        font-size: .9rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .dashboard-ui .dashboard-content .dashboard-value {
        margin-top: 8px;
        margin-bottom: 0;
        color: var(--pvs-text-dark);
        font-size: 2.2rem;
        font-weight: 700;
    }

    @media (max-width: 767px) {
        .dashboard-ui .dashboard-card { padding: 20px; }
        .dashboard-ui .dashboard-icon { width: 60px; font-size: 2.4rem; }
        .dashboard-ui .dashboard-content .dashboard-value { font-size: 1.8rem; }
    }
</style>

<header class="section-heading">
    <h1 class="page-title">Dashboard</h1>
</header>


<!-- Show Events info -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-eventsinfo.php'; ?>


<hr>

<!-- Show Admins info -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-adminsinfo.php'; ?>


<hr>


<!-- Nächtes Event -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-upcommingsevents.php'; ?>

<hr>

<!-- Mitgelieder Info -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-membersinfo.php'; ?>

<hr>

<!-- Zahlungs Info -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-paymentsinfo.php'; ?>

<hr>

<!-- Zahlungs Info -->
<?php require_once DASHBOARD_MODALS_PATH . '/modal-show-leadsinfo.php'; ?>


<script>
    $(document).ready(function () {
        $("#showAllEvents").on("click", function () {

            $.ajax({

                url: "/Uver/pvs-admin-dashboard/backend/backend-dashboard.php",

                method: "POST",

                data: {
                    loadAllEvents: 1
                },

                success: function (response) {

                    $("#upcomingEventsBody").html(response);

                }

            });

        });
    });
</script>
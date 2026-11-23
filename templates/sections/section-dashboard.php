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
    .page-title {

        font-size: 30px;
        font-weight: 700;
        color: #1f2937;

        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: 100px;
        width: 100px;

    }

    .dashboard-card {
        background: #fff;
        border-left: 5px solid;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        height: 100%;
        box-shadow: 0 .15rem .75rem rgba(0, 0, 0, .08);
        transition: all .25s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.25rem rgba(0, 0, 0, .15);
    }

    .dashboard-icon {
        width: 70px;
        text-align: center;
        font-size: 3rem;
    }

    .dashboard-content {
        flex: 1;
    }

    .dashboard-content h6 {
        margin: 0;
        color: #6c757d;
        font-size: .9rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .dashboard-content h2 {
        margin-top: 8px;
        margin-bottom: 0;
        font-size: 2.2rem;
        font-weight: 700;
        color: #212529;
    }

    @media (max-width:768px) {

        .dashboard-card {
            padding: 20px;
        }

        .dashboard-icon {
            font-size: 2.4rem;
            width: 60px;
        }

        .dashboard-content h2 {
            font-size: 1.8rem;
        }

    }
</style>



<!-- <h2 class="page-title">
    Dashboard
</h2> -->


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

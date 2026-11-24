<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header('Location: ' . BASE_URL . '/login');
    exit();
}

$requestedRoute = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$sectionRoutes = ['dashboard', 'events', 'users', 'courses', 'profile', 'settings'];

$currentRoute = in_array($requestedRoute, $sectionRoutes, true) ? $requestedRoute : 'dashboard';
?>

<style>
    body {

        margin: 0;
        background: #f4f6fb;
        font-family: Segoe UI, sans-serif;

    }

    .main-content {

        margin-left: 260px;
        transition: .3s;

    }

    .main-content.expanded {

        margin-left: 80px;

    }

    .content {

        padding: 30px;

    }
</style>

<!DOCTYPE html>

<html lang="de">

<!-- Head einbinden -->
<?php $includeAppStyles = true; ?>
<?php include_once SECTIONS_PATH . '/section-head.php'; ?>

<body class="dashboard-ui">

    <?php include SECTIONS_PATH . '/section-sidebar.php'; ?>

    <div class="main-content" id="mainContent">

        <?php include SECTIONS_PATH . '/section-topbar.php'; ?>

        <div class="content">

            <?php include SECTIONS_PATH . '/section-' . $currentRoute . '.php'; ?>

        </div>

    </div>

</body>

</html>


<script>
    const sidebar = document.getElementById("sidebar");

    const content = document.getElementById("mainContent");

    document.getElementById("toggleSidebar").onclick = function () {

        sidebar.classList.toggle("collapsed");

        content.classList.toggle("expanded");

    };
</script>
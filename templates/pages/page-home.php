<?php
global $url;
?>

<!DOCTYPE html>

<html lang="de">

<!-- Head einbinden -->
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/sections/section-head.php'; ?>


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

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/sections/section-sidebar.php'; ?>

    <div class="main-content" id="mainContent">

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/sections/section-topbar.php'; ?>

        <div class="content">

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/sections/section-" . $url . ".php"; ?>

        </div>

    </div>

    <script>
        const sidebar = document.getElementById("sidebar");

        const content = document.getElementById("mainContent");

        document.getElementById("toggleSidebar").onclick = function() {

            sidebar.classList.toggle("collapsed");

            content.classList.toggle("expanded");

        };
    </script>

</body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/scripts/script-profile.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/scripts/script-event.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/scripts/script-user.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
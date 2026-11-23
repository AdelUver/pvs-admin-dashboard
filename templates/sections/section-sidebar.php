<style>
    .sidebar {

        position: fixed;
        left: 0;
        top: 0;

        width: 260px;
        height: 100vh;

        background: #101828;

        color: white;

        transition: .3s;

    }


    .sidebar.collapsed {

        width: 80px;

    }

    .logo {
        filter: brightness(100);

        height: 70px;

        display: flex;

        justify-content: center;
        align-items: center;

    }

    .sidebar ul {

        list-style: none;

        margin: 0;

        padding: 20px 0;

    }

    .sidebar li {

        margin: 8px 12px;

    }

    .sidebar a {

        display: flex;

        align-items: center;

        gap: 15px;

        color: white;

        padding: 14px 18px;

        text-decoration: none;

        border-radius: 12px;

        transition: .2s;

    }

    .sidebar li.active a,
    .sidebar a:hover {

        background: #2563eb;

    }

    .sidebar.collapsed span {

        display: none;

    }

    .sidebar i {

        font-size: 20px;

        min-width: 24px;

    }
</style>


<?php

?>
<div class="sidebar" id="sidebar">

    <div class="logo">

        <span>Admin</span>
        <!-- <img src="assets/images/logo/Logo.jpg" alt="Firmenlogo" class="logo"> -->

    </div>

    <ul>

        <li class="<?= $url == "dashboard" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/dashboard">

                <i class="bi bi-speedometer2"></i>

                <span>Dashboard</span>

            </a>

        </li>

        <li class="<?= $url == "events" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/events">

                <i class="bi bi-calendar-event"></i>

                <span>Events</span>

            </a>

        </li>

        <li class="<?= $url == "users" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/users">

                <i class="bi bi-people"></i>

                <span>Benutzer</span>

            </a>

        </li>

        <li class="<?= $url == "courses" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/courses">

                <i class="bi bi-journal-bookmark"></i>

                <span>Kurse</span>

            </a>

        </li>

        <li class="<?= $url == "profile" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/profile">

                <i class="bi bi-person-circle"></i>

                <span>Profil</span>

            </a>

        </li>

        <li class="<?= $url == "settings" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/settings">

                <i class="bi bi-gear"></i>

                <span>Einstellungen</span>

            </a>

        </li>

    </ul>

    <div class="sidebar-footer">


        <li class="<?= $url == "logout" ? "active" : "" ?>">

            <a href="<?= BASE_URL ?>/logout" onclick="return confirm('Möchten Sie sich wirklich abmelden?');">


                <i class="bi bi-box-arrow-right"></i>

                <span>Logout</span>

            </a>

        </li>

    </div>

</div>
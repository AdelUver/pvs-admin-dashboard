<style>
    .sidebar {
        position: fixed;
        z-index: 20;
        inset: 0 auto 0 0;
        display: flex;
        width: 260px;
        height: 100vh;
        height: 100dvh;
        flex-direction: column;
        overflow-x: hidden;
        overflow-y: auto;
        background: #101828;
        color: #fff;
        transition: width .25s ease, transform .25s ease;
    }

    .sidebar__brand {
        display: flex;
        min-height: 72px;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        color: #fff;
        font-weight: 700;
        letter-spacing: .04em;
        text-decoration: none;
    }

    .sidebar__nav {
        flex: 1;
    }

    .sidebar__nav ul,
    .sidebar__footer {
        margin: 0;
        padding: .5rem .75rem;
        list-style: none;
    }

    .sidebar__nav li + li {
        margin-top: .35rem;
    }

    .sidebar__link {
        display: flex;
        min-height: 48px;
        align-items: center;
        gap: .9rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        color: #fff;
        text-decoration: none;
        transition: background-color .2s ease;
    }

    .sidebar__link:hover,
    .sidebar__link[aria-current="page"] {
        background: #2563eb;
    }

    .sidebar__link:focus-visible,
    .sidebar__brand:focus-visible {
        outline: 3px solid #f7d989;
        outline-offset: 2px;
    }

    .sidebar__link i {
        width: 1.5rem;
        flex: 0 0 1.5rem;
        text-align: center;
    }

    .sidebar__footer {
        padding-bottom: 1rem;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar.collapsed .sidebar__brand span,
    .sidebar.collapsed .sidebar__link span {
        display: none;
    }

    .sidebar.collapsed .sidebar__link {
        justify-content: center;
        padding-right: .5rem;
        padding-left: .5rem;
    }

    @media (max-width: 767px) {
        .sidebar {
            width: min(86vw, 300px);
            transform: translateX(-105%);
        }

        .sidebar.is-open {
            transform: translateX(0);
        }

        .sidebar.collapsed {
            width: min(86vw, 300px);
        }

        .sidebar.collapsed .sidebar__brand span,
        .sidebar.collapsed .sidebar__link span {
            display: inline;
        }

        .sidebar.collapsed .sidebar__link {
            justify-content: flex-start;
            padding-right: 1rem;
            padding-left: 1rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sidebar,
        .sidebar__link {
            transition-duration: .01ms;
        }
    }
</style>

<aside class="sidebar" id="sidebar" aria-label="Seitenleiste">
    <a class="sidebar__brand" href="<?= BASE_URL ?>/dashboard">
        <span>Private Value Society</span>
    </a>

    <nav class="sidebar__nav" aria-label="Hauptnavigation">
        <ul>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/dashboard" <?= $currentRoute === 'dashboard' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/events" <?= $currentRoute === 'events' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                    <span>Events</span>
                </a>
            </li>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/users" <?= $currentRoute === 'users' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                    <span>Benutzer</span>
                </a>
            </li>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/courses" <?= $currentRoute === 'courses' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                    <span>Kurse</span>
                </a>
            </li>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/profile" <?= $currentRoute === 'profile' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-circle-user" aria-hidden="true"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a class="sidebar__link" href="<?= BASE_URL ?>/settings" <?= $currentRoute === 'settings' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
                    <span>Einstellungen</span>
                </a>
            </li>
        </ul>
    </nav>

    <nav class="sidebar__footer" aria-label="Kontomenü">
        <a class="sidebar__link" href="<?= BASE_URL ?>/logout" onclick="return confirm('Möchten Sie sich wirklich abmelden?');">
            <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
            <span>Abmelden</span>
        </a>
    </nav>
</aside>

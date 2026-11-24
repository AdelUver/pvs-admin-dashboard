<?php
$pageTitles = [
    'dashboard' => 'Dashboard',
    'events' => 'Events',
    'users' => 'Benutzer',
    'courses' => 'Kurse',
    'profile' => 'Profil',
    'settings' => 'Einstellungen'
];
?>
<style>
    .topbar {
        position: sticky;
        z-index: 10;
        top: 0;
        display: flex;
        min-height: 68px;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .75rem clamp(1rem, 2.5vw, 2rem);
        border-bottom: 1px solid #e5e7eb;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 3px 12px rgba(0, 0, 0, .06);
        backdrop-filter: blur(12px);
    }

    .topbar__toggle {
        display: inline-flex;
        min-width: 44px;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        padding: .5rem .75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #111827;
        font: inherit;
        cursor: pointer;
    }

    .topbar__toggle:focus-visible {
        outline: 3px solid #2563eb;
        outline-offset: 2px;
    }

    .topbar__title {
        margin: 0;
        color: #374151;
        font-size: .95rem;
        font-weight: 600;
    }

    @media (max-width: 767px) {
        .topbar {
            min-height: 60px;
        }

        .topbar__toggle-label {
            display: none;
        }
    }
</style>

<header class="topbar">
    <button
        class="topbar__toggle"
        id="toggleSidebar"
        type="button"
        aria-controls="sidebar"
        aria-expanded="true"
        aria-label="Navigation einklappen">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
        <span class="topbar__toggle-label">Menü</span>
    </button>
    <p class="topbar__title"><?= htmlspecialchars($pageTitles[$currentRoute] ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></p>
</header>

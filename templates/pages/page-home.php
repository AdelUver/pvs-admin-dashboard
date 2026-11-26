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
<!DOCTYPE html>
<html lang="de">

<head>
    <?php include_once SECTIONS_PATH . '/section-head.php'; ?>
    
</head>

<body class="dashboard-ui">
    <?php include SECTIONS_PATH . '/section-sidebar.php'; ?>
    <button class="sidebar-backdrop" id="sidebarBackdrop" type="button" aria-label="Navigation schließen"
        hidden></button>

    <div class="main-content" id="mainContent">
        <?php include SECTIONS_PATH . '/section-topbar.php'; ?>
        <main class="content" id="pageContent" tabindex="-1">
            <?php include SECTIONS_PATH . '/section-' . $currentRoute . '.php'; ?>
        </main>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("mainContent");
            const toggle = document.getElementById("toggleSidebar");
            const backdrop = document.getElementById("sidebarBackdrop");
            const mobileNavigation = window.matchMedia("(max-width: 767px)");
            let mobileOpen = false;

            function updateMobileNavigation(open) {
                mobileOpen = open;
                sidebar.classList.toggle("is-open", open);
                backdrop.hidden = !open;
                sidebar.inert = !open;
                sidebar.setAttribute("aria-hidden", String(!open));
                mainContent.inert = open;
                toggle.setAttribute("aria-expanded", String(open));
                toggle.setAttribute("aria-label", open ? "Navigation schließen" : "Navigation öffnen");
                document.body.classList.toggle("sidebar-open", open);
            }

            function updateViewportMode() {
                if (mobileNavigation.matches) {
                    sidebar.inert = !mobileOpen;
                    sidebar.setAttribute("aria-hidden", String(!mobileOpen));
                    mainContent.inert = mobileOpen;
                    mainContent.classList.remove("expanded");
                    sidebar.classList.remove("collapsed");
                    backdrop.hidden = !mobileOpen;
                    toggle.setAttribute("aria-expanded", String(mobileOpen));
                    toggle.setAttribute("aria-label", mobileOpen ? "Navigation schließen" : "Navigation öffnen");
                } else {
                    mobileOpen = false;
                    sidebar.inert = false;
                    mainContent.inert = false;
                    sidebar.removeAttribute("aria-hidden");
                    sidebar.classList.remove("is-open");
                    backdrop.hidden = true;
                    document.body.classList.remove("sidebar-open");
                    toggle.setAttribute("aria-expanded", String(!sidebar.classList.contains("collapsed")));
                    mainContent.classList.toggle("expanded", sidebar.classList.contains("collapsed"));
                }
            }

            toggle.addEventListener("click", function () {
                if (mobileNavigation.matches) {
                    updateMobileNavigation(!mobileOpen);
                    if (mobileOpen) {
                        sidebar.querySelector("a").focus();
                    }
                    return;
                }

                const collapsed = sidebar.classList.toggle("collapsed");
                mainContent.classList.toggle("expanded", collapsed);
                toggle.setAttribute("aria-expanded", String(!collapsed));
                toggle.setAttribute("aria-label", collapsed ? "Navigation erweitern" : "Navigation einklappen");
            });

            backdrop.addEventListener("click", function () {
                updateMobileNavigation(false);
                toggle.focus();
            });

            document.addEventListener("keydown", function (event) {
                if (event.key === "Escape" && mobileNavigation.matches && mobileOpen) {
                    updateMobileNavigation(false);
                    toggle.focus();
                }
            });

            if (mobileNavigation.addEventListener) {
                mobileNavigation.addEventListener("change", updateViewportMode);
            } else {
                mobileNavigation.addListener(updateViewportMode);
            }
            updateViewportMode();
        }());
    </script>
</body>

</html>
<style>
    .page-title {

        font-size: 30px;
        font-weight: 700;
        color: #1f2937;

        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: auto;
        width: auto;
        margin: 0;

    }

    .user-card {

        border: none;
        border-radius: 15px;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

    }

    .table thead {

        background: #f8fafc;

    }

    .table th {

        color: #475569;
        font-weight: 600;

    }

    .badge {

        font-size: .85rem;

    }

    .action-btn {

        width: 36px;
        height: 36px;

        padding: 0;

    }


    .filter-box {

        background: white;

        padding: 20px;

        border-radius: 15px;

        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);

        margin-bottom: 20px;

    }
</style>

<?php

require_once FUNCTIONS_PATH . '/users.php';
require_once FUNCTIONS_PATH . '/function-db.php';


//Daten
$pdo = getDB();
$users = getAllUsers($pdo);
$currentUserRole = getUserRole($pdo, (int) $_SESSION['userId']) ?? '';
$canManageUsers = canManageUsers($currentUserRole);
$roleLabels = [
    'super_admin' => 'Superadmin',
    'admin' => 'Admin',
    'editor' => 'Editor',
    'user' => 'User'
];
$formatUserDate = static function ($value): string {
    if (!is_string($value) || $value === '' || strncmp($value, '0000-00-00', 10) === 0) {
        return '-';
    }

    $timestamp = strtotime($value);
    return $timestamp === false ? '-' : date('d.m.Y H:i', $timestamp);
};
?>

<section class="container-fluid" id="usersSection" aria-labelledby="usersTitle">

    <header class="section-heading">

        <h1 class="page-title" id="usersTitle">

            Admins

        </h1>

        <?php if ($canManageUsers): ?>

            <button type="button" class="btn btn-primary" id="addUserbtn">

                <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>

                Neuer Benutzer

            </button>

        <?php endif; ?>

    </header>

    <form class="filter-box" id="userFilterForm" role="search" aria-label="Admins filtern">

        <div class="user-filter-grid">

            <div>

                <label class="form-label" for="filter-email">E-Mail</label>
                <input type="text" class="form-control" placeholder="E-Mail suchen..." id="filter-email">

            </div>

            <div>

                <label class="form-label" for="filter-name">Vorname</label>
                <input type="text" class="form-control" placeholder="Name suchen..." id="filter-name">

            </div>

            <div>

                <label class="form-label" for="filter-lastname">Nachname</label>
                <input type="text" class="form-control" placeholder="Nachname suchen..." id="filter-lastname">

            </div>



            <div>

                <label class="form-label" for="filter-userRole">Rolle</label>
                <select class="form-select" id="filter-userRole">

                    <option value="">Alle Rollen</option>
                    <option value="super_admin">Superadmin</option>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                    <option value="user">User</option>

                </select>

            </div>

            <div>

                <button type="submit" class="btn btn-outline-primary w-100" id="filterUser">

                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>

                    Filtern

                </button>

        </div>

        </div>

    </form>

    <div class="card user-card">

        <div class="card-body">

            <div class="table-responsive" role="region" aria-label="Adminliste" tabindex="0">
                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th scope="col">ID</th>

                            <th scope="col">Vorname</th>

                            <th scope="col">Nachname</th>

                            <th scope="col">E-Mail</th>

                            <th scope="col">Rolle</th>

                            <th scope="col">Aktiv</th>

                            <th scope="col">Angemeldet seit</th>

                            <th scope="col">Letzter Login</th>

                            <th class="text-center" scope="col">

                                Aktionen

                            </th>

                        </tr>

                    </thead>

                    <tbody id="tableBody">

                        <?php if (!$users): ?>
                            <tr id="emptyUsersInitial">
                                <td colspan="9">Keine Admins vorhanden.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>


                                <tr data-id="<?= (int) $user['user_id'] ?>" data-role="<?= htmlspecialchars($user['role']) ?>">

                                    <td>

                                        <?= $user["user_id"] ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($user["first_name"]) ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($user["last_name"]) ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($user["email"]) ?>

                                    </td>

                                    <td>

                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($roleLabels[$user["role"]] ?? $user["role"]) ?>
                                        </span>

                                    </td>

                                    <td>

                                        <?= $user["is_active"] ? 'Ja' : 'Nein' ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($formatUserDate($user["created_at"])) ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($formatUserDate($user["last_login_at"] ?? null)) ?>

                                    </td>

                                    <td class="text-center">

                                        <button type="button" class="btn btn-outline-info btn-sm action-btn showUser"
                                            data-id="<?= (int) $user['user_id'] ?>" title="Details anzeigen"
                                            aria-label="Details anzeigen">

                                            <i class="fa-solid fa-eye" aria-hidden="true"></i>

                                        </button>

                                        <?php if ($canManageUsers && canManageUserRole($currentUserRole, $user['role'])): ?>
                                            <button type="button" class="btn btn-outline-warning btn-sm action-btn updateUser"
                                                data-id="<?= (int) $user['user_id'] ?>" title="Benutzer bearbeiten"
                                                aria-label="Benutzer bearbeiten">
                                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-danger btn-sm action-btn deleteUser"
                                                data-id="<?= (int) $user['user_id'] ?>" title="Benutzer löschen"
                                                aria-label="Benutzer löschen">
                                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php endif; ?>



                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>

                        <tr id="noUsersFound" hidden>
                            <td colspan="9">Keine Admins gefunden.</td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <!--
            <nav>

                <ul class="pagination justify-content-end">

                    <li class="page-item disabled">

                        <a class="page-link">

                            Zurück

                        </a>

                    </li>

                    <li class="page-item active">

                        <a class="page-link">

                            1

                        </a>

                    </li>

                    <li class="page-item">

                        <a class="page-link">

                            2

                        </a>

                    </li>

                    <li class="page-item">

                        <a class="page-link">

                            Weiter

                        </a>

                    </li>

                </ul>

            </nav>

                                    -->

        </div>
    </div>
</section>

<?php require_once MODALS_PATH . '/modal-user_form.php'; ?>

<?php require_once MODALS_PATH . '/modal-user_show.php'; ?>


<script>
    const usersEndpoint = <?= json_encode(BACKEND_URL . '/backend-users.php', JSON_UNESCAPED_SLASHES) ?>;
    const usersLoginUrl = <?= json_encode(BASE_URL . '/login', JSON_UNESCAPED_SLASHES) ?>;

    $(document).ready(function () {
        const userForm = $("#userForm")[0];
        const userModal = document.getElementById("userModal");
        const passwordInput = $("#password");

        function showRequestError(xhr) {
            const response = (xhr.responseText || "").trim();
            if (response === "session") {
                window.location.assign(usersLoginUrl);
                return;
            }

            let message = response;
            try {
                const parsed = JSON.parse(response);
                message = parsed.message || response;
            } catch (error) {
                message = response;
            }
            window.alert(message || "Die Anfrage ist fehlgeschlagen.");
        }

        function filterUsers() {
            const email = $("#filter-email").val().trim().toLowerCase();
            const firstName = $("#filter-name").val().trim().toLowerCase();
            const lastName = $("#filter-lastname").val().trim().toLowerCase();
            const role = $("#filter-userRole").val();
            let visibleCount = 0;

            $("#tableBody tr[data-id]").each(function () {
                const row = $(this);
                const matches = row.children().eq(1).text().trim().toLowerCase().includes(firstName)
                    && row.children().eq(2).text().trim().toLowerCase().includes(lastName)
                    && row.children().eq(3).text().trim().toLowerCase().includes(email)
                    && (!role || this.dataset.role === role);

                row.toggle(matches);
                if (matches) {
                    visibleCount++;
                }
            });

            const hasFilters = email !== "" || firstName !== "" || lastName !== "" || role !== "";
            $("#emptyUsersInitial").prop("hidden", hasFilters);
            $("#noUsersFound").prop("hidden", visibleCount > 0 || (!hasFilters && $("#tableBody tr[data-id]").length === 0));
            $("#noUsersFound td").text(hasFilters ? "Keine Admins entsprechen den Filtern." : "Keine Admins vorhanden.");
        }

        $("#addUserbtn").on("click", function () {
            userForm.reset();
            $("#user_id").val("");
            $("#userModalTitle").text("Neuen Benutzer erstellen");
            $("#userPasswordHelp").text("Für einen neuen Benutzer ist ein Passwort erforderlich.");
            passwordInput.prop("required", true).attr("autocomplete", "new-password");
            $("#saveUser").html('<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Benutzer speichern');
            userModal.showModal();
        });

        $("#userForm").on("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            const userId = $("#user_id").val();

            if (userId) {
                formData.append("updateUser", "1");
                formData.append("id", userId);
            } else {
                formData.append("createUser", "1");
            }

            $.ajax({
                url: usersEndpoint,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.trim() === "success") {
                        window.location.reload();
                    } else {
                        window.alert(response);
                    }
                },
                error: showRequestError
            });
        });

        $(document).on("click", ".showUser", function () {
            $.ajax({
                url: usersEndpoint,
                type: "POST",
                dataType: "json",
                data: {
                    showUser: 1,
                    id: $(this).data("id")
                },
                success: function (user) {
                    if (user.success === false) {
                        window.alert(user.message);
                        return;
                    }

                    const roleLabels = {
                        super_admin: "Superadmin",
                        admin: "Admin",
                        editor: "Editor",
                        user: "User"
                    };
                    $("#show_user_id").text(user.user_id);
                    $("#show_username").text(user.username);
                    $("#show_first_name").text(user.first_name);
                    $("#show_last_name").text(user.last_name);
                    $("#show_email").text(user.email);
                    $("#show_role").text(roleLabels[user.role] || user.role);
                    $("#show_active").text(user.is_active == 1 ? "Ja" : "Nein");
                    $("#show_created_at").text(user.created_at || "-");
                    $("#show_updated_at").text(user.updated_at || "-");
                    $("#show_last_login").text(user.last_login_at && !user.last_login_at.startsWith("0000-00-00") ? user.last_login_at : "-");
                    document.getElementById("showUserModal").showModal();
                },
                error: showRequestError
            });
        });

        $(document).on("click", ".updateUser", function () {
            $.ajax({
                url: usersEndpoint,
                type: "POST",
                dataType: "json",
                data: {
                    updateUser: 1,
                    load: 1,
                    id: $(this).data("id")
                },
                success: function (user) {
                    if (user.success === false) {
                        window.alert(user.message);
                        return;
                    }

                    $("#user_id").val(user.user_id);
                    $("#username").val(user.username);
                    $("#first_name").val(user.first_name);
                    $("#last_name").val(user.last_name);
                    $("#email").val(user.email);
                    $("#role").val(user.role);
                    $("#is_active").val(user.is_active);
                    passwordInput.val("").prop("required", false).attr("autocomplete", "new-password");
                    $("#userPasswordHelp").text("Leer lassen, wenn das Passwort nicht geändert werden soll.");
                    $("#userModalTitle").text("Benutzer bearbeiten");
                    $("#saveUser").html('<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Änderungen speichern');
                    userModal.showModal();
                },
                error: showRequestError
            });
        });

        $(document).on("click", ".deleteUser", function () {
            if (!window.confirm("Benutzer wirklich löschen?")) {
                return;
            }

            $.ajax({
                url: usersEndpoint,
                type: "POST",
                data: {
                    deleteUser: 1,
                    id: $(this).data("id")
                },
                success: function (response) {
                    if (response.trim() === "success") {
                        window.location.reload();
                    } else {
                        window.alert(response);
                    }
                },
                error: showRequestError
            });
        });

        $("#userFilterForm").on("submit", function (event) {
            event.preventDefault();
            filterUsers();
        });
        $("#filter-email, #filter-name, #filter-lastname, #filter-userRole").on("input change", filterUsers);
        filterUsers();
    });
</script>
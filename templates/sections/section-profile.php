<?php

require_once FUNCTIONS_PATH . '/profile.php';
require_once FUNCTIONS_PATH . '/function-db.php';


//Daten
$pdo = getDB();
$userId = (int) $_SESSION['userId'];
$profile = getProfile($pdo, $userId);
if ($profile === false) {
    http_response_code(404);
    echo '<p>Profildaten konnten nicht gefunden werden.</p>';
    return;
}

$roleLabels = [
    'super_admin' => 'Superadmin',
    'admin' => 'Admin',
    'editor' => 'Editor',
    'user' => 'User'
];
$lastLogin = $profile['last_login_at'] ?? null;
if (!is_string($lastLogin) || $lastLogin === '' || strncmp($lastLogin, '0000-00-00', 10) === 0) {
    $lastLogin = '-';
}

?>

<style>
    .profile-card {

        border: none;
        border-radius: 16px;

        box-shadow: 0 6px 20px rgba(0, 0, 0, .08);

        margin-bottom: 25px;

    }

    .profile-title {

        font-size: 30px;

        font-weight: 700;

        color: #1f2937;

        margin-bottom: 30px;

    }

    .card-header {

        font-weight: 600;

    }

    .badge-role {

        font-size: .9rem;

        padding: 8px 15px;

    }
</style>


<section class="container-fluid profile-section" aria-labelledby="profileTitle">

    <h1 class="profile-title" id="profileTitle">

        Mein Profil

    </h1>

    <!-- Persönliche Daten -->

    <section class="card profile-card" aria-labelledby="personalDataTitle">

        <h2 class="card-header profile-card__title" id="personalDataTitle">

            Persönliche Daten

        </h2>

        <div class="card-body">

            <form id="personalDataForm" method="POST">

                <input type="hidden" name="action" value="updateProfile">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label" for="profile-first-name">

                            Vorname

                        </label>

                        <input class="form-control" id="profile-first-name" name="first_name" required
                            value="<?= htmlspecialchars($profile["first_name"]) ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label" for="profile-last-name">

                            Nachname

                        </label>

                        <input class="form-control" id="profile-last-name" name="last_name" required
                            value="<?= htmlspecialchars($profile["last_name"]) ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label" for="profile-username">

                            Benutzername

                        </label>

                        <input class="form-control" id="profile-username" name="username" required
                            value="<?= htmlspecialchars($profile["username"]) ?>">

                    </div>

                </div>

                <button class="btn btn-primary" name="saveProfile" type="submit">

                    <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>

                    Änderungen speichern

                </button>

            </form>

        </div>

    </section>

    <!-- E-Mail -->

    <section class="card profile-card" aria-labelledby="emailTitle">

        <h2 class="card-header profile-card__title" id="emailTitle">

            E-Mail-Adresse

        </h2>

        <div class="card-body">

            <form id="emailChangeForm" method="POST">

                <input type="hidden" name="action" value="changeEmail">

                <div class="row">

                    <div class="col-lg-8">

                        <label class="form-label" for="profile-email">E-Mail-Adresse</label>
                        <input type="email" class="form-control" id="profile-email" name="email" required
                            value="<?= htmlspecialchars($profile["email"]) ?>">

                    </div>

                    <div class="col-lg-4">

                        <button class="btn btn-success w-100" type="submit">

                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>

                            E-Mail ändern

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </section>

    <!-- Passwort -->

    <section class="card profile-card" aria-labelledby="passwordTitle">

        <h2 class="card-header profile-card__title" id="passwordTitle">

            Passwort ändern

        </h2>

        <div class="card-body">

            <form id="passwordChangeForm" method="POST">

                <input type="hidden" name="action" value="changePassword">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label" for="current-password">

                            Aktuelles Passwort

                        </label>

                        <input type="password" id="current-password" name="current_password" class="form-control" autocomplete="current-password" required>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label" for="new-password">

                            Neues Passwort

                        </label>

                        <input type="password" id="new-password" name="new_password" class="form-control" autocomplete="new-password" minlength="3" required>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label" for="repeat-password">

                            Passwort wiederholen

                        </label>

                        <input type="password" id="repeat-password" name="repeat_password" class="form-control" autocomplete="new-password" minlength="3" required>

                    </div>

                </div>

                <button class="btn btn-warning mt-3" type="submit">

                    <i class="fa-solid fa-key" aria-hidden="true"></i>

                    Passwort ändern

                </button>

            </form>

        </div>

    </section>

    <!-- Kontoinformation -->

    <section class="card profile-card" aria-labelledby="accountInfoTitle">

        <h2 class="card-header profile-card__title" id="accountInfoTitle">

            Kontoinformationen

        </h2>

        <div class="card-body">

            <div class="table-responsive" role="region" aria-label="Kontoinformationen" tabindex="0">
                <table class="table profile-info-table">
                    <tbody>

                        <tr>

                            <th scope="row">

                                Rolle

                            </th>

                            <td>

                                <span class="badge bg-primary badge-role">

                                    <?= htmlspecialchars($roleLabels[$profile["role"]] ?? $profile["role"]) ?>

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th scope="row">

                                Status

                            </th>

                            <td>

                                <?php if ($profile["is_active"]): ?>

                                    <span class="badge bg-success">

                                        Aktiv

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">

                                        Deaktiviert

                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                        <tr>

                            <th scope="row">

                                Konto erstellt

                            </th>

                            <td>

                                <?= htmlspecialchars($profile["created_at"]) ?>

                            </td>

                        </tr>

                        <tr>

                            <th scope="row">

                                Letzter Login

                            </th>

                            <td>

                                <?= htmlspecialchars($lastLogin) ?>

                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </section>

    </section>

</div>


<script>
    const profileEndpoint = <?= json_encode(BACKEND_URL . '/backend-profile.php', JSON_UNESCAPED_SLASHES) ?>;
    const loginUrl = <?= json_encode(BASE_URL . '/login', JSON_UNESCAPED_SLASHES) ?>;

    $(document).ready(function () {
        function submitProfileForm(form, confirmation) {
            if (!window.confirm(confirmation)) {
                return;
            }
            $.ajax({
                url: profileEndpoint,
                method: "POST",
                data: new FormData(form),
                contentType: false,
                processData: false,
                success: function (response) {
                    handleProfileResponse(response);
                },
                error: function (xhr) {
                    handleProfileResponse(xhr.responseText || "Unerwarteter Fehler.");
                }
            });
        }

        function handleProfileResponse(response) {
            const result = response.trim();
            if (result === "success") {
                window.location.reload();
            } else if (result === "session") {
                window.location.assign(loginUrl);
            } else {
                alert(result || "Unerwarteter Fehler.");
            }
        }

        $("#personalDataForm").on("submit", function (e) {
            e.preventDefault();
            submitProfileForm(this, "Möchten Sie wirklich Ihre Daten ändern?");
        });

        $("#emailChangeForm").on("submit", function (e) {
            e.preventDefault();
            submitProfileForm(this, "Möchten Sie Ihre E-Mail ändern?");
        });

        $("#passwordChangeForm").on("submit", function (e) {
            e.preventDefault();
            submitProfileForm(this, "Möchten Sie Ihr Passwort ändern?");
        });
    });
</script>
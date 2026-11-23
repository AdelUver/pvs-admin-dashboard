<?php

require_once BACKEND_PATH . '/backend-functions/profile.php';
require_once FUNCTIONS_PATH . '/function-db.php';


//Daten
$pdo = getDB();
$userId = $_SESSION['userId'];
$profile = getProfile($pdo, $userId);

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


<div class="container-fluid">

    <h2 class="profile-title">

        Mein Profil

    </h2>

    <!-- Persönliche Daten -->

    <div class="card profile-card">

        <div class="card-header">

            Persönliche Daten

        </div>

        <div class="card-body">

            <form id="personalDataForm" method="POST">

                <input type="hidden" name="action" value="updateProfile">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Vorname

                        </label>

                        <input class="form-control" name="first_name"
                            value="<?= htmlspecialchars($profile["first_name"]) ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nachname

                        </label>

                        <input class="form-control" name="last_name"
                            value="<?= htmlspecialchars($profile["last_name"]) ?>">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Benutzername

                        </label>

                        <input class="form-control" name="username"
                            value="<?= htmlspecialchars($profile["username"]) ?>">

                    </div>

                </div>

                <button class="btn btn-primary" name="saveProfile" onclick="return confirm('Möchten Sie wirklich Ihre Daten ändern?');">

                    <i class="bi bi-floppy"></i>

                    Änderungen speichern

                </button>

            </form>

        </div>

    </div>

    <!-- E-Mail -->

    <div class="card profile-card">

        <div class="card-header">

            E-Mail-Adresse

        </div>

        <div class="card-body">

            <form id="emailChangeForm" method="POST">

                <input type="hidden" name="action" value="changeEmail">

                <div class="row">

                    <div class="col-lg-8">

                        <input type="email" class="form-control" name="email"
                            value="<?= htmlspecialchars($profile["email"]) ?>">

                    </div>

                    <div class="col-lg-4">

                        <button class="btn btn-success w-100" onclick="return confirm('Möchten Sie Ihre E-Mail ändern?');">

                            <i class="bi bi-envelope-check"></i>

                            E-Mail ändern

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Passwort -->

    <div class="card profile-card">

        <div class="card-header">

            Passwort ändern

        </div>

        <div class="card-body">

            <form id="passwordChangeForm" method="POST">

                <input type="hidden" name="action" value="changePassword">

                <div class="row">

                    <div class="col-md-4">

                        <label>

                            Aktuelles Passwort

                        </label>

                        <input type="password" name="current_password" class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label>

                            Neues Passwort

                        </label>

                        <input type="password" name="new_password" class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label>

                            Passwort wiederholen

                        </label>

                        <input type="password" name="repeat_password" class="form-control">

                    </div>

                </div>

                <button class="btn btn-warning mt-3" onclick="return confirm('Möchten Sie Ihre Password ändern?');">

                    <i class="bi bi-key"></i>

                    Passwort ändern

                </button>

            </form>

        </div>

    </div>

    <!-- Kontoinformation -->

    <div class="card profile-card">

        <div class="card-header">

            Kontoinformationen

        </div>

        <div class="card-body">

            <table class="table">

                <tr>

                    <th width="250">

                        Rolle

                    </th>

                    <td>

                        <span class="badge bg-primary badge-role">

                            <?= $profile["role"] ?>

                        </span>

                    </td>

                </tr>

                <tr>

                    <th>

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

                    <th>

                        Konto erstellt

                    </th>

                    <td>

                        <?= $profile["created_at"] ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Letzter Login

                    </th>

                    <td>

                        <?= $profile["last_login_at"] ?>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>
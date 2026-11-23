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

require_once BACKEND_PATH . '/backend-functions/users.php';
require_once FUNCTIONS_PATH . '/function-db.php';


//Daten
$pdo = getDB();
$userId = $_SESSION['userId'];
$users = getAllUsers($pdo);
?>

<div class="container-fluid" id="usersSection">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="page-title">

            Benutzer

        </h2>

        <button type="button" class="btn btn-primary" id="addUserbtn">

            <i class="fa-solid fa-circle-plus" aria-hidden="true"></i>

            Neuer Benutzer

        </button>

    </div>

    <div class="filter-box">

        <div class="row g-3">

            <div class="col-lg-3">

                <input type="text" class="form-control" placeholder="E-Mail suchen..." id="filter-email">

            </div>

            <div class="col-lg-3">

                <input type="text" class="form-control" placeholder="Name suchen..." id="filter-name">

            </div>

            <div class="col-lg-3">

                <input type="text" class="form-control" placeholder="Nachname suchen..." id="filter-lastname">

            </div>



            <div class="col-lg-1">

                <select class="form-select" id="filter-userRole">

                    <option>Alle</option>
                    <option>Superadmin</option>
                    <option>Admin</option>
                    <option>Editor</option>
                    <option>User</option>

                </select>

            </div>

            <div class="col-lg-1">

                <button class="btn btn-outline-primary w-100" id="filterUser">

                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>

                    Filtern

                </button>

            </div>

        </div>

    </div>

    <div class="card user-card">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Vorname</th>

                        <th>Nachname</th>

                        <th>E-Mail</th>

                        <th>Role</th>

                        <th>Aktiv</th>

                        <th>Angemeldet seit</th>

                        <th>Last login</th>

                        <th class="text-center">

                            Aktionen

                        </th>

                    </tr>

                </thead>

                <tbody id="tableBody">

                    <?php foreach ($users as $user): ?>


                        <tr data-id="<?= $user['user_id'] ?>">

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
                                    <?= htmlspecialchars($user["role"]) ?>
                                </span>

                            </td>

                            <td>

                                <?= $user["is_active"] ? 'Ja' : 'Nein' ?>

                            </td>

                            <td>

                                <?= date('d.m.Y H:i', strtotime($user["created_at"])) ?>

                            </td>

                            <td>

                                <?= $user["last_login_at"]
                                    ? date('d.m.Y H:i', strtotime($user["last_login_at"]))
                                    : '-'
                                ?>

                            </td>

                            <td class="text-center">

                                <button class="btn btn-outline-info btn-sm action-btn showUser" data-id="<?= $user['user_id'] ?>" title="show">

                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>

                                </button>

                                <button
                                    class="btn btn-outline-warning btn-sm action-btn updateUser" data-id="<?= $user['user_id'] ?>" title="update">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </button>

                                <button
                                    class="btn btn-outline-danger btn-sm action-btn deleteUser" data-id="<?= $user['user_id'] ?>" title="delete">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>



                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

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

</div>

<?php require_once MODALS_PATH . '/modal-user_form.php'; ?>

<?php require_once MODALS_PATH . '/modal-user_show.php'; ?>


<?php include_once SCRIPT_PATH . '/script-user.php'; ?>
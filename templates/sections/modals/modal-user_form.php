<div class="modal fade" id="userModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">
                    Benutzer hinzufügen
                </h4>

                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <form id="userForm">

                <input type="hidden" name="user_id" id="user_id">

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nachname</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Benutzername</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">
                                Leer lassen, wenn das Passwort nicht geändert werden soll.
                            </small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Rolle</label>

                            <select class="form-select" id="role" name="role">

                                <option value="super_admin">Superadmin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="user">User</option>

                            </select>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label">Aktiv</label>

                            <select class="form-select" id="is_active" name="is_active">

                                <option value="1">Ja</option>
                                <option value="0">Nein</option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <a class="btn btn-secondary" data-bs-dismiss="modal">
                        Abbrechen
                    </a>

                    <button class="btn btn-success" id="saveUser">
                        <i class="bi bi-floppy"></i>
                        Speichern
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
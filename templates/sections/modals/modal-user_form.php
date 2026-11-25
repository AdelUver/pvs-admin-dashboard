<dialog class="app-modal modal-lg" id="userModal" aria-labelledby="userModalTitle">

        <div class="modal-content">

            <div class="modal-header">

                <h2 class="modal-title" id="userModalTitle">
                    Benutzer hinzufügen
                </h2>

                <button type="button" class="btn-close" data-modal-close aria-label="Schließen"></button>

            </div>

            <form id="userForm">

                <input type="hidden" name="user_id" id="user_id">

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="first_name">Vorname</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" maxlength="32" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="last_name">Nachname</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" maxlength="32" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="username">Benutzername</label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="32" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">E-Mail</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="64" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="password">Passwort</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="3" autocomplete="new-password">
                            <small class="text-muted" id="userPasswordHelp">
                                Leer lassen, wenn das Passwort nicht geändert werden soll.
                            </small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="role">Rolle</label>

                            <select class="form-select" id="role" name="role">

                                <?php if ($currentUserRole === 'super_admin'): ?>
                                    <option value="super_admin">Superadmin</option>
                                    <option value="admin">Admin</option>
                                <?php endif; ?>
                                <option value="editor">Editor</option>
                                <option value="user">User</option>

                            </select>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label" for="is_active">Aktiv</label>

                            <select class="form-select" id="is_active" name="is_active">

                                <option value="1">Ja</option>
                                <option value="0">Nein</option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-modal-close>
                        Abbrechen
                    </button>

                    <button class="btn btn-success" id="saveUser" type="submit">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                        Speichern
                    </button>

                </div>

            </form>

        </div>
</dialog>
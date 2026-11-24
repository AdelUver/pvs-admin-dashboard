<!--  Add Event Formular  -->
<dialog class="app-modal modal-xl" id="eventModal" aria-labelledby="eventModalTitle">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="eventModalTitle">

                    Neues Event erstellen

                </h4>

                <button type="button" class="btn-close" data-modal-close aria-label="Schließen"></button>

            </div>

            <form id="addEvent">

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-8 mb-3">

                            <label for="title" class="form-label">

                                Eventtitel

                            </label>

                            <input type="text" name="title" id="title" class="form-control" required>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label for="status" class="form-label">

                                Status

                            </label>

                            <select name="status" id="status" class="form-select">

                                <option value="planned">

                                    Geplant

                                </option>

                                <option value="full">

                                    Ausgebucht

                                </option>

                                <option value="completed">

                                    Abgeschlossen

                                </option>
                                <option value="cancelled">

                                    Abgesagt

                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label for="description" class="form-label">

                            Beschreibung

                        </label>

                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="event_date" class="form-label">

                                Datum

                            </label>

                            <input type="date" name="event_date" id="event_date" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="event_time" class="form-label">

                                Uhrzeit

                            </label>

                            <input type="time" name="event_time" id="event_time" class="form-control" required>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="location" class="form-label">

                                Location

                            </label>

                            <input type="text" name="location" id="location" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="street" class="form-label">

                                Straße

                            </label>

                            <input type="text" name="street" id="street" class="form-control" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="postCode" class="form-label">

                                PLZ

                            </label>

                            <input type="text" name="post_code" id="postCode" class="form-control" pattern="[0-9]{4,5}" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="city" class="form-label">

                                Stadt

                            </label>

                            <input type="text" name="city" id="city" class="form-control" required>

                        </div>


                        <div class="col-md-6 mb-3">

                            <label for="max_participants" class="form-label">

                                Max. Teilnehmer

                            </label>

                            <input type="number" name="max_participants" id="max_participants" class="form-control" min="1" step="1" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="registration_deadline" class="form-label">

                                Letzte Anmeldung

                            </label>

                            <input type="date" name="registration_deadline" id="registration_deadline" class="form-control" required>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-modal-close>

                        Abbrechen

                    </button>

                    <button class="btn btn-success" type="submit" name="saveEvent" id="saveEvent">

                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>

                        Event speichern

                    </button>

                </div>

            </form>

        </div>
</dialog>
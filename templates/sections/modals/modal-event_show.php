<!-- Show Event Modal -->
<dialog class="app-modal modal-lg" id="showEventModal" aria-labelledby="showEventTitle">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="showEventTitle">
                    Eventdetails
                </h4>

                <button type="button" class="btn-close" data-modal-close aria-label="Schließen"></button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">

                        <table class="table table-sm">

                            <tr>
                                <th>ID</th>
                                <td id="show_event_id"></td>
                            </tr>

                            <tr>
                                <th>Titel</th>
                                <td id="show_title"></td>
                            </tr>

                            <tr>
                                <th>Beschreibung</th>
                                <td id="show_description"></td>
                            </tr>

                            <tr>
                                <th>Datum</th>
                                <td id="show_date"></td>
                            </tr>

                            <tr>
                                <th>Uhrzeit</th>
                                <td id="show_time"></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td id="show_status"></td>
                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <table class="table table-sm">

                            <tr>
                                <th>Ort</th>
                                <td id="show_location"></td>
                            </tr>

                            <tr>
                                <th>Straße</th>
                                <td id="show_street"></td>
                            </tr>

                            <tr>
                                <th>PLZ</th>
                                <td id="show_postcode"></td>
                            </tr>

                            <tr>
                                <th>Stadt</th>
                                <td id="show_city"></td>
                            </tr>

                            <tr>
                                <th>Max. Teilnehmer</th>
                                <td id="show_max"></td>
                            </tr>

                            <tr>
                                <th>Anmeldeschluss</th>
                                <td id="show_deadline"></td>
                            </tr>

                        </table>

                    </div>

                </div>

                <hr>

                <h5>Systeminformationen</h5>

                <table class="table table-bordered">

                    <tr>
                        <th>Erstellt am</th>
                        <td id="show_created_at"></td>
                    </tr>

                    <tr>
                        <th>Erstellt von</th>
                        <td id="show_created_by"></td>
                    </tr>

                    <tr>
                        <th>Geändert am</th>
                        <td id="show_updated_at"></td>
                    </tr>

                    <tr>
                        <th>Geändert von</th>
                        <td id="show_updated_by"></td>
                    </tr>

                </table>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-modal-close>
                    Schließen
                </button>

            </div>
</dialog>
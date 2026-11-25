<!-- Show Event Modal -->
<dialog class="app-modal modal-lg" id="showEventModal" aria-labelledby="showEventTitle">

        <div class="modal-content">

            <div class="modal-header">

                <h2 class="modal-title" id="showEventTitle">
                    Eventdetails
                </h2>

                <button type="button" class="btn-close" data-modal-close aria-label="Schließen"></button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6">

                        <table class="table table-sm">

                            <tr>
                                <th scope="row">ID</th>
                                <td id="show_event_id"></td>
                            </tr>

                            <tr>
                                <th scope="row">Titel</th>
                                <td id="show_title"></td>
                            </tr>

                            <tr>
                                <th scope="row">Beschreibung</th>
                                <td id="show_description"></td>
                            </tr>

                            <tr>
                                <th scope="row">Datum</th>
                                <td id="show_date"></td>
                            </tr>

                            <tr>
                                <th scope="row">Uhrzeit</th>
                                <td id="show_time"></td>
                            </tr>

                            <tr>
                                <th scope="row">Status</th>
                                <td id="show_status"></td>
                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <table class="table table-sm">

                            <tr>
                                <th scope="row">Ort</th>
                                <td id="show_location"></td>
                            </tr>

                            <tr>
                                <th scope="row">Straße</th>
                                <td id="show_street"></td>
                            </tr>

                            <tr>
                                <th scope="row">PLZ</th>
                                <td id="show_postcode"></td>
                            </tr>

                            <tr>
                                <th scope="row">Stadt</th>
                                <td id="show_city"></td>
                            </tr>

                            <tr>
                                <th scope="row">Max. Teilnehmer</th>
                                <td id="show_max"></td>
                            </tr>

                            <tr>
                                <th scope="row">Min. Teilnehmer</th>
                                <td id="show_min"></td>
                            </tr>

                            <tr>
                                <th scope="row">Anmeldeschluss</th>
                                <td id="show_deadline"></td>
                            </tr>

                        </table>

                    </div>

                </div>

                <hr>

                <h3>Systeminformationen</h3>

                <table class="table table-bordered">

                    <tr>
                        <th scope="row">Erstellt am</th>
                        <td id="show_created_at"></td>
                    </tr>

                    <tr>
                        <th scope="row">Erstellt von</th>
                        <td id="show_created_by"></td>
                    </tr>

                    <tr>
                        <th scope="row">Geändert am</th>
                        <td id="show_updated_at"></td>
                    </tr>

                    <tr>
                        <th scope="row">Geändert von</th>
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
<!-- Show register Modal -->
<dialog class="app-modal modal-xl" id="registrationModal" aria-labelledby="registrationTitle">

        <div class="modal-content">

            <div class="modal-header">

                <h2 class="modal-title" id="registrationTitle">

                    Eventanmeldungen

                </h2>

                <button type="button" class="btn-close" data-modal-close aria-label="Schließen"></button>

            </div>

            <div class="modal-body">

                <div class="table-responsive" role="region" aria-label="Anmeldungen" tabindex="0">
                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-Mail</th>
                            <th scope="col">Status</th>
                            <th scope="col">Angemeldet am</th>

                        </tr>

                    </thead>

                    <tbody id="registrationTableBody">

                    </tbody>

                </table>
                </div>

            </div>
    </dialog>

</div>
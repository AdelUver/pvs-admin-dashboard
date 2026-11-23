<script>
    $(document).ready(function() {

        // Add new Event
        $("#addEvent").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var eventId = $("#addEvent").data("id");

            if (eventId) {

                formData.append("updateEvent", 1);
                formData.append("id", eventId);

            } else {

                formData.append("createEvent", 1);

            }

            $.ajax({
                url: "/Uver/loginPVS/backend/backend-events.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.trim() === "success") {

                        // Formular zurücksetzen
                        $("#addEvent").removeAttr("data-id");
                        $("#addEvent")[0].reset();

                        // Modal wieder auf "Neues Event" stellen
                        $(".modal-title").text("Neues Event erstellen");

                        $("#saveEvent").html(`
                        <i class="bi bi-floppy"></i>
                         Event speichern
                        `);

                        window.location.reload();

                    } else {

                        alert(response);

                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Unerwarteter Fehler.");
                }
            });
        });

        //show Event
        $(".showEvent").on("click", function() {
            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-events.php",

                method: "POST",

                data: {
                    showEvent: 1,
                    id: id
                },

                success: function(response) {

                    var event = JSON.parse(response);

                    $("#show_event_id").text(event.event_id);
                    $("#show_title").text(event.title);
                    $("#show_description").text(event.description);
                    $("#show_date").text(event.event_date);
                    $("#show_time").text(event.event_time);
                    $("#show_location").text(event.location);
                    $("#show_street").text(event.street);
                    $("#show_postcode").text(event.post_code);
                    $("#show_city").text(event.city);
                    $("#show_max").text(event.max_participants);
                    $("#show_deadline").text(event.registration_deadline);
                    $("#show_status").text(event.status);

                    $("#show_created_at").text(event.created_at);
                    $("#show_updated_at").text(event.updated_at);
                    $("#show_created_by").text(event.created_last_name + " " + event.created_first_name);
                    $("#show_updated_by").text(event.updated_last_name + " " + event.updated_first_name);

                    $("#showEventModal").modal("show");

                },

                error: function() {

                    alert("Fehler beim Laden.");

                }

            });
        });


        //update Event
        $(".updateEvent").on("click", function() {
            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-events.php",

                method: "POST",

                data: {
                    updateEvent: 1,
                    id: id,
                    load: 1
                },

                success: function(response) {
                    console.log(response);
                    var event = JSON.parse(response);
                    var modal = new bootstrap.Modal(document.getElementById("eventModal"));


                    $("#title").val(event.title);
                    $("#status").val(event.status);
                    $("#description").val(event.description);
                    $("#event_date").val(event.event_date);
                    $("#event_time").val(event.event_time.substring(0, 5));
                    $("#location").val(event.location);
                    $("#street").val(event.street);
                    $("#postCode").val(event.post_code);
                    $("#city").val(event.city);
                    $("#max_participants").val(event.max_participants);
                    $("#registration_deadline").val(event.registration_deadline);

                    $("#addEvent").attr("data-id", event.event_id);

                    $("#eventModal .modal-title").text("Event bearbeiten");

                    $("#saveEvent").html('<i class="bi bi-floppy"></i> Änderungen speichern');

                    console.log(event);

                    console.log($("#title").val());
                    console.log($("#date").val());
                    console.log($("#location").val());

                    console.log($("#date").length);
                    console.log($("#title").length);
                    console.log($("#eventModal").length);

                    modal.show();

                }

            });
        });


        //delete Event
        $(".deleteEvent").on("click", function() {
            if (!confirm("Möchtest du dieses Event wirklich löschen?")) {
                return;
            }

            var id = $(this).closest("tr").data("id");

            $.ajax({
                url: "/Uver/loginPVS/backend/backend-events.php",
                method: "POST",
                data: {
                    deleteEvent: 1,
                    id: id
                },
                success: function(response) {
                    if (response.trim() === "success") {
                        window.location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert("Unerwarteter Fehler.")
                }

            });
        });

        //Events Teilnehmer exportieren
        $(".exportParticipants").on("click", function() {

            var id = $(this).closest("tr").data("id");

            var form = $('<form>', {
                method: 'POST',
                action: '/Uver/loginPVS/backend/backend-events.php'
            });

            form.append($('<input>', {
                type: 'hidden',
                name: 'exportParticipants',
                value: 1
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            }));

            $('body').append(form);

            form.submit();

            form.remove();

        });

        //Show register
        $(".showRegistrations").on("click", function() {

            var id = $(this).closest("tr").data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-events.php",

                method: "POST",

                data: {

                    showRegistrations: 1,
                    id: id

                },

                success: function(response) {

                    var registrations = JSON.parse(response);

                    var html = "";

                    registrations.forEach(function(user) {

                        html += `
                    <tr>

                        <td>${user.user_id}</td>

                        <td>
                            ${user.last_name}
                            ${user.first_name}
                        </td>

                        <td>${user.email}</td>

                        <td>${user.phone}</td>

                        <td>${user.status}</td>

                        <td>${user.registered_at}</td>

                    </tr>
                `;

                    });

                    $("#registrationTableBody").html(html);

                    var modal = new bootstrap.Modal(
                        document.getElementById("registrationModal")
                    );

                    modal.show();

                }

            });

        });


        //filter Events
        $("#filterEvent").on("click", function() {

            var eventTitle = $("#eventTitle").val().trim().toLowerCase();
            var eventDateFrom = $("#eventDateFrom").val();
            var eventDateTo = $("#eventDateTo").val();
            var eventStatus = $("#eventStatus").val();

            console.log(eventDateFrom);
            console.log(eventDateTo);

            $("#tableBody tr").each(function() {

                var row = $(this);

                var title = row.children().eq(1).text().trim().toLowerCase();
                var date = row.children().eq(2).text().trim(); // Must be YYYY-MM-DD
                var status = row.children().eq(6).text().trim();

                var matches = true;

                // Title filter
                if (eventTitle !== "" && !title.includes(eventTitle)) {
                    matches = false;
                }

                // Status filter
                if (eventStatus !== "" && eventStatus !== "Alle Status" && status !== eventStatus) {
                    matches = false;
                }

                // Date From filter
                if (eventDateFrom !== "" && date < eventDateFrom) {
                    matches = false;
                }

                // Date To filter
                if (eventDateTo !== "" && date > eventDateTo) {
                    matches = false;
                }

                row.toggle(matches);
            });

        });
    });
</script>
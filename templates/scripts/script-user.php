<script>
    $(document).ready(function() {

        $('#usersSection #addUserbtn').on('click', function(e) {
            $("#user_id").val('');
            $("#userForm").removeAttr("data-id");
            $("#userForm")[0].reset();
            $(".modal-title").text("Neuer Benutzer erstellen");

            $("#saveUser").html(`
                        <i class="bi bi-floppy"></i>
                         User speichern
                        `);
        })

        //add user
        $("#userForm").on("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var userId = $("#user_id").val();

            if (userId == '') {

                formData.append("createUser", 1);




            } else {


                formData.append("updateUser", 1);
                formData.append("id", userId);

            }

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-users.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    if (response.trim() == "success") {

                        window.location.reload();ö

                    } else {

                        alert(response);

                    }

                },
                error: function(xhr, status, error) {
                    alert("Fehler beim Laden.");
                }

            });

        });


        //show user
        $(document).on("click", ".showUser", function() {

            var id = $(this).data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-users.php",

                type: "POST",

                dataType: "json",

                data: {

                    showUser: 1,
                    id: id

                },

                success: function(response) {

                    var user = response;

                    $("#show_user_id").text(user.user_id);
                    $("#show_username").text(user.username);
                    $("#show_first_name").text(user.first_name);
                    $("#show_last_name").text(user.last_name);
                    $("#show_email").text(user.email);
                    $("#show_role").text(user.role);
                    $("#show_active").text(user.is_active == 1 ? "Ja" : "Nein");
                    $("#show_created_at").text(user.created_at);
                    $("#show_updated_at").text(user.updated_at);
                    $("#show_last_login").text(user.last_login_at);

                    new bootstrap.Modal(
                        document.getElementById("showUserModal")
                    ).show();

                }

            });

        });


        //update user
        $(document).on("click", ".updateUser", function() {

            let id = $(this).data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-users.php",

                type: "POST",
                dataType: "json",

                data: {

                    updateUser: 1,
                    load: 1,
                    id: id

                },

                success: function(response) {

                    let user = response;

                    $("#user_id").val(user.user_id);
                    $("#username").val(user.username);
                    $("#first_name").val(user.first_name);
                    $("#last_name").val(user.last_name);
                    $("#email").val(user.email);
                    $("#role").val(user.role);
                    $("#is_active").val(user.is_active);

                    $("#password").val("");

                    $("#userModal .modal-title").text("Benutzer bearbeiten");

                    $("#saveUser").html(
                        '<i class="bi bi-floppy"></i> Änderungen speichern'
                    );

                    new bootstrap.Modal(
                        document.getElementById("userModal")
                    ).show();

                }

            });

        });



        //delete user
        $(document).on("click", ".deleteUser", function() {

            if (!confirm("Benutzer wirklich löschen?")) {

                return;
            }

            let id = $(this).data("id");

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-users.php",

                type: "POST",

                data: {

                    deleteUser: 1,
                    id: id

                },

                success: function(response) {

                    if (response.trim() === "success") {

                        location.reload();

                    } else {

                        alert(response);

                    }

                }

            });

        });


        //filter user
        $("#filterUser").on("click", function() {

            let username = $("#filter-email").val().trim().toLowerCase();
            let firstName = $("#filter-name").val().trim().toLowerCase();
            let lastName = $("#filter-lastname").val().trim().toLowerCase();
            let role = $("#filter-userRole").val().trim().toLowerCase();

            $("#tableBody tr").each(function() {

                let row = $(this);

                let rowFirst = row.children().eq(1).text().trim().toLowerCase();
                let rowLast = row.children().eq(2).text().trim().toLowerCase();
                let rowEmail = row.children().eq(3).text().trim().toLowerCase();
                let rowRole = row.children().eq(4).text().trim().toLowerCase();

                let show = true;

                if (username !== "" && !rowEmail.includes(username))
                    show = false;

                if (firstName !== "" && !rowFirst.includes(firstName))
                    show = false;

                if (lastName !== "" && !rowLast.includes(lastName))
                    show = false;

                if (role !== "alle" && rowRole !== role.toLowerCase())
                    show = false;

                row.toggle(show);

            });

        });
    });
</script>
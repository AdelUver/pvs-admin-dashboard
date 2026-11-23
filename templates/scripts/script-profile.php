<script>
$(document).ready(function() {
    $("#personalDataForm").on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/Uver/loginPVS/backend/backend-profile.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.trim() === "success") {
                    window.location.reload();
                } else if (response.trim === "session") {
                    window.location.href = "/Uver/loginPVS/logout";
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

    $("#emailChangeForm").on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/Uver/loginPVS/backend/backend-profile.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.trim() === "success") {
                    window.location.reload();
                } else if (response.trim === "session") {
                    window.location.href = "/Uver/loginPVS/logout";
                }else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Unerwarteter Fehler.");
            }
        });
    });
    $("#passwordChangeForm").on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/Uver/loginPVS/backend/backend-profile.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.trim() === "success") {
                    window.location.reload();
                } else if (response.trim() === "session") {
                    window.location.href = "/Uver/loginPVS/logout";
                }else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Unerwarteter Fehler.");
            }
        });
    });


});
</script>
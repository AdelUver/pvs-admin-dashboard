<script>
$(document).ready(function() {
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/Uver/loginPVS/backend/backend-login.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.trim() === "success") {
                    window.location.href = "/Uver/loginPVS/dashboard";
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
});
</script>
<script>
    $(document).ready(function() {
        $("#showAllEvents").on("click", function() {

            $.ajax({

                url: "/Uver/loginPVS/backend/backend-dashboard.php",

                method: "POST",

                data: {
                    loadAllEvents: 1
                },

                success: function(response) {

                    $("#upcomingEventsBody").html(response);

                }

            });

        });
    });
</script>
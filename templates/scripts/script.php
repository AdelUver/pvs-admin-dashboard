<script src="assets/js/bootstrap.bundle.min.js"></script>


<script>
    const password = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    toggle.addEventListener("click", () => {

        password.type =
            password.type === "password" ?
                "text" :
                "password";

        toggle.innerHTML =
            password.type === "password" ?
                "👁" :
                "🙈";
    });

    // Platzhalter für spätere Backend-Fehler
    function showLoginError(message) {

        const alert = document.getElementById("loginAlert");

        alert.textContent = message;
        alert.classList.remove("d-none");
    }
</script>
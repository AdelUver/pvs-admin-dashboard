document.querySelectorAll("dialog.app-modal").forEach(function (dialog) {
    dialog.addEventListener("cancel", function (event) {
        event.preventDefault();
        dialog.close();
    });
});

document.addEventListener("click", function (event) {
    const closeButton = event.target.closest("[data-modal-close]");

    if (closeButton) {
        const dialog = closeButton.closest("dialog[open]");
        if (dialog) {
            dialog.close();
        }
        return;
    }

    if (event.target instanceof HTMLDialogElement && event.target.classList.contains("app-modal")) {
        event.target.close();
    }
});

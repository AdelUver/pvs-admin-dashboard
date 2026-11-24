<style>
    .login-page {
        min-height: 100vh;
        margin: 0;
        background:
            radial-gradient(ellipse at 15% 15%, rgba(216, 180, 107, .11), transparent 38%),
            var(--pvs-bg-gradient);
        color: var(--pvs-text);
        font-family: var(--pvs-font-main);
    }

    .login-page *,
    .login-page *::before,
    .login-page *::after {
        box-sizing: border-box;
    }

    .login-shell {
        display: grid;
        min-height: 100vh;
        min-height: 100svh;
        align-items: center;
        padding: clamp(1.25rem, 4vw, 4rem);
    }

    .login-layout {
        display: grid;
        width: min(100%, 1120px);
        min-height: min(690px, calc(100svh - 4rem));
        grid-template-columns: minmax(0, 1fr) minmax(360px, .82fr);
        margin: 0 auto;
        overflow: hidden;
        border: 1px solid var(--pvs-border);
        border-radius: var(--pvs-radius-lg);
        background: rgba(13, 13, 13, .78);
        box-shadow: var(--pvs-shadow);
    }

    .login-intro {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: clamp(2rem, 5vw, 4.5rem);
        background:
            radial-gradient(ellipse at 80% 75%, rgba(216, 180, 107, .10), transparent 46%),
            linear-gradient(145deg, rgba(255, 255, 255, .035), transparent 60%);
    }

    .login-brand {
        display: inline-flex;
        width: fit-content;
        align-items: center;
        gap: .9rem;
        color: var(--pvs-text);
        font-size: .95rem;
        font-weight: 650;
        letter-spacing: .02em;
        text-decoration: none;
    }

    .login-brand__logo {
        width: 3.5rem;
        height: 3.5rem;
        object-fit: contain;
    }

    .login-intro__copy {
        max-width: 28rem;
        padding: 3rem 0;
    }

    .login-eyebrow {
        margin: 0 0 .9rem;
        color: var(--pvs-gold);
        font-size: var(--pvs-fs-eyebrow);
        font-weight: 700;
        letter-spacing: var(--pvs-ls-eyebrow);
        text-transform: uppercase;
    }

    .login-intro h1 {
        margin: 0;
        font-family: var(--pvs-font-serif);
        font-size: clamp(2.6rem, 5.2vw, 5rem);
        font-weight: 400;
        letter-spacing: -.045em;
        line-height: 1.03;
    }

    .login-intro h1 span {
        color: var(--pvs-gold);
    }

    .login-intro__text,
    .login-intro__footnote {
        color: var(--pvs-text-muted);
        font-size: var(--pvs-fs-body);
        line-height: 1.7;
    }

    .login-intro__text {
        max-width: 22rem;
        margin: 1.5rem 0 0;
    }

    .login-intro__footnote {
        max-width: 25rem;
        margin: 0;
        color: var(--pvs-text-soft);
        font-size: var(--pvs-fs-small);
    }

    .login-panel {
        display: grid;
        align-items: center;
        padding: clamp(2rem, 5vw, 4rem);
        border-left: 1px solid var(--pvs-border);
        background: rgba(255, 255, 255, .018);
    }

    .login-panel__content {
        width: min(100%, 390px);
        margin: 0 auto;
    }

    .login-panel__header {
        margin-bottom: 2rem;
    }

    .login-panel__header h2 {
        margin: 0;
        font-size: clamp(1.8rem, 3vw, 2.3rem);
        font-weight: 600;
        letter-spacing: -.035em;
    }

    .login-panel__header > p:last-child {
        margin: .7rem 0 0;
        color: var(--pvs-text-muted);
        font-size: var(--pvs-fs-body);
        line-height: 1.6;
    }

    .login-form {
        display: grid;
        gap: 1.35rem;
    }

    .login-field label {
        display: block;
        margin-bottom: .55rem;
        color: var(--pvs-text);
        font-size: .9rem;
        font-weight: 550;
    }

    .login-field input {
        width: 100%;
        min-height: 3.2rem;
        padding: .8rem .95rem;
        border: 1px solid var(--pvs-border-strong);
        border-radius: var(--pvs-radius-sm);
        outline: none;
        background: rgba(0, 0, 0, .28);
        color: var(--pvs-text);
        font: inherit;
        transition: border-color var(--pvs-transition), box-shadow var(--pvs-transition);
    }

    .login-field input::placeholder {
        color: var(--pvs-text-soft);
    }

    .login-field input:focus {
        border-color: var(--pvs-gold);
        box-shadow: 0 0 0 3px var(--pvs-gold-soft);
    }

    .login-password {
        position: relative;
    }

    .login-password input {
        padding-right: 3.25rem;
    }

    .login-password__toggle {
        position: absolute;
        top: 50%;
        right: .5rem;
        display: grid;
        width: 2.25rem;
        height: 2.25rem;
        place-items: center;
        transform: translateY(-50%);
        border: 0;
        border-radius: 7px;
        background: transparent;
        color: var(--pvs-text-muted);
        cursor: pointer;
    }

    .login-password__toggle:hover {
        background: var(--pvs-surface);
        color: var(--pvs-gold-light);
    }

    .login-password__toggle:focus-visible,
    .login-submit:focus-visible,
    .login-brand:focus-visible {
        outline: 3px solid var(--pvs-gold);
        outline-offset: 3px;
    }

    .login-message {
        margin: 0;
        padding: .8rem .9rem;
        border: 1px solid rgba(248, 113, 113, .4);
        border-radius: var(--pvs-radius-sm);
        background: rgba(127, 29, 29, .18);
        color: #fecaca;
        font-size: .9rem;
        line-height: 1.5;
    }

    .login-submit {
        display: flex;
        min-height: 3.25rem;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .8rem 1rem .8rem 1.15rem;
        border: 1px solid transparent;
        border-radius: var(--pvs-radius-sm);
        background: var(--pvs-gold-gradient);
        color: var(--pvs-text-dark);
        font: inherit;
        font-weight: 700;
        cursor: pointer;
        transition: filter var(--pvs-transition), transform var(--pvs-transition);
    }

    .login-submit:hover:not(:disabled) {
        filter: brightness(1.08);
        transform: translateY(-1px);
    }

    .login-submit:disabled {
        cursor: wait;
        opacity: .7;
    }

    .login-submit[aria-busy="true"] span::after {
        content: " …";
    }

    .login-panel__note {
        margin: 1.6rem 0 0;
        color: var(--pvs-text-soft);
        font-size: var(--pvs-fs-small);
        line-height: 1.6;
    }

    @media (max-width: 767px) {
        .login-shell {
            padding: 1rem;
        }

        .login-layout {
            min-height: 0;
            grid-template-columns: 1fr;
            border-radius: var(--pvs-radius);
        }

        .login-intro {
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .login-brand__logo {
            width: 2.75rem;
            height: 2.75rem;
        }

        .login-intro__copy {
            padding: 1rem 0 .25rem;
        }

        .login-intro h1 {
            font-size: clamp(2.4rem, 10vw, 3.4rem);
        }

        .login-intro__text {
            margin-top: 1rem;
        }

        .login-intro__footnote {
            display: none;
        }

        .login-panel {
            padding: 1.75rem 1.5rem 2rem;
            border-top: 1px solid var(--pvs-border);
            border-left: 0;
        }
    }

    @media (max-width: 380px) {
        .login-intro,
        .login-panel {
            padding-right: 1.15rem;
            padding-left: 1.15rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .login-page *,
        .login-page *::before,
        .login-page *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<main class="login-shell">
    <div class="login-layout">
        <section class="login-intro" aria-labelledby="login-brand-title">
            <a class="login-brand" href="<?= htmlspecialchars(BASE_URL . '/login', ENT_QUOTES, 'UTF-8') ?>" aria-label="Private Value Society – Startseite">
                <img
                    class="login-brand__logo"
                    src="<?= htmlspecialchars(IMAGES_URL . '/logo/pvs_logo.png', ENT_QUOTES, 'UTF-8') ?>"
                    alt=""
                    width="72"
                    height="72">
                <span class="login-brand__name">Private Value Society</span>
            </a>

            <div class="login-intro__copy">
                <p class="login-eyebrow">Adminbereich</p>
                <h1 id="login-brand-title">Finanzwissen.<br>Netzwerk.<br><span>Zukunft.</span></h1>
                <p class="login-intro__text">Der interne Zugang für die Verwaltung der Private Value Society.</p>
            </div>

            <p class="login-intro__footnote">Ein Netzwerk für Wissen, Austausch und persönliche Entwicklung.</p>
        </section>

        <section class="login-panel" aria-labelledby="login-title">
            <div class="login-panel__content">
                <header class="login-panel__header">
                    <p class="login-eyebrow">Willkommen zurück</p>
                    <h2 id="login-title">Anmelden</h2>
                    <p>Gib deine Zugangsdaten ein, um fortzufahren.</p>
                </header>

                <form id="loginForm" class="login-form" method="post" action="<?= htmlspecialchars(BACKEND_URL . '/backend-login.php', ENT_QUOTES, 'UTF-8') ?>">
                    <div class="login-field">
                        <label for="login-email">E-Mail-Adresse</label>
                        <input
                            id="login-email"
                            name="email"
                            type="email"
                            autocomplete="username"
                            inputmode="email"
                            placeholder="name@beispiel.de"
                            required>
                    </div>

                    <div class="login-field">
                        <label for="login-password">Passwort</label>
                        <div class="login-password">
                            <input
                                id="login-password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Passwort eingeben"
                                required>
                            <button
                                class="login-password__toggle"
                                id="togglePassword"
                                type="button"
                                aria-label="Passwort anzeigen"
                                aria-pressed="false">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <p class="login-message" id="loginMessage" role="status" aria-live="polite" hidden></p>

                    <button class="login-submit" id="loginSubmit" type="submit">
                        <span>Anmelden</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <p class="login-panel__note">Dieser Bereich ist ausschließlich für autorisierte Teammitglieder vorgesehen.</p>
            </div>
        </section>
    </div>
</main>

<script>
    (function () {
        const form = document.getElementById("loginForm");
        const password = document.getElementById("login-password");
        const toggle = document.getElementById("togglePassword");
        const message = document.getElementById("loginMessage");
        const submitButton = document.getElementById("loginSubmit");
        const loginEndpoint = <?= json_encode(BACKEND_URL . '/backend-login.php', JSON_UNESCAPED_SLASHES) ?>;
        const dashboardUrl = <?= json_encode(BASE_URL . '/dashboard', JSON_UNESCAPED_SLASHES) ?>;

        toggle.addEventListener("click", function () {
            const isVisible = password.type === "text";
            password.type = isVisible ? "password" : "text";
            toggle.setAttribute("aria-pressed", String(!isVisible));
            toggle.setAttribute("aria-label", isVisible ? "Passwort anzeigen" : "Passwort verbergen");
            toggle.innerHTML = isVisible
                ? '<i class="fa-solid fa-eye" aria-hidden="true"></i>'
                : '<i class="fa-solid fa-eye-slash" aria-hidden="true"></i>';
        });

        form.addEventListener("submit", async function (event) {
            event.preventDefault();
            message.hidden = true;
            message.textContent = "";
            submitButton.disabled = true;
            submitButton.setAttribute("aria-busy", "true");

            try {
                const response = await fetch(loginEndpoint, {
                    method: "POST",
                    body: new FormData(form),
                    headers: { "Accept": "text/plain" },
                    credentials: "same-origin"
                });
                const result = (await response.text()).trim();

                if (!response.ok || result !== "success") {
                    throw new Error(result || "Die Anmeldung ist fehlgeschlagen. Bitte versuche es erneut.");
                }

                window.location.assign(dashboardUrl);
            } catch (error) {
                message.textContent = error instanceof Error
                    ? error.message
                    : "Der Anmeldedienst ist momentan nicht erreichbar.";
                message.hidden = false;
                password.focus();
            } finally {
                submitButton.disabled = false;
                submitButton.removeAttribute("aria-busy");
            }
        });
    }());
</script>

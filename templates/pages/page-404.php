<style>
    .error-404 {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        text-align: center;
        padding: 6rem 1.5rem;
    }

    .error-404 .container {
        max-width: 700px;
    }

    .error-code {
        display: block;
        font-size: clamp(5rem, 15vw, 10rem);
        font-weight: 800;
        line-height: 1;
        color: var(--wp--preset--color--primary, #0d6efd);
        margin-bottom: 1rem;
    }

    .page-title {
        margin-bottom: 1rem;
    }

    .page-description {
        max-width: 560px;
        margin: 0 auto 2.5rem;
        font-size: 1.125rem;
        color: #666;
    }

    .error-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .9rem 1.6rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-primary {
        background: #0d6efd;
        color: #fff;
    }

    .btn-primary:hover {
        background: #0b5ed7;
    }

    .btn-secondary {
        border: 2px solid #0d6efd;
        color: #0d6efd;
        background: transparent;
    }

    .btn-secondary:hover {
        background: #0d6efd;
        color: #fff;
    }
</style>



<main id="primary" class="site-main">

    <section class="error-404 not-found">
        <div class="container">

            <span class="error-code">404</span>

            <h1 class="page-title">
                Seite nicht gefunden
            </h1>

            <p class="page-description">
                Ups! Die von dir gesuchte Seite existiert nicht, wurde verschoben
                oder die eingegebene Adresse ist nicht korrekt.
            </p>

            <div class="error-actions">
                <a href="#" class="btn btn-primary">
                    Zur Startseite
                </a>

                <a href="#" class="btn btn-secondary">
                    Kontakt aufnehmen
                </a>
            </div>

        </div>
    </section>

</main>

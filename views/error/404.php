<?php
ob_clean();
?>

<section class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 text-center">
            <h1 class="display-1">404</h1>
            <h2>Pagina non trovata!</h2>
            <div class="mt-4">
                <img class="img_404" src="/public/media/troll-LOL.png" alt="LOL troll">
            </div>
            <div class="mt-4">
                <a href="/" class="link-error-page fs-3">Torna alla home</a>
            </div>
        </div>
    </div>
</section>

<?php
$slotError = ob_get_clean();
include_once __DIR__ . '/../components/error-layout.php';

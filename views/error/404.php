<?php
ob_clean();
?>

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 text-center">
            <h1>404</h1>
            <h2>Pagina non trovata!</h2>
            <img class="img_404" src="https://i.etsystatic.com/36104253/r/il/312d48/5128189533/il_fullxfull.5128189533_t29w.jpg" alt="LOL troll">
            <div class="mt-4">
                <a href="/">Torna alla home</a>
            </div>
        </div>
    </div>
</section>

<?php
$slotError = ob_get_clean();
include_once __DIR__ . '/../components/error-layout.php';
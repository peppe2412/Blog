<?php
session_start();
$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);

ob_start();
?>

<h1>Crea post</h1>

<section class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-5">
            <?php if($alert): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($alert) ?></div>
            <?php endif; ?>
            <form method="POST" action="/posts/store" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input name="title" type="text" class="form-control" id="title">
                </div>
                <div class="mb-3">
                    <label for="subtitle" class="form-label">Sottotitolo</label>
                    <input name="subtitle" type="text" class="form-control" id="subtitle">
                </div>
                <div class="mb-3">
                    <label for="body">Contenuto</label>
                    <textarea class="form-control" name="body" id="body"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Immagine (facoltativa)</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Pubblica</button>
            </form>
        </div>
    </div>
</section>

<?php
$slotDashboard = ob_get_clean();
include_once __DIR__ . '/../components/layout.php';
?>
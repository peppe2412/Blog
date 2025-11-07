<?php

require_once __DIR__ . '/../../../config/init.php';

session_start();
$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);


ob_start();
?>

<h1>Modifica Post</h1>

<section class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-5">
            <?php if ($alert): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($alert) ?></div>
            <?php endif; ?>
            <form method="POST" action="/posts/update/<?= htmlspecialchars($post['id']) ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="<?= htmlspecialchars($post['title']) ?>">
                </div>
                <div class="mb-3">
                    <label for="subtitle" class="form-label">Sottotitolo</label>
                    <input alue="<?= htmlspecialchars($post['subtitle']) ?>" name="subtitle" type="text" class="form-control" id="subtitle">
                </div>
                <div class="mb-3">
                    <label for="body">Contenuto</label>
                    <textarea alue="<?= htmlspecialchars($post['body']) ?>" class="form-control" name="body" id="body"></textarea>
                </div>
                <div class="mb-3">
                    <img class="img-fluid mb-3" src="/public/uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    <label for="image">Sostituisci immagine</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Modifica</button>
            </form>
        </div>
    </div>
</section>


<script>
    tinymce.init({
        selector: '#body',
        plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'searchreplace', 'visualblocks', 'wordcount',
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'code | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        uploadcare_public_key: '<?= htmlspecialchars($uploadKey); ?>',
    });
</script>

<?php
$slotDashboard = ob_get_clean();
include_once __DIR__ . '/../components/layout.php';
?>
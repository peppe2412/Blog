<?php

require_once __DIR__ . '/../../config/database.php';

// Legge i posts
$stmt = $connection->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<header class="container header-index-posts">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 text-center">
            <h1 class="display-2">Tutti i posts</h1>
        </div>
    </div>
</header>


<section class="container py-5">
    <div class="row justify-content-center">
        <?php foreach ($posts as $post): ?>
            <div class="col-12 col-lg-4">
                <div class="card shadow mb-5">
                    <a href="/posts/detail/<?= urlencode($post['title']) ?>">
                        <img src="/public/uploads/<?= htmlspecialchars($post['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                            <h5 class="card-title"><?= htmlspecialchars($post['subtitle']) ?></h5>
                            <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($post['created_at']))) ?></small>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>



<?php
$slot = ob_get_clean();
include_once __DIR__ . '/../components/layout.php';

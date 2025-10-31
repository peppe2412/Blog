<?php

require_once __DIR__ . '/../config/database.php';

session_start();

$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);

$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

// Legge i posts
$stmt = $connection->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<h1>Home</h1>
<?php if ($alert): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($alert) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<section class="container">
    <div class="row justify-content-center">
        <?php if ($posts): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-12 col-lg-4">
                    <a href="/posts/detail/<?= urlencode($post['title']) ?>">
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 18rem;">
                                <?php if (!empty($post['image'])): ?>
                                    <img src="/public/uploads/<?= htmlspecialchars($post['image']); ?>" class="card-img-top" alt="...">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                                    <h5 class="card-title"><?= htmlspecialchars($post['subtitle']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($post['body']) ?></p>
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h3>Non ci sono posts</h3>
        <?php endif; ?>
    </div>
</section>



<?php
$slot = ob_get_clean();
include_once __DIR__ . '/components/layout.php';
?>
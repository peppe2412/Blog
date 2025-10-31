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


<main class="container-fluid">
    <div class="row">
        <?php if ($posts): ?>
            <?php
            $main = $posts[0];
            $others = array_slice($posts, 1);
            ?>
        <?php endif; ?>
        <div class="col-12 col-lg-12">
            <h2>Post principale</h2>
            <a href="/posts/detail/<?= urlencode($main['title']) ?>">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php if (!empty($main['image'])): ?>
                                <img src="/public/uploads/<?= htmlspecialchars($main['image']); ?>" class="img-fluid rounded-start" alt="...">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title"><?= htmlspecialchars($main['title']) ?></h3>
                                <h5 class="card-title"><?= htmlspecialchars($main['subtitle']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($main['body']) ?></p>
                                <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($main['created_at']))) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

<section class="container">
    <div class="row justify-content-center">
        <?php if ($others): ?>
            <?php foreach ($others as $post): ?>
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
                                    <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($post['created_at']))) ?></small>
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
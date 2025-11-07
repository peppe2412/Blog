<?php

require_once __DIR__ . '/../config/database.php';

// session_start();

$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);

$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

// Legge i posts
$stmt = $connection->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<section class="span-messages">
    <?php if ($alert): ?>
        <div class="alert-home span-message">
            <p class="content-span-home m-0 p-2">
                <span class="me-2">
                    <svg width="26px" height="26px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#e20303">
                        <path d="M12 7L12 12" stroke="#e20303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12 16.01L12.01 15.9989" stroke="#e20303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M5 18L3.13036 4.91253C3.05646 4.39524 3.39389 3.91247 3.90398 3.79912L11.5661 2.09641C11.8519 2.03291 12.1481 2.03291 12.4339 2.09641L20.096 3.79912C20.6061 3.91247 20.9435 4.39524 20.8696 4.91252L19 18C18.9293 18.495 18.5 21.5 12 21.5C5.5 21.5 5.07071 18.495 5 18Z" stroke="#e20303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
                <?= htmlspecialchars($alert) ?>
            </p>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success-home span-message">
            <p class="content-span-home text-center m-0 py-2">
                <span class="me-2">
                    <svg width="26px" height="26px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#07e203">
                        <path d="M7 12.5L10 15.5L17 8.5" stroke="#07e203" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#07e203" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
                <?= htmlspecialchars($success) ?>
            </p>
        </div>
    <?php endif; ?>
</section>
<!-- 
<header class="logo-container">
    <div class="d-flex justify-content-center">
        <img class="logo" src="/public/media//logo.png" alt="Logo Blog">
    </div>
</header> -->

<main class="container post-main-container">
    <div class="row">
        <?php if ($posts): ?>
            <?php
            $main = $posts[0];
            $others = array_slice($posts, 1);
            ?>
        <?php endif; ?>
        <div class="col-12 col-lg-12">
            <h2 class="mb-4 display-5 mainPostTitleEffect" id="mainTitle">
                Post principale
            </h2>
            <?php if (!$main): ?>
                <h3>Nessun post</h3>
            <?php else: ?>
                <div class="card mb-3 shadow">
                    <a href="/posts/detail/<?= urlencode($main['title']) ?>">
                        <div class="row g-0">
                            <div class="col-12 col-lg-6">
                                <?php if (!empty($main['image'])): ?>
                                    <img src="/public/uploads/<?= htmlspecialchars($main['image']); ?>" class="img-fluid rounded-start" alt="...">
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($main['title']) ?></h3>
                                    <h5 class="card-title"><?= htmlspecialchars($main['subtitle']) ?></h5>
                                    <p class="card-text"><?= $main['body'] ?></p>
                                    <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($main['created_at']))) ?></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<section class="container">
    <div class="mb-3">
        <h2 class="otherPostTitle">Altri posts</h2>
        <h4 class="subtititle-othersPosts">Sfoglia gli altri posts</h4>
    </div>
    <div class="row justify-content-center gap-3">
        <?php if ($others): ?>
            <?php foreach ($others as $post): ?>
                <div class="col-12 col-lg-2">
                    <div class="d-flex justify-content-center">
                        <div class="card shadow card-others-posts">
                            <a href="/posts/detail/<?= urlencode($post['title']) ?>">
                                <?php if (!empty($post['image'])): ?>
                                    <img src="/public/uploads/<?= htmlspecialchars($post['image']); ?>" class="card-img-top" alt="...">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                                    <h5 class="card-title"><?= htmlspecialchars($post['subtitle']) ?></h5>
                                    <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($post['created_at']))) ?></small>
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                            </a>
                        </div>
                    </div>
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
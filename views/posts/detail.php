<?php
session_start();

$connection = require __DIR__ . '/../../config/database.php';

$stmt = $connection->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<?php if ($post): ?>
    <section class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <h1>
                    <?= htmlspecialchars($post['title']) ?>
                </h1>
                <h2><?= htmlspecialchars($post['subtitle']) ?></h2>
                <?php if (!empty($post['image'])): ?>
                    <div>
                        <img src="/public/uploads/<?= htmlspecialchars($post['image']); ?>" class="card-img-top" alt="...">
                    </div>
                <?php endif; ?>
                <div>
                    <p><?= $post['body'] ?></p>
                </div>
                <small>Creato il: <?= htmlspecialchars(date('d-m-Y', strtotime($post['created_at']))) ?></small>
                <div>
                    <?php if (isset($_SESSION['auth_hash'])): ?>
                        <a class="btn btn-info" href="/posts/edit/<?= $post['id'] ?>">Modifica articolo</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$slot = ob_get_clean();
require_once __DIR__ . '/../components/layout.php';
?>
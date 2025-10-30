<?php
session_start();

$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);

ob_start();
?>

<h1>Home</h1>
<?php if ($alert): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($alert) ?></div>
<?php endif; ?>

<?php
$slot = ob_get_clean();
include_once __DIR__ . '/components/layout.php';
?>
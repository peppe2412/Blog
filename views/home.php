<?php
session_start();
$success = $_SESSION['auth_success'] ?? null;
unset($_SESSION['auth_success']);
ob_start();
?>

<h1>Home</h1>
<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php
$slot = ob_get_clean();
include_once __DIR__ . '/components/layout.php';
?>
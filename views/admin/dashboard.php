<?php
session_start();

$success = $_SESSION['auth_success'] ?? null;
unset($_SESSION['auth_success']);

ob_start();
?>

<h1>Dashboard</h1>
<a href="/logout">Logout</a>
<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php 
$slotDashboard = ob_get_clean();
include_once __DIR__ . '/components/layout.php'; 
?>
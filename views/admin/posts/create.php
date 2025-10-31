<?php
ob_start();
?>

<h1>Crea post</h1>

<?php
$slotDashboard = ob_get_clean();
include_once __DIR__ . '/../components/layout.php';
?>
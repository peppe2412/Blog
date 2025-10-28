<?php
ob_start();
?>

<h1>Home</h1>

<?php
$slot = ob_get_clean();
include_once __DIR__ . '/components/layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="/assets//css//style.css">
</head>
<body>

    <?php
    include_once __DIR__ . '/navbar.php';
    echo $slot;
    include_once __DIR__ . '/footer.php';
    ?>

    <script src="/assets//js//main.js" type="module"></script>
</body>
</html>
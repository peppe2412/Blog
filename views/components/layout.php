<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="/assets//css//style.css">
    <script src="https://cdn.tiny.cloud/1/1f8smfpjchctovmeffgtaoiggfqripailb7biamog8nd3j3o/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
</head>
</head>

<body>

    <?php include_once __DIR__ . '/navbar.php'; ?>
    <main>
        <?php echo $slot ?>
    </main>
    <?php include_once __DIR__ . '/footer.php'; ?>

    <script src="/assets//js//main.js" type="module"></script>
</body>

</html>
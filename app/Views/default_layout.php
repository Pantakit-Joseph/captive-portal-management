<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= csrf_meta() ?>

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>" defer></script>

    <?= $this->renderSection('head') ?>

    <script src="<?= base_url('assets/alpinejs/dist/cdn.min.js') ?>" defer></script>
</head>
<body>
    <?= $this->renderSection('body') ?>

    <?= $this->renderSection('script') ?>
</body>
</html>
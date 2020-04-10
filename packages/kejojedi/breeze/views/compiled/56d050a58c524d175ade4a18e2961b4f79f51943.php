<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo e($title); ?> | <?php echo e(app_title); ?></title>

    <?php echo file_get_contents(app_url . '/styles.php'); ?>

</head>
<body>
    <?php echo $content; ?>


    <?php echo file_get_contents(app_url . '/scripts.php'); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\breeze\packages\kejojedi\breeze\views\templates/layout.blade.php ENDPATH**/ ?>
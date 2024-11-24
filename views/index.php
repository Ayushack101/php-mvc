<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Hello, World!</h1>
    <?php
    print_r($data);
    foreach ($data as $key) {
        ?>
        <p><?php echo $key['name']; ?></p>
        <p><?php echo $key['class']; ?></p>
        <p><?php echo $key['language']; ?></p>
        <?php
    }
    ?>
    <?php
    echo $session->get('asd');
    ?>
    <a href="<?php echo $route ?>add">Go to add</a>
</body>

</html>
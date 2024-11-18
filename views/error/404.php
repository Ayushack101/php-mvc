<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
</head>

<body>
    <?php
    if ($status_code === 404) {
        ?>
        <h1>Error Occured! <?php
        echo $message;
        ?></h1>
        <?php
    }
    if ($status_code === 500) {
        ?>
        <h1>Internal Server Error! <?php
        echo $message;
        ?></h1>
        <?php
    }
    ?>
</body>

</html>
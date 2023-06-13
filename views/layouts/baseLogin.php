<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome !</title>
        <link rel="stylesheet" href="public/styles/app.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merienda:wght@300;400;500;600;700;800;900&display=swap">
    </head>
    <body>
        <div class="wrapper">
            <?php require "views/templates/headerHome.php" ?>
            <div class="wrapperInside">
                <?= $content ?>
            </div>
        </div>
    </body>
</html>


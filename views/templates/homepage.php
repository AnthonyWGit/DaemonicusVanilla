<?php ob_start() ?>

        <h1> Daemonicus </h1>

        <h3>A tale about mythologies, epic heroes, adventure, magic and glory</h3>
        <button class="insideBtn">Explore</button>
        <button class="insideBtn"><a href="index.php?action=displayRegister">Join in</a></button>
        <button class="insideBtn">Launch game</button>

<?php $content = ob_get_clean();?>

<?php require_once ("views/layouts/base.php") ?>

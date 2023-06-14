<?php ob_start() ?>

        <h1> Daemonicus </h1>

        <h3>A tale about mythologies, epic heroes, adventure, magic and glory</h3>
        <button class="insideBtn">Explore</button>
        <a href="index.php?action=displayRegister"><button class="insideBtn">Join in</button></a>
        <a href="game.php?action=process"><button class="insideBtn">Launch game</button></a>


<?php $content = ob_get_clean();?>

<?php require_once ("views/layouts/base.php") ?>

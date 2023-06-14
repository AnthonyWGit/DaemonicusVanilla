<?php ob_start() ?>

<p>What do you want to do ? </p>

<p>Fight</p>

<p>Buy items</p>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
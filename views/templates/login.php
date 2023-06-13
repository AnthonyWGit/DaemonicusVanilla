<?php ob_start() ?>

    <p>LOGIN PAGE</p>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
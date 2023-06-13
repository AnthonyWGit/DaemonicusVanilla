<?php ob_start() ?>

<?= $_SESSION["msg"] ?>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
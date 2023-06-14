<?php ob_start() ?>

    <p>An associated email has been found<p>
    
    <form method="post" id="form-recovery" action="index.php?action=verifyRecovery"> 
        <input type="text" name="recovery" placeholder="Your recovery token">
    </form>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
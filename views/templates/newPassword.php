<?php ob_start() ?>

<form method="post" action="index.php?action=checkNewPwd" class="yyy" id="form-register" name="registration">

    <div class="formDiv">
        
        <div class="col">
            <label>Mot de passe</label>
            <input type="password" name="password" id="password-input" placeholder="Password" required>
        </div>

        
        <div class="col">
            <label>Confirmez le mot de passe</label>
            <input type="password" name="password-confirm" id="password-input-confirm" placeholder="Password" required>
        </div>


        <button>Confirm</button>

</form>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
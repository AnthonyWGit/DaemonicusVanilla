<?php ob_start() ?>

<form method="post" action="index.php?action=checkInfosLogin" class="yyy" id="form-register" name="registration">

    <div class="formDiv">
        
            <div class="col">
                <label>Username</label>
                <input type="text" name="username" id="username-input" placeholder="Enter username" required>
            </div>

            <div class="col">
                <label>pWD</label>
                <input type="password" name="password" id="password-input" placeholder="Password" required>
            </div>

            <button>Confirm</button>
        
</form>

<p><a href="index.php?action=forgotPwd">Mot de passe oublié ?</a> </p>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
<?php ob_start() ?>

<form method="post" action="index.php?action=checkInfosForgotPwd" class="yyy" id="form-register" name="registration">

    <div class="formDiv">
        
            <div class="col">
                <label>Username</label>
                <input type="text" name="username" id="username-input" placeholder="Enter username" required>
            </div>

            <button>Confirm</button>

            <p>You will receive an email with a link to verify your account.</p>
</form>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
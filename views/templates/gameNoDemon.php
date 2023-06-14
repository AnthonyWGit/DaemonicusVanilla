<?php ob_start() ?>

    <p id="one"></p>
    <p id="two"></p>
    <p id="three"></p>
    <p id="four"></p>


<script src="public\js\beginning.js"></script>       
<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
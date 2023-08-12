<?php ob_start() ?>
<div class="wrapperInside">
    <div class="player">
        <p id="deamonPlayer"> <?= $daemon[0]["nom_pkm"] ?> Level <?= $daemonPlayerLevel ?></p>

        <div class="hp-bar">
            <div class="hp-fill">

            </div>
        </div>
    </div>

    <div class="cpu">
        <p id="deamonCPU"><?= $daemonCPU[0]["nom_pkm"] ?> Level <?= $daemonCPULevel ?></p>
        <div class="hp-bar">
            <div class="hp-fill">
                
            </div>
        </div>
    </div>
    
</div>
<div class="actions" id="actions_menu">
    <p class="title">What do you want to do ?</p> 
    <div class="actionsElement">
        <p id="daemon_skill">Daemon action</p>
        <p id="item">Use item</p>
        <p id="switch">Switch Daemon</p>
        <p id="flee">Flee !</p>        
    </div>

</div>

<script>
        var initiative = "<?php echo $initiative; ?>";
</script>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/combat.php")?>
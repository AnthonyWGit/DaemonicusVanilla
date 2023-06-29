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
<div class="actions">
    <p class="title">What do you want to do ?</p> 
    <div class="actionsElement">
        <p>Daemon action </p>
        <p>Use item</p>
        <p>Switch Daemon</p>
        <p>Flee !</p>        
    </div>

</div>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/combat.php")?>
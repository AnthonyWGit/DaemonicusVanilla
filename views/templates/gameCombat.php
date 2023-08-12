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

    function targetElements() 
    {
        daemonSkills.remove();
        item.remove();
        switchF.remove();
        flee.remove();
        titleMenu.remove();
        
        // Iterate through the arraySkillsJson and create paragraphs
        arraySkillsJson.forEach
        (
            function(skillText) 
                {
                    let newParagraph = document.createElement("p");
                    newParagraph.textContent = skillText;
                    actionsElement.appendChild(newParagraph);
                }
        );
        
    }

    let actionsElement = document.querySelector(".actionsElement");
    const daemonSkills = document.querySelector("#daemon_skill");
    const item = document.querySelector("#item");
    const switchF = document.querySelector("#switch");
    const flee = document.querySelector("#flee");
    const titleMenu = document.querySelector("p.title");
    const actionsMenu = document.querySelector("#actions_menu");

    daemonSkills.addEventListener("click", targetElements);
    let initiative = "<?php echo $initiative; ?>";
    let arraySkillsJson = <?php echo $arrayOfSkillsJson; ?>;
    console.log(arraySkillsJson);
</script>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/combat.php")?>
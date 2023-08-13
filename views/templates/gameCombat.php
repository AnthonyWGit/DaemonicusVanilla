<?php ob_start() ?>
<div class="wrapperInside">
    <div class="player">
        <p id="deamonPlayer"> <?= $daemon[0]["nom_pkm"] ?> Level <?= $daemonPlayerLevel ?></p>
        <p id="deamonPlayerHP"> <?= $_SESSION["playerDaemonCurrentHP"] ?> HP </p>
        <div class="hp-bar">
            <div class="hp-fill" >

            </div>
        </div>
    </div>

    <div class="cpu">
        <p id="deamonCPU"><?= $daemonCPU[0]["nom_pkm"] ?> Level <?= $daemonCPULevel ?></p>
        <p id="deamonPlayerHP"> <?= $_SESSION["CPUDaemonCurrentHP"] ?> HP </p>
        <div class="hp-bar">
            <div class="hp-fill" id="hp_fill_cpu">
                
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
                    actionsElement.appendChild(newParagraph);

                    let link = document.createElement("a");
                    link.textContent = skillText
                    link.href = "game.php?combat=skill&" + skillText

                    newParagraph.appendChild(link)
                }
        );
        
    }

    //Query selectorss 
    let actionsElement = document.querySelector(".actionsElement");
    const daemonSkills = document.querySelector("#daemon_skill");
    const item = document.querySelector("#item");
    const switchF = document.querySelector("#switch");
    const flee = document.querySelector("#flee");
    const titleMenu = document.querySelector("p.title");
    const actionsMenu = document.querySelector("#actions_menu");
    const hpFillCPU = document.querySelector("#hp_fill_cpu");

    let currentCPUHP = <?php echo $jsonCurrentCPUHp; ?>;
    let arraySkillsJson = <?php echo $arrayOfSkillsJson; ?>;

    daemonSkills.addEventListener("click", targetElements);
    hpFillCPU.style.width = currentCPUHP

    console.log(arraySkillsJson);
</script>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/combat.php")?>
<?php ob_start() ?>
<div class="wrapperInside">
    <div class="player">
        <p id="deamonPlayer"> <?= $daemon[0]["nom_pkm"] ?> Level <?= $daemonPlayerLevel ?></p>
        <p id="deamonPlayerHP"> <?= $_SESSION["playerDaemonCurrentHP"] != "" ? $_SESSION["playerDaemonCurrentHP"]. " HP" : "Dead" ?> </p>
        <div class="hp-bar">
            <div class="hp-fill animate" id="hp_fill_player">

            </div>
        </div>
    </div>

    <div class="cpu">
        <p id="deamonCPU"><?= $daemonCPU[0]["nom_pkm"] ?> Level <?= $daemonCPULevel ?></p>
        <p id="deamonPlayerHP"> <?= $_SESSION["CPUDaemonCurrentHP"] != "" ? $_SESSION["CPUDaemonCurrentHP"]." HP" : "Dead" ?> </p>
        <div class="hp-bar">
            <div class="hp-fill animate" id="hp_fill_cpu">
                
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

    function removeActions() //during ai turn : remove player actions and display ai skill 
    {
        daemonSkills.remove();
        item.remove();
        switchF.remove();
        flee.remove();
        titleMenu.remove();
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
    const hpFillPlayer = document.querySelector("#hp_fill_player");

    //retrieving vars for PHP 
    let currentCPUHP = <?php echo $jsonCurrentCPUHp; ?>;
    let currentPlayerHP = <?php echo $jsonCurrentPlayerHp; ?>;
    let arraySkillsJson = <?php echo $arrayOfSkillsJson; ?>;
    let arraySkillsJsonCPU = <?php echo $arrayOfSkillsJsonCPU; ?>;
    let maxCPUHP = <?php echo $jsonMaxCPUHp ?>;
    let maxPlayerHP = <?php echo $jsonMaxPlayerHp ?>; 
    let aiName = "<?php echo $daemonCPU[0]["nom_pkm"] ?>"
    console.log(currentPlayerHP)

    //Checking round so the player has not options when it's AI turn 
    let round = "<?php echo $_SESSION["round"] ?>"

    if (currentPlayerHP == "" || currentPlayerHP < 1)
    {
        removeActions()
    }
    else if (currentCPUHP == "" || currentCPUHP < 1)
    {
        removeActions()
    }

    if (round == "CPU" & currentCPUHP > 0)
    {
        removeActions();
        setTimeout(function(skillText)
        {
            {
                let randomIndex = Math.floor(Math.random() * arraySkillsJsonCPU.length);
                let randomAttack = arraySkillsJsonCPU[randomIndex]
                let newText = "Ennemy daemon used " + randomAttack 
                let message = document.createElement("p")
                message.innerHTML = newText
                actionsElement.appendChild(message)

                setTimeout(function(Wait) //wait so the player can see ennemy action 
                {
                    {
                        link = "game.php?combat=skill&" + randomAttack
                        window.location.href = link
                    }
                }
                , 5000)
            }
        ;
            }
        , 3000)
    }
    else if (round == "CPU" & currentCPUHP < 1)
    {
        removeActions();
        msg = "You gain some XP !" + "</br>" + "You get some gold !"
        let message = document.createElement("p")
        message.innerHTML = msg
        actionsElement.appendChild(message)
        setTimeout(function(ReturnToMenu)
        {
            link = "game.php?Hub"
            window.location.href = link
        }, 5000)
    }

    //Setting HP bar CSS style so the bar is empty when CPU HP is 0
    console.log(currentCPUHP)
    if (currentCPUHP <0 ) 
    {
        hpFillCPU.style.width = 0
    }
    else
    {
        hpFillCPU.style.width = ((currentCPUHP / maxCPUHP ) * 100) + "%";
    }

    //Setting HP bar CSS style so the bar is not full when player damage taken 
    if (currentPlayerHP < 0 ) 
    {
        hpFillPlayer.style.width = 0;
    }
    else
    {
        hpFillPlayer.style.width = ((currentPlayerHP / maxPlayerHP) * 100) + "%";
    }

    daemonSkills.addEventListener("click", targetElements);

    console.log(arraySkillsJson);
</script>

<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/combat.php")?>
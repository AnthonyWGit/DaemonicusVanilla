<?php ob_start() ?>

<p>What do you want to do ? </p>

<p><a href="game.php?combat">Fight</a></p>

<p>Buy items</p>

<p>Team</p>
<ul>

<?php foreach ($daemons as $daemon)
{?>
    <div class="r<?=$daemon["id_pkmn_joueur"]?>">
        <li><?=$daemon["nom_pkm"]?></li>
    </div>

<?php } ?>

<div class="stats"> 
    <p>Stats</p>
    <?php
    foreach ($updatedStatsPlayer as $key => $nestedArray) 
    {
        $pokemonName = key($nestedArray); // Get the Pokémon's name
        $pokemonStats = $nestedArray[$pokemonName]; // Get the Pokémon's stats
        ?>
        <div class="PtsAvaliable"></div>        
        <ul>
            <li><?= $pokemonName ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">For: <?= $pokemonStats["for"] ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">Agi: <?= $pokemonStats["agi"] ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">End: <?= $pokemonStats["end"] ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">Int: <?= $pokemonStats["int"] ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">Luck: <?= $pokemonStats["luck"] ?></li>
            <li class="listy<?= $pokemonStats["id_pkmn_joueur"]?>" id="<?= $pokemonStats["id_pkmn_joueur"] ?>">Def: <?= $pokemonStats["def"] ?></li>
        </ul>
        <?php
    }
    ?>
</div>


<button id="openPopup">Open </button>
    <div id="popupOverlay" class="overlay">
        <div id="popup" class="popup">
            <button id="closePopup">Close</button>
            <p>Pop-up content goes here.</p>
        </div>
    </div>

<script>

let capitalPts = <?php echo $jsonCapitalPts; ?>;
let names = <?php echo $jsonDaemonNames; ?>;
console.log(capitalPts)
let stat = ""

for (const key in capitalPts)
{
    if (capitalPts[key] != 0)
    {
        let buttonContain = document.querySelectorAll(".listy" + key)
        let idCatch = buttonContain[0].id; 
        console.log(key)
        count = 0
        let div = document.querySelector(".r" + key)
        let createParagraphLvlUp = document.createElement("p")
        createParagraphLvlUp.textContent = "Level up points avaliable : " + capitalPts[key] + " " 
        div.appendChild(createParagraphLvlUp)
        buttonContain.forEach(function(number)
        {
            switch (count)
            {
            case 0:
                stat = "for"
                break;
            case 1:
                stat = "agi"
                break;
            case 2:
                stat = "end"
                break;
            case 3:
                stat = "int"
                break;
            case 4:
                stat = "luck"
                break;
            case 5:
                stat = "def"
                break;
            }
            let statButton = document.createElement("button")
            let link = document.createElement("a")
            link.href = "game.php?action=lvlup&stat/" + stat + "_" + idCatch
            statButton.textContent = "+"
            link.appendChild(statButton)
            number.appendChild(link)
            count = count+1
        })
    }
    else
    {

    }    
}

const openPopupButton = document.getElementById('openPopup');
const closePopupButton = document.getElementById('closePopup');
const popupOverlay = document.getElementById('popupOverlay');

openPopupButton.addEventListener('click', () => {
    popupOverlay.style.display = 'block';
});

closePopupButton.addEventListener('click', () => {
    popupOverlay.style.display = 'none';
});

popupOverlay.addEventListener('click', (event) => {
    if (event.target === popupOverlay) {
        popupOverlay.style.display = 'none';
    }
});

</script>
<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
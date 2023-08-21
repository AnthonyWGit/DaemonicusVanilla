<?php ob_start() ?>

<p>What do you want to do ? </p>

<p><a href="game.php?combat">Fight</a></p>

<p>Buy items</p>

<p>Team</p>
<ul>

<?php foreach ($daemons as $daemon)
{?>

    <li><?=$daemon["nom_pkm"]?></li>

<?php } ?>

<p>Stats</p>
<?php foreach ($statsPlayer as $nestedArray)
{ ?>
    <?php foreach ($nestedArray as $lookFurther)
    {
    ?>
        <?php 
        $count = 0;
        foreach ($lookFurther as $statName=>$statValue)
        {
            if ($count == 6) break;
        ?>
            <li class="listy" id="<?= $lookFurther["id_pkmn_joueur"] ?>" ><?= $statName ?> <?= $statValue ?></li>
        <?php
        $count = $count+1;
        }
        ?>
    <?php
    }
    ?>
<?php
} ?>
<script>

let capitalPts = <?php echo $playerData["capital_pts"]; ?>;
console.log(capitalPts)
let stat = ""
let id = document.querySelector(".listy")
let idCatch = id.id
console.log(idCatch)
if (capitalPts != 0)
{
    let buttonContain = document.querySelectorAll(".listy")
    count = 0
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
</script>
<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
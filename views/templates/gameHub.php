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
        ?>
            <li class="listy" id="pak<?= $count ?>"><?= $statName ?> <?= $statValue ?></li>
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

let capitalPts = <?php echo $truc["capital_pts"]; ?>;
console.log(capitalPts)
if (capitalPts != 0)
{
    let buttonContain = document.querySelectorAll(".listy")
    count = 0
    buttonContain.forEach(function(number)
    {
        let statButton = document.createElement("button")
        statButton.textContent = "+"
        number.appendChild(statButton)
        count = count+1
    })
}
else
{

}
</script>
<?php $content = ob_get_clean() ?>

<?php require_once ("views/layouts/baseLogin.php")?>
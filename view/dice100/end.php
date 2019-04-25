<?php
$winner = "Ingen";

if ($player->totalScore() >= 100) {
    $winner = "Du";
} else if ($cpu->totalScore() >= 100) {
    $winner = "Servern";
}
?>

<h1><?= $winner ?> vann!</h1>

<p>Din poäng: <?= $player->totalScore(); ?></p>
<p>Serverns poäng: <?= $cpu->totalScore(); ?></p>

<form action="" method="POST">
    <button type="submit">Starta om</button>
</form>

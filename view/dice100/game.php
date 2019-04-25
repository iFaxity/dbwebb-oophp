

<?php include "icons.svg"; ?>

<?= $game->render(); ?>

<p>Din poäng: <?= $player->score(); ?></p>
<p>Serverns poäng: <?= $cpu->score(); ?></p>

<form action="" method="POST">
    <button type="submit" name="action" value="toss">Slå tärningarna</button>
    <button type="submit" name="action" value="end_turn">Avsluta rundan</button>
</form>

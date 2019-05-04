

<?php include "icons.svg"; ?>

<h1>Dice 100 v2</h1>

<p>Din poäng: <?= $player->score(); ?></p>
<p>Serverns poäng: <?= $cpu->score(); ?></p>

<form class="dice-form" action="" method="POST">
    <button type="submit" name="action" value="toss">Slå tärningarna</button>
    <?php if ($player->turnScore() > 0) : ?>
    <button class="red" type="submit" name="action" value="end_turn">Avsluta rundan</button>
    <?php endif; ?>
</form>

<?= $game->render(); ?>

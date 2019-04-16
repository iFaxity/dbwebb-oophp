<?php

$cheat  = $app->session->has("cheat");
$result = $app->session->get("result");
$guess  = $app->session->get("guess");

if (!isset($guess)) {
    // Save guess object in session
    $guess = new \Faxity\Guess\Guess();

    $app->session->set("guess", $guess);
}

$guesses = $guess->guesses();
?>

<main>
    <h1>Guess the number</h1>
    <p>Guess a number between 1 and 100, you have <?= $guess->tries() ?> tries left.</p>

    <form method="post" action="">
        <input type="number" name="guess" value="<?= $guess->lastGuess() ?>">
        <button type="submit" name="action" value="guess">Guess</button>
        <button type="submit" name="action" value="reset">Reset</button>
        <button type="submit" name="action" value="cheat">Cheat</button>
    </form>

    <?php if (!empty($guesses)) : ?>
    <h3>Guess list</h3>
    <ol>
        <?php foreach ($guesses as $item) : ?>
            <li><?= $item ?></li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>

    <?php if (isset($result)) : ?>
        <p>Guess: <?= $result ?></p>
    <?php endif; ?>

    <?php if (!empty($cheat)) : ?>
        <p>Psst, the number is: <?= $guess->number() ?></p>
    <?php endif; ?>
</main>

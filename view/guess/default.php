<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<main>
    <h1>Guess the number</h1>
    <p>Guess a number between 1 and 100, you have <?= $tries ?> tries left.</p>

    <form class="inline" method="post" action="">
        <input type="number" name="guess" value="<?= $lastGuess ?>">
        <button type="submit">Guess</button>
    </form>

    <form class="inline" method="post" action="guess/cheat">
        <button type="submit">Cheat</button>
    </form>

    <form class="inline" method="post" action="guess/reset">
        <button type="submit">Reset</button>
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
        <p>Psst, the number is: <?= $number ?></p>
    <?php endif; ?>
</main>

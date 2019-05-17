<?php include "layout.php"; ?>

<h1>Radera inlägg</h1>

<form action="" method="POST">
    <label for="title">Titel</label>
    <input id="title" disabled="" value="<?= esc($content->title) ?>">

    <button type="submit">Radera inlägg</button>
</form>

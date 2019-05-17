<?php
include "layout.php";

$types = [
    "page" => "Sida",
    "post" => "Blogginlägg",
];

?>

<h1>Redigera inlägg</h1>

<form action="" method="POST">
    <label for="title">Titel</label>
    <input id="title" name="title" value="<?= esc($content->title) ?>" autocomplete="off" required="">

    <label for="path">Sökväg:</label>
    <input id="path" name="path" value="<?= esc($content->path) ?>" autocomplete="off">

    <label for="slug">Slug:</label>
    <input id="slug" name="slug" value="<?= esc($content->slug) ?>" autocomplete="off" required="">

    <label for="data">Text:</label>
    <textarea id="data" name="data" rows="10" required=""><?= esc($content->data) ?></textarea>

    <label for="type">Typ:</label>
    <select id="type" name="type" required="">
        <option value="" disabled="">Välj typ</option>

        <?php foreach ($types as $type => $name) : ?>
        <option value="<?= esc($type) ?>" <?= $type == $content->type ? "selected=\"\"" : "" ?>>
            <?= esc($name) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <label for="filter">Filter:</label>
    <input id="filter" name="filter" value="<?= esc($content->filter) ?>" autocomplete="off" required="">

    <label for="published">Publicerad: (YYYY-MM-DD hh:mm:ss)</label>
    <input id="published" name="published" value="<?= esc($content->published) ?>" autocomplete="off" required="">

    <button type="submit">Redigera</button>
    <a class="button red" href="../delete/<?= esc($content->id) ?>">Radera</a>
</form>

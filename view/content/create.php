<?php include "layout.php"; ?>

<h1>Skapa nytt inlägg</h1>

<form action="" method="POST">
    <label for="title">Titel</label>
    <input id="title" name="title" autocomplete="off" required="">

    <label for="path">Sökväg:</label>
    <input id="path" name="path" autocomplete="off">

    <label for="slug">Slug:</label>
    <input id="slug" name="slug" autocomplete="off">

    <label for="data">Text:</label>
    <textarea id="data" name="data" rows="10" required=""></textarea>

    <label for="type">Typ:</label>
    <select id="type" name="type" required="">
        <option value="" disabled="" selected="">Välj typ</option>
        <option value="page">Sida</option>
        <option value="post">Blogginlägg</option>
    </select>

    <label for="filter">Filter:</label>
    <input id="filter" name="filter" autocomplete="off" required="">

    <label for="published">Publicerad: (YYYY-MM-DD hh:mm:ss)</label>
    <input id="published" name="published" autocomplete="off">

    <button type="submit">Skapa inlägg</button>
</form>


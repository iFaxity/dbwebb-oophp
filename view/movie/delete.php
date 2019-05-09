<?php
$image = empty($movie->image) ? "noimage.png" : $movie->image;
?>

<h1>Ta bort film</h1>

<form action="" method="POST">
    <p>Titel: <?= $movie->title ?></p>
    <p>År: <?= $movie->year ?></p>
    <p>Bild</p>
    <div style="max-width: 300px; margin-bottom: 1em;">
        <img src="../../image/movies/<?= $image ?>?width=300&height=300&crop-to-fit">
    </div>

    <button type="submit">Ta bort film</button>
</form>

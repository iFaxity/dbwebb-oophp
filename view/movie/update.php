<h1>Uppdatera film</h1>

<form action="" method="POST">
    <label for="title">Titel</label>
    <input id="title" name="title" required="" value="<?= $movie->title ?>">

    <label for="year">År</label>
    <input type="number" id="year" name="year" required="" value="<?= $movie->year ?>">

    <label for="image">Bildlänk</label>
    <input id="image" name="image" value="<?= $movie->image ?>">

    <button type="submit">Uppdatera film</button>
</form>

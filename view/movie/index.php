<h1>Filmer</h1>

<form action="" method="GET">
    <input id="query" name="q" value="<?= $query ?>"
        placeholder="Sök" autocomplete="off">

    <button type="submit">Sök</button>
</form>

<a class="button" href="movie/create">Lägg till film</a>

<?php if (empty($movies)) : ?>
    <h3>Inga filmer matchade sökningen</h3>
<?php else : ?>
<div class="table">
    <table>
        <thead>
            <tr>
                <th>Rad</th>
                <th>Id</th>
                <th>Bild</th>
                <th>Titel</th>
                <th>År</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $row => $movie) :
                $image = empty($movie->image) ? 'noimage.png' : $movie->image;
                ?>
                <tr>
                    <td><?= $row ?></td>
                    <td><?= $movie->id ?></td>
                    <td>
                        <img width="100" src="image/movies/<?= $image ?>?width=100&height=100&crop-to-fit">
                    </td>
                    <td><?= $movie->title ?></td>
                    <td><?= $movie->year ?></td>
                    <td>
                        <a class="button" href="movie/update/<?= $movie->id ?>">Redigera</a>
                    </td>
                    <td>
                        <a class="button" href="movie/delete/<?= $movie->id ?>">Ta bort</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

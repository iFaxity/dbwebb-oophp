<?php include "layout.php"; ?>

<header>
    <h1><?= esc($post->title) ?></h1>
    <p>
        <i>Uppdaterades:
            <time datetime="<?= esc($post->modified(true)) ?>" pubdate>
                <?= esc($post->modified()) ?>
            </time>
        </i>
    </p>
</header>

<?= $post->filterData() ?>

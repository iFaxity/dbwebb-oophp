<?php include "layout.php"; ?>

<header>
    <h1><?= esc($page->title) ?></h1>
    <p>
        <i>Uppdaterades:
            <time datetime="<?= esc($page->modified(true)) ?>" pubdate>
                <?= esc($page->modified()) ?>
            </time>
        </i>
    </p>
</header>

<?= $page->filterData() ?>

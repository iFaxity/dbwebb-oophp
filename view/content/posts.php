<?php include "layout.php"; ?>

<h1>Blogginlägg</h1>


<div class="posts">
    <?php foreach ($posts as $post) : ?>
    <div class="post">
        <h2>
            <a href="blog/<?= esc($post->slug) ?>"><?= esc($post->title) ?></a>
        </h2>
        <p>
            <i>Publicerad:
                <time datetime="<?= esc($post->modified(true)) ?>" pubdate>
                    <?= esc($post->modified()) ?>
                </time>
            </i>
        </p>

        <?= $post->filterData() ?>
    </div>
    <?php endforeach; ?>
</div>

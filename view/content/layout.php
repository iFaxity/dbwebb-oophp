<?php if (isset($flash)) : ?>
<div class="message <?= esc($flash->type) ?>">
    <header><?= esc($flash->title) ?></header>
    <?= esc($flash->message) ?>
</div>
<?php endif; ?>

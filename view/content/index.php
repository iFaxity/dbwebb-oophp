<?php
include "layout.php";

$admin = isset($admin) && $admin;
?>


<h1>CMS System</h1>

<?php if ($admin) : ?>
    <a class="button" href="create">Skapa ny</a>
<?php endif; ?>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Type</th>
                <th>Path</th>
                <th>Slug</th>
                <th>Published</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Deleted</th>

                <?php if ($admin) : ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $row) : ?>
                <tr>
                    <td><?= esc($row->id) ?></td>
                    <td>
                        <?php
                            $type = $row->type == "post" ? "blog" : "page";
                            $slug = $row->type == "post" ? $row->slug : $row->path;
                        ?>
                        <a href="<?= "{$type}/{$slug}" ?>"><?= esc($row->title) ?></a>
                    </td>
                    <td><?= esc($row->type) ?></td>
                    <td><?= esc($row->path) ?></td>
                    <td><?= esc($row->slug) ?></td>
                    <td><?= esc($row->published) ?></td>
                    <td><?= esc($row->created) ?></td>
                    <td><?= esc($row->updated) ?></td>
                    <td><?= esc($row->deleted) ?></td>

                    <?php if ($admin) : ?>
                        <td>
                            <a href="edit/<?= esc($row->id) ?>">&#x270E;</a>
                            <a href="delete/<?= esc($row->id) ?>">&#x1F5D1;</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

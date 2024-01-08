<h2><?= esc($title) ?></h2>

<?php if (! empty($news) && is_array($news)) : ?>

    <?php foreach ($news as $news_item): ?>
        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['description']) ?>
        </div>
        <p><a href="<?= '/news/'.$news_item['id'] ?>">View article</a></p>

    <?php endforeach; ?>

<?php else : ?>

    <h3>No News</h3>
    <p>Unable to find any news for you.</p>

<?php endif ?>

<div class="container my-5">
    <h2 class="mb-4">
        <?= esc($title) ?>
    </h2>

    <?php if (!empty($news) && is_array($news)): ?>
        <?php foreach ($news as $news_item): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">
                        <?= esc($news_item['title']) ?>
                    </h3>
                    <p class="card-text">
                        <?= str_replace("|||", "<br>", esc($news_item['description'])) ?>
                    </p>
                    <a href="<?= '/' . $news_item['id'] ?>" class="btn btn-primary">View article</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <h3>No News</h3>
            <p>Unable to find any news for you.</p>
        </div>
    <?php endif; ?>
</div>
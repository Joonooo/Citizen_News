<div class="container my-5">
    <h2 class="mb-4">
        <?= esc($title) ?>
    </h2>

    <!-- 카테고리 필터 드롭다운 -->
    <div class="mb-4">
        <select id="categoryFilter" class="form-select" onchange="filterByCategory()">
            <option value="">모든 카테고리</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= esc($category['category']) ?>"><?= esc($category['category']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <script>
        function filterByCategory() {
            var category = document.getElementById('categoryFilter').value;
            window.location.href = '/?category=' + category;
        }
    </script>

    <!-- 뉴스 아이템 -->
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
            <p>귀하에게 적합한 뉴스를 찾을 수 없습니다.</p>
        </div>
    <?php endif; ?>
</div>
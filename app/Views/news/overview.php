<div class="container my-5">
    <h2 class="mb-4">
        <?= esc($title) ?>
    </h2>

    <!-- 카테고리 필터 드롭다운 -->
    <div class="form-floating mb-4">
        <select id="categoryFilter" class="form-select" onchange="filterByCategory()">
            <option value="">모든 카테고리</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= esc($category['category']) ?>"><?= esc($category['category']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="categoryFilter">카테고리 선택</label>
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
            <div class="card mb-3 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= esc($news_item['image'] ?? 'default.jpg') ?>" class="img-fluid rounded-start"
                            alt="<?= esc($news_item['title']) ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h3 class="card-title">
                                <?= esc($news_item['title']) ?>
                            </h3>
                            <p class="card-text">
                                <?= str_replace("|||", "<br>", esc($news_item['description'])) ?>
                            </p>
                            <a href="<?= '/' . $news_item['id'] ?>" class="btn btn-primary"
                                aria-label="<?= esc($news_item['title']) ?> 읽기">자세히 보기</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <h3>뉴스가 없음</h3>
            <p>귀하에게 적합한 뉴스를 찾을 수 없습니다.</p>
        </div>
    <?php endif; ?>
</div>
<div class="container my-5">
    <h2 class="mb-4">
        <?= esc($title) ?>
        <?php if ($categoryQuery): ?>
            - <?= esc($categoryQuery) ?>
        <?php endif; ?>
    </h2>

    <!-- 카테고리 필터 폼 -->
    <form method="get" action="">
        <div class="form-floating mb-4">
            <select id="categoryFilter" name="category" class="form-select" onchange="this.form.submit()">
                <option value="">모든 카테고리</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['category']) ?>" <?= $categoryQuery == $category['category'] ? 'selected' : '' ?>>
                        <?= esc($category['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="categoryFilter">카테고리 선택</label>
        </div>
    </form>

    <!-- 뉴스 아이템 -->
    <?php if (!empty($news) && is_array($news)): ?>
        <?php foreach ($news as $news_item): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title"><?= esc($news_item['title']) ?></h3>
                    <p class="card-text"><?= str_replace("|||", "<br>", esc($news_item['description'])) ?></p>
                    <a href="<?= '/' . $news_item['id'] ?>" class="btn btn-primary"
                        aria-label="<?= esc($news_item['title']) ?> 읽기">자세히 보기</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- 페이지 네비게이션 -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- 이전 페이지 버튼 -->
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?category=<?= urlencode($categoryQuery) ?>&page=<?= $currentPage - 1 ?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- 페이지 번호 표시 -->
                <?php
                $pageRange = 2; // 현재 페이지 주변에 표시할 페이지 수
                $start = max(1, $currentPage - $pageRange);
                $end = min($totalPages, $currentPage + $pageRange);
                ?>

                <!-- 첫 페이지 표시 -->
                <?php if ($start > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?category=<?= urlencode($categoryQuery) ?>&page=1">1</a>
                    </li>
                    <?php if ($start > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- 중간 페이지 표시 -->
                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?category=<?= urlencode($categoryQuery) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- 마지막 페이지 표시 -->
                <?php if ($end < $totalPages): ?>
                    <?php if ($end < $totalPages - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="?category=<?= urlencode($categoryQuery) ?>&page=<?= $totalPages ?>"><?= $totalPages ?></a>
                    </li>
                <?php endif; ?>

                <!-- 다음 페이지 버튼 -->
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?category=<?= urlencode($categoryQuery) ?>&page=<?= $currentPage + 1 ?>"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <h3>뉴스가 없음</h3>
            <p>귀하에게 적합한 뉴스를 찾을 수 없습니다.</p>
        </div>
    <?php endif; ?>
</div>
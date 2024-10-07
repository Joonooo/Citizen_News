<?php
function highlightKeyword($text, $keyword)
{
	$escapedKeyword = preg_quote($keyword, '/');
	$highlighted = preg_replace('/(' . $escapedKeyword . ')/iu', '<span class="highlight">$1</span>', $text);
	// '|||'를 '<br>'로 변환
	return str_replace('|||', '<br>', $highlighted);
}
?>

<div class="container my-5">
	<!-- 검색 폼 -->
	<form class="d-flex mb-4" method="get" action="/search">
		<input class="form-control me-2" type="search" name="q" placeholder="검색" aria-label="검색"
			value="<?= esc($searchQuery) ?>" required>
		<button class="btn btn-outline-primary" type="submit">검색</button>
	</form>

	<h2 class="mb-4">검색 결과: "<?= esc($searchQuery) ?>"</h2>

	<?php if (!empty($results) && is_array($results)): ?>
		<?php foreach ($results as $news_item): ?>
			<div class="card mb-3 shadow-sm">
				<div class="card-body">
					<h3 class="card-title"><?= highlightKeyword(esc($news_item['title']), $searchQuery) ?></h3>
					<p class="card-text"><?= nl2br(highlightKeyword(esc($news_item['description']), $searchQuery)) ?></p>
					<a href="<?= '/' . $news_item['id'] ?>" class="btn btn-primary"
						aria-label="<?= esc($news_item['title']) ?> 읽기">자세히 보기</a>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="alert alert-warning" role="alert">
			<h3>검색 결과 없음</h3>
			<p>"<?= esc($searchQuery) ?>"에 대한 결과를 찾을 수 없습니다.</p>
		</div>
	<?php endif; ?>

	<!-- 페이지 네비게이션 -->
	<?php if ($totalPages > 1): ?>
		<nav aria-label="Page navigation">
			<ul class="pagination justify-content-center">
				<!-- 이전 페이지 버튼 -->
				<?php if ($currentPage > 1): ?>
					<li class="page-item">
						<a class="page-link" href="?q=<?= urlencode($searchQuery) ?>&page=<?= $currentPage - 1 ?>"
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
						<a class="page-link" href="?q=<?= urlencode($searchQuery) ?>&page=1">1</a>
					</li>
					<?php if ($start > 2): ?>
						<li class="page-item disabled"><span class="page-link">...</span></li>
					<?php endif; ?>
				<?php endif; ?>

				<!-- 중간 페이지 표시 -->
				<?php for ($i = $start; $i <= $end; $i++): ?>
					<li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
						<a class="page-link" href="?q=<?= urlencode($searchQuery) ?>&page=<?= $i ?>"><?= $i ?></a>
					</li>
				<?php endfor; ?>

				<!-- 마지막 페이지 표시 -->
				<?php if ($end < $totalPages): ?>
					<?php if ($end < $totalPages - 1): ?>
						<li class="page-item disabled"><span class="page-link">...</span></li>
					<?php endif; ?>
					<li class="page-item">
						<a class="page-link"
							href="?q=<?= urlencode($searchQuery) ?>&page=<?= $totalPages ?>"><?= $totalPages ?></a>
					</li>
				<?php endif; ?>

				<!-- 다음 페이지 버튼 -->
				<?php if ($currentPage < $totalPages): ?>
					<li class="page-item">
						<a class="page-link" href="?q=<?= urlencode($searchQuery) ?>&page=<?= $currentPage + 1 ?>"
							aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>
	<?php endif; ?>
</div>

<style>
	.highlight {
		background-color: yellow;
	}
</style>
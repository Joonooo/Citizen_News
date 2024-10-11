<?php
function linkify($text)
{
    $urlPattern = '/\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/))/';
    return preg_replace_callback($urlPattern, function ($matches) {
        return '<a href="' . esc($matches[0], 'url') . '" target="_blank">' . esc($matches[0], 'html') . '</a>';
    }, $text);
}
?>

<div class="container py-4">
    <div class="row">
        <!-- 메인 뉴스 콘텐츠 영역 -->
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-4">
                <h2 class="mb-4">
                    <?= esc($news['title'], 'html') ?>
                </h2>
                <p class="text-muted lead">
                    <?= linkify(nl2br(str_replace("|||", "\n", esc($news['description'], 'html')))) ?>
                </p>
            </div>
        </div>

        <!-- 사이드바 영역: 관련 뉴스 -->
        <div class="col-md-4">
            <h4 class="mb-3">관련 뉴스</h4>
            <?php if (!empty($relatedNews)): ?>
                <div class="list-group">
                    <?php foreach ($relatedNews as $item): ?>
                        <a href="/news/<?= esc($item['id'], 'url') ?>" class="list-group-item list-group-item-action">
                            <h6 class="mb-1"><?= esc($item['title'], 'html') ?></h6>
                            <small class="text-muted"><?= date('Y-m-d', strtotime($item['pubDate'])) ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>관련 뉴스가 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

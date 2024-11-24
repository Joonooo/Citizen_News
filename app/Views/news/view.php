<?php
function linkify($text)
{
    return $text;
}

function processLinks($text)
{
    // 패턴 1: (앵커 텍스트)[[LINK:URL]]
    $pattern1 = '/\((.*?)\)\[\[LINK:(.*?)\]\]/';

    // 패턴 2: URL[[LINK:URL]]
    $pattern2 = '/(\bhttps?:\/\/[^\s<>"\'\[\]]+)\[\[LINK:(.*?)\]\]/i';

    // 패턴 1 처리
    $text = preg_replace_callback($pattern1, function ($matches) {
        $anchor = $matches[1];
        $url = htmlspecialchars_decode($matches[2]);

        // 이스케이프 처리
        $safeAnchor = htmlspecialchars($anchor, ENT_QUOTES, 'UTF-8');
        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        return '<a href="' . $safeUrl . '" target="_blank">' . $safeAnchor . '</a>';
    }, $text);

    // 패턴 2 처리
    $text = preg_replace_callback($pattern2, function ($matches) {
        $anchor = $matches[1];
        $url = htmlspecialchars_decode($matches[2]);

        // 이스케이프 처리
        $safeAnchor = htmlspecialchars($anchor, ENT_QUOTES, 'UTF-8');
        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        return '<a href="' . $safeUrl . '" target="_blank">' . $safeAnchor . '</a>';
    }, $text);

    return $text;
}


// 이미지 파일 경로 확인 및 설정
$images = [];
$imageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
$imageDir = '/images/';
$imageFilename = $news['id'];

// 기본 이미지 확인
$imageFound = false;
foreach ($imageExtensions as $ext) {
    $imagePath = $imageDir . $imageFilename . $ext;
    $fullImagePath = FCPATH . ltrim($imagePath, '/');

    if (file_exists($fullImagePath)) {
        $imageFound = true;
        $images[] = base_url($imagePath);
        break;
    }
}

// 기본 이미지가 없을 경우 _1, _2, _3 이미지 검색
if (!$imageFound) {
    $maxImages = 5;
    for ($i = 1; $i <= $maxImages; $i++) {
        foreach ($imageExtensions as $ext) {
            $imagePath = $imageDir . $imageFilename . '_' . $i . $ext;
            $fullImagePath = FCPATH . ltrim($imagePath, '/');

            if (file_exists($fullImagePath)) {
                $images[] = base_url($imagePath);
                break;
            }
        }
    }
}
?>

<div class="container py-4">
    <div class="row">
        <!-- 메인 뉴스 콘텐츠 영역 -->
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-4">
                <h2 class="mb-4">
                    <?= esc($title, 'html') ?>
                </h2>
                <!-- 이미지 표시 -->
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $imageUrl): ?>
                        <div class="mb-4 text-center">
                            <img src="<?= $imageUrl ?>" alt="<?= esc($news['title'], 'attr') ?>" class="img-fluid">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <p class="text-muted lead">
                    <?php
                    $contentToShow = !empty($news['content']) ? $news['content'] : $news['description'];
                    echo nl2br($contentToShow);
                    ?>
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
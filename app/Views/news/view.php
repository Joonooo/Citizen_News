<?php
function linkify($text)
{
    $urlPattern = '/\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/))/';
    return preg_replace_callback($urlPattern, function ($matches) {
        return '<a href="' . esc($matches[0], 'url') . '" target="_blank">' . esc($matches[0], 'html') . '</a>';
    }, $text);
}

// 이미지 파일 경로 확인 및 설정
$images = []; // 찾은 이미지들의 URL을 저장할 배열
$imageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
$imageDir = '/images/'; // 슬래시로 시작하여 절대 경로로 지정
$imageFilename = $news['id']; // 데이터베이스 ID 값

// 기본 이미지 확인
$imageFound = false;
foreach ($imageExtensions as $ext) {
    $imagePath = $imageDir . $imageFilename . $ext;
    $fullImagePath = FCPATH . ltrim($imagePath, '/'); // 서버 파일 시스템 경로

    if (file_exists($fullImagePath)) {
        $imageFound = true;
        $images[] = base_url($imagePath); // 도메인 포함한 절대 경로로 설정
        break;
    }
}

// 기본 이미지가 없을 경우 _1, _2, _3 이미지 검색
if (!$imageFound) {
    $maxImages = 5; // 최대 이미지 수 설정
    for ($i = 1; $i <= $maxImages; $i++) {
        foreach ($imageExtensions as $ext) {
            $imagePath = $imageDir . $imageFilename . '_' . $i . $ext;
            $fullImagePath = FCPATH . ltrim($imagePath, '/'); // 서버 파일 시스템 경로

            if (file_exists($fullImagePath)) {
                $images[] = base_url($imagePath); // 찾은 이미지의 URL 추가
                break; // 해당 확장자에서 이미지를 찾았으므로 다음 번호로 이동
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

                <!-- 이미지 표시 시작 -->
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $imageUrl): ?>
                        <div class="mb-4 text-center">
                            <img src="<?= $imageUrl ?>" alt="<?= esc($news['title'], 'attr') ?>" class="img-fluid">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- 이미지 표시 끝 -->

                <p class="text-muted lead">
                    <?= linkify(nl2br(str_replace("|||", "\n", esc($news['description'] ?? '', 'html')))) ?>
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

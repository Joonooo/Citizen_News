<?php
function linkify($text)
{
    return $text; // 단순화
}

function processLinks($text)
{
    // DOMDocument를 사용하여 HTML 링크 처리
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // HTML 파싱 오류 무시
    $dom->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new DOMXPath($dom);
    $textNodes = $xpath->query('//text()');

    foreach ($textNodes as $node) {
        $parent = $node->parentNode;

        if ($parent && $parent->nodeName === 'a') {
            continue; // 이미 링크인 경우 처리하지 않음
        }

        // URL 패턴 매칭
        $pattern = '/(https?:\/\/[^\s<>"\'\[\]]+)/i';
        $nodeValue = $node->nodeValue;

        if (preg_match($pattern, $nodeValue)) {
            $newValue = preg_replace_callback($pattern, function ($matches) {
                $url = htmlspecialchars($matches[0], ENT_QUOTES, 'UTF-8');
                return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
            }, $nodeValue);

            $fragment = $dom->createDocumentFragment();
            $fragment->appendXML($newValue);
            $parent->replaceChild($fragment, $node);
        }
    }

    // DOM에서 콘텐츠를 반환
    $body = $dom->getElementsByTagName('body')->item(0);
    $innerHTML = '';
    foreach ($body->childNodes as $child) {
        $innerHTML .= $dom->saveHTML($child);
    }

    // 문단 처리 (개행을 <p>로 감싸기)
    $paragraphs = preg_split('/\n+/', trim($innerHTML));
    $formattedContent = '';
    foreach ($paragraphs as $paragraph) {
        $formattedContent .= '<p>' . trim($paragraph) . '</p>';
    }

    return $formattedContent;
}

// 이미지 파일 경로 확인 및 설정 (기존 유지)
$images = [];
$imageExtensions = ['.png', '.jpg', '.jpeg', '.gif'];
$imageDir = '/images/';
$imageFilename = $news['id'];

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

// 뉴스 본문 처리
$contentToShow = !empty($news['content']) ? $news['content'] : $news['description'];
$processedContent = processLinks($contentToShow);
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

                <!-- 뉴스 본문 -->
                <div class="news-content" id="newsContent">
                    <?= $processedContent ?>
                </div>

                <!-- "더 보기" 버튼 -->
                <div class="text-center mt-3">
                    <button id="toggleContent" class="btn btn-primary">더 보기</button>
                </div>
            </div>
        </div>

        <!-- 사이드바: 관련 뉴스 -->
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

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentDiv = document.querySelector('.news-content');
        const toggleButton = document.getElementById('toggleContent');

        const maxHeight = 400; // 본문 초기 높이
        if (contentDiv.scrollHeight > maxHeight) {
            contentDiv.style.height = maxHeight + 'px';
            contentDiv.style.overflow = 'hidden';
            contentDiv.classList.add('content-clipped');
            toggleButton.style.display = 'inline-block';
        } else {
            toggleButton.style.display = 'none';
        }

        toggleButton.addEventListener('click', function () {
            const isExpanded = contentDiv.style.height === maxHeight + 'px';
            contentDiv.style.height = isExpanded ? contentDiv.scrollHeight + 'px' : maxHeight + 'px';
            contentDiv.style.overflow = isExpanded ? 'visible' : 'hidden';
            contentDiv.classList.toggle('content-clipped', !isExpanded);

            toggleButton.textContent = isExpanded ? '간략히' : '더 보기';
        });
    });
</script>

<!-- CSS -->
<style>
    .news-content {
        transition: height 0.5s ease, mask-image 0.5s ease;
        position: relative;
    }

    .news-content.content-clipped {
        mask-image: linear-gradient(to bottom, black 60%, rgba(0, 0, 0, 0.6) 80%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, black 60%, rgba(0, 0, 0, 0.6) 80%, transparent 100%);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    #toggleContent {
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    #toggleContent:hover {
        transform: scale(1.05);
        background-color: #0056b3;
    }
</style>
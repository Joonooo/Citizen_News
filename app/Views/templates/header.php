<!doctype html>
<html lang="ko">

<head>
    <!-- 기본 메타 태그 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="시티즌뉴스는 시민이 만드는 새로운 뉴스 플랫폼입니다.">
    <meta name="keywords" content="시티즌뉴스, 뉴스, 시민 기자, 최신 뉴스">

    <meta name="naver-site-verification" content="9a852d27ae475d0bf4d13cddcb8a8028c4aa557d" />
    <link rel="alternate" type="application/rss+xml" title="시티즌뉴스 RSS 피드" href="<?= site_url('rss') ?>" />

    <title><?= esc($title) ?></title>

    <!-- Bootstrap CSS 및 아이콘 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Noto+Sans+KR:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- 커스텀 CSS -->
    <link rel="stylesheet" href="/css/custom.css">

    <style>
        body {
            font-family: 'Noto Sans KR', 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            /* 가독성을 위한 줄 간격 */
            color: #333;
            /* 기본 텍스트 색상 */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            /* 제목에 굵은 텍스트 적용 */
        }

        p,
        a,
        li {
            font-family: 'Noto Sans KR', 'Roboto', sans-serif;
            font-weight: 400;
        }

        /* 기본 폰트 크기 설정 */
        body {
            font-size: clamp(16px, 1.5vw, 18px);
            /* 최소 16px, 최대 18px 사이에서 조정 */
        }

        h1 {
            font-size: clamp(24px, 4vw, 36px);
            /* 최소 24px, 최대 36px 사이에서 조정 */
        }

        h2 {
            font-size: clamp(20px, 3.5vw, 30px);
            /* 최소 20px, 최대 30px 사이에서 조정 */
        }

        h3 {
            font-size: clamp(18px, 3vw, 24px);
            /* 최소 18px, 최대 24px 사이에서 조정 */
        }

        /* 작은 화면 (모바일) */
        @media (max-width: 768px) {
            body {
                font-size: 14px;
                /* 기본 폰트 크기 축소 */
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 24px;
            }
        }

        /* 큰 화면 (데스크톱) */
        @media (min-width: 1200px) {
            body {
                font-size: 18px;
                /* 기본 폰트 크기 확대 */
            }

            h1 {
                font-size: 40px;
            }
        }
    </style>
</head>

<body>
    <div id="loadingOverlay" role="status" aria-live="polite">
        <div class="loader"></div>
    </div>

    <!-- 네비게이션 바 -->
    <?php $current_uri = uri_string(); ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="주 네비게이션">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/images/logo.png" alt="시티즌뉴스 로고" height="30" class="me-2">
                <div>
                    <span class="fw-bold" style="font-size: 1.25rem;">시티즌뉴스</span><br>
                    <small class="text-muted">시민이 만드는 새로운 뉴스 플랫폼</small>
                </div>
            </a>
            <!-- 토글 버튼 -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="토글 네비게이션">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- 네비게이션 메뉴 -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <!-- 현재 페이지 활성화 표시 -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_uri == '') ? 'active' : '' ?>" href="/">홈</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_uri == 'about') ? 'active' : '' ?>" href="/about">소개</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_uri == 'contact') ? 'active' : '' ?>" href="/contact">연락처</a>
                    </li>

                    <!-- 카테고리 드롭다운 메뉴 -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                카테고리
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php foreach ($categories as $category): ?>
                                    <li>
                                        <a class="dropdown-item"
                                            href="<?= current_url() ?>?category=<?= urlencode($category['category']) ?>">
                                            <?= esc($category['category'], 'html') ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                    <!-- 검색 아이콘 -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- 검색 모달 -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="get" action="/search">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">검색</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="닫기"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control" type="search" name="q" placeholder="검색어를 입력하세요" aria-label="검색">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">검색</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js"
        data-id="joonoo" data-description="Support me on Buy me a coffee!" data-message="커피 한 잔 사주세요"
        data-color="#5F7FFF" data-position="Right" data-x_margin="18" data-y_margin="18"></script>

    <!-- 컨텐츠 시작 -->
    <div class="container mt-4">
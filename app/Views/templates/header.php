<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-..." crossorigin="anonymous">

    <!-- 커스텀 CSS -->
    <link rel="stylesheet" href="/css/custom.css">
</head>

<body>
    <!-- 네비게이션 바 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">시티즌뉴스</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">

                    <!-- 현재 페이지 활성화 표시 -->
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="/">홈</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="/about">소개</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="/contact">연락처</a>
                    </li>

                    <!-- 카테고리 드롭다운 메뉴 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            카테고리
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($categories as $category): ?>
                                <li><a class="dropdown-item"
                                        href="/?category=<?= urlencode($category['category']) ?>"><?= esc($category['category']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <!-- 검색 폼 -->
                    <li class="nav-item">
                        <form class="d-flex" method="get" action="/search">
                            <input class="form-control me-2" type="search" name="q" placeholder="검색" aria-label="검색">
                            <button class="btn btn-outline-light" type="submit">검색</button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- 컨텐츠 시작 -->
    <div class="container mt-4">

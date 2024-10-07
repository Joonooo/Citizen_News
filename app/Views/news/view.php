<?php
function linkify($text)
{
    $urlPattern = '/\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/))/';
    return preg_replace_callback($urlPattern, function ($matches) {
        return '<a href="' . esc($matches[0]) . '" target="_blank">' . esc($matches[0]) . '</a>';
    }, $text);
}
?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg p-4">
                <h2 class="mb-4">
                    <?= esc($news['title']) ?>
                </h2>
                <p class="text-muted lead">
                    <?= linkify(str_replace("|||", "<br>", esc($news['description'], 'raw'))) ?>
                </p>
            </div>
        </div>
    </div>
</div>

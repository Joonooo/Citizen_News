<?php
function linkify($text)
{
    $urlPattern = '/\bhttps?:\/\/[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/))/';
    return preg_replace_callback($urlPattern, function ($matches) {
        return '<a href="' . $matches[0] . '" target="_blank">' . $matches[0] . '</a>';
    }, $text);
}

?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">
                <?= esc($news['title']) ?>
            </h2>
            <p class="text-muted">
                <?= linkify(str_replace("|||", "<br>", esc($news['description']))) ?>
            </p>
        </div>
    </div>
</div>
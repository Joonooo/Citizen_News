<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4"><?= esc($news['title']) ?></h2>
            <p class="text-muted"><?= str_replace("|||", "<br>", esc($news['description'])) ?></p>
        </div>
    </div>
</div>

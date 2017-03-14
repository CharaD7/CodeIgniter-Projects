<div class="news-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tabLast" aria-controls="home" role="tab" data-toggle="tab"><?= $last ?></a></li>
        <li role="presentation"><a href="#mostRead" aria-controls="profile" role="tab" data-toggle="tab"><?= $mostRead ?></a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tabLast">
            <?php
            foreach ($lastArticles as $lastArticle) {
                $image = base_url('attachments/images/' . $lastArticle['image']);
                if ($lastArticle['image'] == null) {
                    $image = $lastArticle['image_link'];
                }
                ?>
                <div class="media">
                    <div class="media-left">
                        <img src="<?= $image ?>" alt="<?= except_letters($lastArticle['title']) ?>" class="media-object">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="<?= base_url($lastArticle['url']) ?>">
                                <?= $lastArticle['title'] ?> <small><i><?= $addedOn . ' ' . date('d.m.Y', $lastArticle['time']) ?></i></small>
                            </a>
                        </h4>
                        <p><?= character_limiter(strip_tags($lastArticle['description']), 50) ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="mostRead">
            <?php
            foreach ($mostReadArticles as $mostReaded) {
                $image = base_url('attachments/images/' . $mostReaded['image']);
                if ($mostReaded['image'] == null) {
                    $image = $mostReaded['image_link'];
                }
                ?>
                <div class="media">
                    <div class="media-left">
                        <img src="<?= $image ?>" alt="<?= except_letters($mostReaded['title']) ?>" class="media-object">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="<?= base_url($mostReaded['url']) ?>">
                                <?= $mostReaded['title'] ?> <small><i><?= $addedOn . ' ' . date('d.m.Y', $mostReaded['time']) ?></i></small>
                            </a>
                        </h4>
                        <p><?= character_limiter(strip_tags($mostReaded['description']), 50) ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
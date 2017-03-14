<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="home-page">
    <div class="row">
        <div class="col-sm-8">
            <div id="carouselHomeArticles" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i <= count($sliderArticles) - 1; $i++) { ?>
                        <li data-target="#carouselHomeArticles" data-slide-to="<?= $i ?>" <?= $i == 0 ? 'class="active"' : '' ?>></li>
                    <?php } ?>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php
                    $i = 0;
                    foreach ($sliderArticles as $sArticle) {
                        $image = base_url('attachments/images/' . $sArticle['image']);
                        if ($sArticle['image'] == null) {
                            $image = $sArticle['image_link'];
                        }
                        ?>
                        <div class="item <?= $i == 0 ? 'active"' : '' ?>">
                            <img src="<?= $image ?>" alt="<?= except_letters($sArticle['title']) ?>">
                            <div class="container-info">
                                <h1><a href="<?= base_url($sArticle['url']) ?>"><?= $sArticle['title'] ?></a></h1>
                                <div class="description"><?= character_limiter($sArticle['description'], 50) ?></div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
                <a class="left carousel-control" href="#carouselHomeArticles" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carouselHomeArticles" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="row">
                <div class="col-sm-6 top-news">
                    <h2><?= $lastGossips ?></h2>
                    <?php
                    foreach ($lastGosspis as $mostReaded) {
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
                    <a href="" class="seemore"><?= $seeMore ?></a>
                </div>
                <div class="col-sm-6 top-news">
                    <h2><?= $highLife ?></h2>
                    <?php
                    foreach ($lastGosspis as $mostReaded) {
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
                    <a href="" class="seemore"><?= $seeMore ?></a>
                </div>
                <div class="col-xs-12">
                    <h2 class="after-top-news"><?= $highLife ?></h2>
                </div>
                <?php
                foreach ($lastGosspis as $mostReaded) {
                    $image = base_url('attachments/images/' . $mostReaded['image']);
                    if ($mostReaded['image'] == null) {
                        $image = $mostReaded['image_link'];
                    }
                    ?>
                    <div class="col-sm-6">
                        <div class="home-big-news">
                            <a href="<?= base_url($mostReaded['url']) ?>">
                                <img src="<?= $image ?>" class="img-responsive" alt="<?= except_letters($mostReaded['title']) ?>">
                                <h3><?= character_limiter($mostReaded['title'], 70) ?></h3>
                                <small><i><?= $addedOn . ' ' . date('d.m.Y', $mostReaded['time']) ?></i></small>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-sm-12 last-element">
                    <a href="" class="seemore"><?= $seeMore ?></a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <?php include 'right_side.php'; ?>
            <h2 class="after-top-news"><?= $mostReadCategories ?></h2>
            <ul class="mostReadCategories">
                <?php foreach ($mostReadCategs as $category) { ?>
                    <li><a href="<?= base_url('категория/' . $category['url']) ?>"><i class="fa fa-caret-right" aria-hidden="true"></i> <?= $category['name'] ?></a></li>
                <?php } ?>
            </ul>
            <h2 class="after-top-news"><?= $userPublics ?></h2>
            <ul class="others">
                <?php foreach ($lastGosspis as $others) { ?>
                    <li><a href="<?= base_url($others['url']) ?>"><?= $others['title'] ?></a></li>
                <?php } ?>
            </ul>
            <a href="" class="seemore"><?= $seeMore ?></a>
        </div>
    </div>
</div>
<div class="home-bottom-text">
    <?= $homeBottomText ?>
</div>
<?php if (isset($_GET['add-news']) && $_GET['add-news'] == 'добави-твоя-новина') { ?>
    <script>
        $(document).ready(function () {
            $('#addArticle').modal('show');
        });
    </script>
<?php } ?>
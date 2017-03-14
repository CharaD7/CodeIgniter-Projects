<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="inner-categories">
    <div class="row">
        <div class="col-xs-12">
            <?php if (!isset($_GET['search'])) { ?>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>"><?= $category ?></a></li>
                    <li class="active"><?= isset($categorieName) ? $categorieName : $_GET['search'] ?></li>
                </ol>
            <?php } else { ?>
                <div class="search-term"><?= $resultsFor . ' <b>' . $_GET['search'] . '</b>' ?></div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 top-pagination-links">
            <?= $links_pagination ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <?php
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    $image = base_url('attachments/images/' . $article['image']);
                    if ($article['image'] == null) {
                        $image = $article['image_link'];
                    }
                    ?>
                    <div class="media media-category">
                        <div class="media-left">
                            <img src="<?= $image ?>" alt="<?= except_letters($article['title']) ?>" class="media-object">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?= base_url($article['url']) ?>">
                                    <?= $article['title'] ?> <small><i><?= $addedOn . ' ' . date('d.m.Y', $article['time']) ?></i></small>
                                </a>
                            </h4>
                            <p><?= character_limiter(strip_tags($article['description']), 50) ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-orange"><?= $noItems ?></div>
            <?php } ?>
        </div>
        <div class="col-sm-4">
            <?php include 'right_side.php' ?>
        </div>
    </div>
    <?= $links_pagination ?>
</div>
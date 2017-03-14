<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="inner-page">
    <div class="row">
        <div class="col-sm-8">
            <h1>
                <?= $article['title'] ?>
            </h1>
            <hr>
            <img src="<?= $image ?>" alt="<?= except_letters($article['title']) ?>" class="img-responsive img-thumbnail img-preview">
            <?php
            if ($article['folder'] != null) {
                $dir = "attachments/images/" . $article['folder'] . '/';
                ?>
                <div class="row">
                    <div class="other-images">
                        <?php
                        if (is_dir($dir)) {
                            if ($dh = opendir($dir)) {
                                $i = 0;
                                while (($file = readdir($dh)) !== false) {
                                    if (is_file($dir . $file)) {
                                        ?>
                                        <div class="col-xs-4 col-sm-6 col-md-4 text-center">
                                            <img src="<?= base_url($dir . $file) ?>" class="img-thumbnail img-responsive img-preview" alt="<?= str_replace('"', "'", $article['title']) ?>">
                                        </div>
                                        <?php
                                    }
                                    $i++;
                                }
                                closedir($dh);
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="views-info">
                <i class="fa fa-clock-o" aria-hidden="true"></i> <?= $addedOn . ' ' . date('d.m.Y', $article['time']) ?>
            </div>
            <div class="views-info">
                <i class="fa fa-eye" aria-hidden="true"></i> <?= $article['views'] . ' ' . $views ?>
            </div>
            <hr>
            <div class="inner-description">
                <?= $article['description'] ?>
            </div>
            <div class="social">
                <a class="fb-share" target="_blank" href="https://www.facebook.com/sharer/sharer.php?sdk=joey&u=<?= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>&display=popup&ref=plugin&src=share_button"></a>
            </div>
            <h2 class="after-top-news"><?= $othersFromThisCategory ?></h2>
            <div class="row row-same-category">
                <?php
                foreach ($sameCategory as $article) {
                    $image = base_url('attachments/images/' . $article['image']);
                    if ($article['image'] == null) {
                        $image = $article['image_link'];
                    }
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="media same-category">
                            <div class="media-left">
                                <div class="img-container">
                                    <img src="<?= $image ?>" alt="<?= except_letters($article['title']) ?>" class="media-object">
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?= base_url($article['url']) ?>">
                                        <?= character_limiter($article['title'], 20) ?> <small><i><?= $addedOn . ' ' . date('d.m.Y', $article['time']) ?></i></small>
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-4">
            <?php include 'right_side.php' ?>
        </div>
    </div>
</div>
<div id="modalImagePreview" class="modal">
    <div class="image-preview-container">
        <div class="modal-content">
            <div class="inner-prev-container">
                <img id="img01" alt="Preview" src="">
                <a href="javascript:void(0);" class="close-previw" onclick="document.getElementById('modalImagePreview').style.display = 'none'">
                    <i class="fa fa-3x fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?php if ($article['ageRestrict'] == true) { ?>
    <div id="modalAgeRestrict" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="text-restricted">
                    <?= $confirmAgeRestrict ?>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yes">
                            <a href="javascript:void(0);" data-dismiss="modal"><?= $yes ?></a>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="no">
                            <a href="<?= base_url() ?>">
                                <?= $no ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#modalAgeRestrict').modal('show');
        });
    </script>
    <style>
        .modal-backdrop.in {opacity: 0.9;}
    </style>
<?php } ?>
<script src="<?= base_url('assets/js/image-preveiw.js') ?>"></script>
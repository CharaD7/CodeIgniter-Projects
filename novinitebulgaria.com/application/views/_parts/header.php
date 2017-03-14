<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <meta property="og:image" content="<?= isset($image) ? $image : base_url('attachments/screenshot.png') ?>" />
        <meta property="og:url" content="<?= urldecode(base_url(uri_string())) ?>" />
        <meta property="og:title" content="<?= $title ?>" />
        <meta property="og:description" content="<?= $description ?>" />
        <meta property="og:type" content="website" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
        <script src="<?= base_url('jsloader/all.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="box-shadow">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-4 logo-container">
                            <a href="<?= base_url() ?>">
                                <img src="<?= base_url('assets/imgs/logo.png') ?>" class="img-responsive" alt="Novinite Bulgaria">
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <div class="header-texts">
                                <h1><?= $headerFirstText ?></h1>
                                <?php
                                if (!empty($topNews)) {
                                    $image = base_url('attachments/images/' . $topNews['image']);
                                    if ($topNews['image'] == null) {
                                        $image = $topNews['image_link'];
                                    }
                                    ?>
                                    <div class="header-one-news">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <img src="<?= $image ?>" alt="<?= except_letters($topNews['title']) ?>">
                                            </div>
                                            <div class="col-xs-9">
                                                <a href="<?= base_url($topNews['url']) ?>">
                                                    <h2>
                                                        <?= character_limiter($topNews['title'], 50) ?>
                                                    </h2>
                                                    <p>
                                                        <?= character_limiter(strip_tags($topNews['description']), 50) ?>
                                                    </p>
                                                </a>
                                                <span class="blink"><?= $headerTextTop ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <a href="#" class="no-top-news">
                                        <img src="<?= base_url('assets/imgs/top-words.png') ?>" alt="<?= $headerSecondText ?>">
                                    </a>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#addArticle" class="add-article-btn">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= $addArticle ?>
                                <span class="free"><?= $free ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-orange">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                        <a class="navbar-brand visible-xs" href="#"><?= lang('menu_xs') ?></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="<?= base_url() ?>"><span class="glyphicon glyphicon-home"></span></a></li>
                            <?php

                            function loop_tree($categories, $is_recursion = false)
                            {
                                foreach ($categories as $category) {
                                    $children = false;
                                    if (isset($category['children']) && !empty($category['children']) && $category['master'] == 1) {
                                        $children = true;
                                    }
                                    if ($children == false) {
                                        ?>
                                        <li><a href="<?= base_url('категория/' . $category['url']) ?>"><?= $category['name'] ?></a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li class="dropdown">
                                            <a href="<?= base_url('категория/' . $category['url']) ?>"><?= $category['name'] ?><span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <?php
                                            }
                                            if ($children == true) {
                                                loop_tree($category['children'], $children);
                                            }
                                        }
                                        if ($is_recursion == true) {
                                            ?>
                                        </ul>
                                        <?php
                                    }
                                }

                                loop_tree($all_categories);
                                ?>
                            <li><a href="<?= base_url('за-нас') ?>"><?= lang('about_us') ?></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right hidden-xs">
                            <li>
                                <form action="<?= base_url('резултати/търсене') ?>" class="nav-search" method="GET" id="navSearch">
                                    <div class="search-container">
                                        <input class="form-control" type="text" placeholder="<?= lang('find_article') ?>" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" name="search">
                                        <a href="javascript:void(0);" class="search-button">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="noNavCategories">
                    <ul>
                        <?php
                        loop_tree($allNoNavCategories);
                        ?>
                    </ul>
                </div>
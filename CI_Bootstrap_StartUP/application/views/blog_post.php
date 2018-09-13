<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div id="blog-preview">
    <div class="blog-top header-inner-page">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?= LANG_URL ?>"><?= lang('home') ?></a></li>
                <li><a href="<?= LANG_URL . '/блог' ?>"><?= lang('blog') ?></a></li>
                <li class="active"><?= $blog['title'] ?></li>
            </ol>
            <h2><?= lang('blog') ?></h2>
        </div>
    </div>
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-md-8">
                    <h1><?= $blog['title'] ?></h1>
                    <div class="gadgets"> 
 
                    </div>
                    <div class="body-bg">
                        <img class="img-responsive" src="<?= base_url(BLOG_IMAGE . $blog['image']) ?>" alt="<?= $blog['title'] ?>">
                        <div class="description">
                            <?= $blog['description'] ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-4 same-posts">
                    <div class="row blog">
                        <?php foreach ($lastFromCategory as $post) { ?>
                            <div class="col-xs-12">
                                <div class="post">
                                    <a href="<?= LANG_URL . '/блог/' . $post['url'] ?>">
                                        <img src="<?= base_url(BLOG_IMAGE . $post['image']) ?>" alt="<?= $post['title'] ?>">
                                    </a>
                                    <div class="body">
                                        <a href="<?= LANG_URL . '/блог/' . $post['url'] ?>">
                                            <h3><?= $post['title'] ?></h3>
                                        </a>
                                        <p><?= word_limiter($post['description'], 20) ?></p>
                                    </div>
                                    <div class="footer">
                                        <a href=""><?= $post['blog_category'] ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
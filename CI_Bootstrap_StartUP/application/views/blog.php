<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div id="blog-preview">
    <div class="blog-top header-inner-page">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?= LANG_URL ?>"><?= lang('home') ?></a></li>
                <li class="active"><?= lang('blog') ?></li>
            </ol>
            <h2><?= lang('blog') ?></h2>
        </div>
    </div>
    <div class="body-content">
        <div class="container blog">
            <ul class="blog-categories">
                <li><a href="<?= LANG_URL . '/блог' ?>"><?= lang('latest') ?></a><?= $category == null ? '<span class="arrow"></span>' : '' ?></li>
                <?php foreach ($blog_categories as $blogc) { ?>
                    <li><a href="<?= LANG_URL . '/блог/категория/' . $blogc['url'] ?>"><?= $blogc['title'] ?></a><?= urldecode(trim($category)) == $blogc['url'] ? '<span class="arrow"></span>' : '' ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="container posts blog">
            <?php if (!empty($blog_posts)) { ?>
                <div class="row grid"> 
                    <?php foreach ($blog_posts as $post) { ?>
                        <div class="col-sm-4 grid-item">
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
                                    <a href="<?= LANG_URL . '/блог/категория/' . $post['category_url'] ?>"><?= $post['blog_category'] ?></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                </div>
            <?php } else { ?> 
                <div class="alert alert-danger"><?= lang('no_posts') ?></div>
            <?php } ?> 
        </div> 
        <?php if ($pagination == true) { ?>
            <div class="container">
                <a href="javascript:void(0);" class="load-more-btn" onclick="loadMoreBlog()"><?= lang('load_more_blog') ?> <span class="glyphicon glyphicon-chevron-down"></span></a>
            </div>
        <?php } ?>
    </div>
</div>
<script>var pagination = {show_to: <?= $pagin_results ?>,  url: '<?= base_url('blogpaging') ?>', category: "<?= $category == null ? 'false' : $category ?>"};</script>
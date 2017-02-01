<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <h1><?= lang('home') ?></h1>

    <?php
    foreach ($articles as $article) {
        ?>
        <div><a href="<?= $article['url'] ?>"><?= $article['title'] ?></a></div>
    <?php } ?>
</div>

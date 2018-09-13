<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?= $title ?>">
        <meta property="og:description" content="<?= $description ?>">
        <meta property="og:image" content="<?= base_url('assets/imgs/site-overview.png') ?>">
        <title><?= $title ?></title>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <link href="<?= base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>"> 
        <!--[if lt IE 9]>
          <script src="<?= base_url('assets/js/html5shiv.min.js') ?>"></script>
          <script src="<?= base_url('assets/js/respond.min.js') ?>"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <a href="<?= LANG_URL.'/reservations' ?>">Резервации</a>
                <br>
                <a href="<?= LANG_URL.'/блог' ?>">Блог</a>

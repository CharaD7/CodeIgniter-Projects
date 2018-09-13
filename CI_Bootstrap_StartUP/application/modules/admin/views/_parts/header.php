<!DOCTYPE html>
<html lang="bg">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body> 
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_in')) { ?> 
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side">
                                <div class="menu-logo">
                                    <a href="<?= base_url('admin/home') ?>">
                                        Ти
                                    </a> 
                                </div> 
                                <ul class="nav">
                                    <li>
                                        <a href="<?= base_url('admin/home') ?>" class="btn">
                                            <i class="material-icons">dashboard</i>
                                            <p><?= lang('home') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/publish') ?>" class="btn">
                                            <i class="material-icons">add_circle_outline</i>
                                            <p><?= lang('add') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/articles') ?>" class="btn">
                                            <i class="material-icons">view_list</i>
                                            <p><?= lang('uploaded') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/categories') ?>" class="btn">
                                            <i class="material-icons">view_agenda</i>
                                            <p><?= lang('categories') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/texts') ?>" class="btn">
                                            <i class="material-icons">record_voice_over</i>
                                            <p><?= lang('texts') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/reservations') ?>" class="btn">
                                            <i class="material-icons">vpn_key</i>
                                            <p><?= lang('reservations') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/callendar') ?>" class="btn">
                                            <i class="material-icons">vpn_key</i>
                                            <p><?= lang('reserved_dates') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/blog') ?>" class="btn">
                                            <i class="material-icons">record_voice_over</i>
                                            <p><?= lang('blog') ?></p>
                                        </a> 
                                    </li>
                                    <li><hr></li>
                                    <li>
                                        <a href="<?= base_url('admin/languages') ?>" class="btn">
                                            <i class="material-icons">language</i>
                                            <p><?= lang('languages') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/history') ?>" class="btn">
                                            <i class="material-icons">history</i>
                                            <p><?= lang('history_actions') ?></p>
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/filemanager') ?>" class="btn">
                                            <i class="material-icons">folder</i>
                                            <p><?= lang('files') ?></p>
                                        </a> 
                                    </li> 
                                    <li>
                                        <a href="<?= base_url('admin/adminusers') ?>" class="btn">
                                            <i class="material-icons">people</i>
                                            <p><?= lang('admins') ?></p>
                                        </a> 
                                    </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2 right-side">
                            <nav class="navbar">
                                <div class="navbar-header">
                                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                                    </button>
                                    <a class="navbar-brand" href="#"></a>
                                </div>
                                <div id="navbar" class="collapse navbar-collapse"> 
                                    <ul class="nav navbar-nav navbar-right">
                                        <li>
                                            <a href="<?= base_url('admin/logout') ?>"> 
                                                <?= lang('logout') ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <form class="navbar-form navbar-right nav-bar-search" action="<?= base_url('admin/articles') ?>" role="search">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" name="search" type="text">
                                            <span class="material-input"></span>
                                            <span class="material-input"></span>
                                        </div>
                                        <button class="btn btn-white btn-round" type="submit">
                                            <i class="material-icons">search</i> 
                                        </button>
                                    </form>
                                </div> 
                            </nav> 
                            <button type="button" class="btn purple-gradient btn-sm menu-btn-xs"><?= lang('show_header_menu') ?></button>
                            <div class="right-side-wrapper">
                                <?php
                            } else {
                                ?>
                                <div>
                                <?php } ?>


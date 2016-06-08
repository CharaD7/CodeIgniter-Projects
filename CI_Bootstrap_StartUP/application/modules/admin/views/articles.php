<div id="articles">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_publish')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
        <hr>
        <?php
    }
    $langs = $languages->result();
    ?>
    <h1>Articles</h1>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <form method="GET" action="">
                <h4 class="">Search</h4>
                <div class="input-group find">
                    <input class="form-control" placeholder="Search" value="<?= @$_GET['search'] ?>" name="search" id="srch-term" type="text">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-default btn-sm btn-block hidden-lg hidden-md" data-toggle="collapse" data-target="#demo">Refine your search <span class="caret"></span>
            </button>
            <div id="demo" class="collapse in">
                <hr>
                <div class="list-group list-group">
                    <h4 class="">Language</h4>
                    <a href="<?= base_url('admin/articles?language=0') ?>" class="list-group-item <?= $articles_lang == null ? 'active' : '' ?>"><span class="label label-warning">Show all</span></a>
                    <?php
                    if ($langs) {
                        foreach ($langs as $language) {
                            ?>
                            <a href="<?= base_url('admin/articles?language=' . $language->abbr) ?>" class="list-group-item <?= $articles_lang == $language->abbr ? 'active' : '' ?>"><i class="fa fa-globe" aria-hidden="true"></i> <?= $language->name ?></a>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-info">No languages!</div>
                    <?php } ?>
                </div> 
                <div class
                     <div class="list-group list-group">
                        <h4 class="">Category</h4>
                        <?php
                        if ($categoiries->result()) {
                            foreach ($categoiries->result() as $categorie) {
                                ?>
                                <a href="<?= base_url('admin/articles?category=' . $categorie->name) ?>" class="list-group-item"><span class="badge"><?= $categorie->num ?></span> <?= $categorie->name ?></a>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-info">No categories!</div>
                        <?php } ?>
                    </div> 
                </div>
            </div>
            <div class="col-md-9">
                <div class="well hidden-xs"> 
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control selectpicker change-order">
                                <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'desc' ? 'selected=""' : '' ?> value="desc">Newest</option>
                                <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'asc' ? 'selected=""' : '' ?> value="asc">Latest</option>
                            </select>
                        </div>
                        <div class="col-xs-8">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-th"></span></button>
                                <button type="button" class="btn btn-default active"><span class="glyphicon glyphicon-th-list"></span></button>
                                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <?php
                if ($articles->result()) {
                    foreach ($articles->result() as $row) {
                        ?>
                        <div class="row article <?= $row->visibility == 1 ? '' : 'invisible-status' ?>" data-article-id="<?= $row->id ?>">
                            <div class="col-sm-4"><a href="#" class="article-image"><img src="<?= $row->thumb != null && file_exists('attachments/thumbs/' . $row->thumb) ? base_url('attachments/thumbs/' . $row->thumb) : base_url('attachments/no-image.png') ?>" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-8">
                                <input type="hidden" value="<?= $row->visibility == 1 ? 0 : 1 ?>" id="to-status">
                                <h3 class="title"><?= $row->title ?></h3>
                                <div class="text-muted">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="status-is-icon"><?= $row->visibility == 1 ? '<i class="fa fa-unlock"></i>' : '<i class="fa fa-lock"></i>' ?></span><span class="caret"></span></span>
                                        <span class="staus-is"><?= $row->visibility == 1 ? 'Visible' : 'Invisible' ?></span>
                                        <ul class="dropdown-menu">
                                            <li><a href="javascript:void(0);" onclick="changeStatus(<?= $row->id ?>)"><?= $row->visibility == 1 ? 'Make Invisible' : 'Make Visible' ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="description-article"><?= word_limiter(strip_tags($row->description), 70) ?></div>
                                <div class="url"><i class="fa fa-link"></i> <a href="<?= base_url($row->url) ?>"><?= base_url($row->url) ?></a></div>
                                <div class="translate-to"><b>Translate to:</b> 
                                    <?php
                                    foreach ($langs as $lang) {
                                        ?>
                                        <a href="<?= base_url('admin/publish/' . $row->id . '?to_lang=' . $lang->abbr) ?>"><?= $lang->abbr ?></a>
                                    <?php } ?>
                                </div>
                                <div class = "pull-right">
                                    <a href="<?= base_url('admin/publish/' . $row->id) ?>" class="btn btn-info">Edit</a>
                                    <a href="<?= base_url('admin/articles?delete=' . $row->id) ?>" onclick="return confirm('Are you sure continue deleting?')" class = "btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php
                    }
                    echo $links_pagination;
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No articles found!</div>
        <?php } ?>
    </div>
    <script>
        $(".change-order").change(function () {
            location.href = '<?= base_url('admin/articles?orderby=') ?>' + $(this).val();
        });
        function changeStatus(id) {
            var to_status = $("#to-status").val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/articleStatusChange') ?>",
                data: {id: id, to_status: to_status}
            }).done(function (data) {
                if (data == '1') {
                    if (to_status == 1) {
                        $('[data-article-id="' + id + '"] .staus-is').text('Visible');
                        $('[data-article-id="' + id + '"] .status-is-icon').html('<i class="fa fa-unlock"></i>');
                        $('[data-article-id="' + id + '"]').removeClass('invisible-status');
                        $("#to-status").val(0);
                    } else {
                        $('[data-article-id="' + id + '"] .staus-is').text('Invisible');
                        $('[data-article-id="' + id + '"]').addClass('invisible-status');
                        $('[data-article-id="' + id + '"] .status-is-icon').html('<i class="fa fa-lock"></i>');
                        $("#to-status").val(1)
                    }
                } else {
                    alert('Error change status!');
                }
            });
        }
    </script>
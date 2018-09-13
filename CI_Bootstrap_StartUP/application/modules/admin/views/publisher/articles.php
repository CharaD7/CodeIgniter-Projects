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
$langs = $languages;
?>
<h1><?= lang('published') ?></h1>
<hr>
<div class="row">
    <div class="col-xs-12">
        <div class="well hidden-xs"> 
            <div class="row">
                <div class="col-xs-4">
                    <select class="form-control selectpicker change-order">
                        <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'desc' ? 'selected=""' : '' ?> value="desc"><?= lang('newest') ?></option>
                        <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'asc' ? 'selected=""' : '' ?> value="asc"><?= lang('latest') ?></option>
                    </select>
                </div>
                <div class="col-xs-8">
                </div>
            </div>
        </div>
        <hr>
        <?php
        if ($articles->result()) {
            foreach ($articles->result() as $row) {
                $u_path = 'attachments/images/';
                if ($row->image != null && file_exists($u_path . $row->image)) {
                    $image = base_url($u_path . $row->image);
                } else {
                    $image = base_url('attachments/no-image.png');
                }
                ?>
                <div class="row article <?= $row->visibility == 1 ? '' : 'invisible-status' ?>" data-article-id="<?= $row->id ?>">
                    <div class="col-sm-4">
                        <a href="#" class="article-image" style="position:relative;">
                            <img src="<?= $image ?>" class="img-responsive">
                        </a>
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
                        <div class="pull-right">
                            <a href="<?= base_url('admin/publish/' . $row->id) ?>" class="btn btn-info"><?= lang('edit') ?></a>
                            <a href="<?= base_url('admin/articles?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete"><?= lang('delete') ?></a>
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
<script>
    $(".change-order").change(function () {
        location.href = '<?= base_url('admin/articles?orderby=') ?>' + $(this).val();
    });
    function changeStatus(id) {
        var to_status = $("#to-status").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/articlestatusChange') ?>",
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
<h1><?= lang('texts') ?></h1>
<hr>
<?php
if ($this->session->flashdata('result')) {
    ?>
    <div class="alert alert-info">
        <?= $this->session->flashdata('result') ?>
    </div>
    <?php
}
?>
<a href="javascript:void(0);" data-toggle="modal" data-target="#addValueStore" class="btn btn-default pull-right" style="margin-bottom:10px;">
    <?= lang('add_text') ?>
</a>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th><?= lang('variable') ?></th>
                <th><?= lang('value') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($valueStores)) {
                foreach ($valueStores as $store) {
                    ?>
                    <tr>
                        <td>$<?= $store['my_key'] ?></td>
                        <td><?= $store['value'] ?></td>
                        <td class="text-right">
                            <div>
                                <a href="?edit=<?= $store['id'] ?>"><?= lang('edit') ?></a>
                            </div>
                            <div>
                                <a class="confirm-delete" href="?delete=<?= $store['id'] ?>"><?= lang('delete') ?></a>
                            </div>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="3"><?= lang('no_texts') ?>!</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?= $links_pagination ?>

<div class="modal fade" id="addValueStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= lang('add_edit_text') ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '0' ?>">
                    <div class="form-group">
                        <label for="my_key"><?= lang('the_key') ?></label>
                        <input type="text" value="<?= isset($my_key) ? $my_key : '' ?>" name="my_key" class="form-control" id="my_key">
                    </div>
                    <div class="form-group">
                        <label for="value"><?= lang('the_value') ?></label>
                        <textarea name="value" class="form-control" id="value"><?= isset($value) ? $value : '' ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary"><?= lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_GET['edit'])) { ?>
    <script>
        $(document).ready(function () {
            $('#addValueStore').modal('show');
            $('.cancel').click(function () {
                window.location.href = "<?= base_url('admin/texts') ?>";
            });
        });
    </script>
<?php } ?>
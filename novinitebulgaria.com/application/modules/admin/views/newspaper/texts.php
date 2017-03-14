<h1>Value Store</h1>
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
    Add ValueStore
</a>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th>Varialbe</th>
                <th>Value</th>
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
                                <a href="?edit=<?= $store['id'] ?>">Edit</a>
                            </div>
                            <div>
                                <a class="confirm-delete" href="?delete=<?= $store['id'] ?>">Remove</a>
                            </div>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="3">No value stores found!</td></tr>
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
                    <h4 class="modal-title" id="myModalLabel">Add/Edit ValueStore</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '0' ?>">
                    <div class="form-group">
                        <label for="my_key">The Key</label>
                        <input type="text" value="<?= isset($my_key) ? $my_key : '' ?>" name="my_key" class="form-control" id="my_key">
                    </div>
                    <div class="form-group">
                        <label for="value">The Value</label>
                        <textarea name="value" class="form-control" id="value"><?= isset($value) ? $value : '' ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_GET['edit'])) { ?>
    <script>
        $(document).ready(function () {
            $('#addValueStore').modal('show');
            $('.cancel').click(function(){
                window.location.href = "<?= base_url('admin/texts') ?>";
            });
        });
    </script>
<?php } ?>
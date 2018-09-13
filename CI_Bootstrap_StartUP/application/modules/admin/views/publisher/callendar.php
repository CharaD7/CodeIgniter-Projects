<link href="<?= base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet">
<h1><?= lang('reserved_dates') ?></h1>
<hr>
<a href="javascript:void(0);" data-toggle="modal" data-target="#addValueStore" class="btn btn-default pull-right" style="margin-bottom:10px;">
    <?= lang('add_reserved_date') ?>
</a>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th><?= lang('date') ?></th> 
                <th></th> 
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($dates)) {
                foreach ($dates as $date) {
                    ?>
                    <tr>
                        <td><?= date('d.m.Y', $date['date']) ?></td> 
                        <td class="text-right"><a href="?delete=<?= $date['id'] ?>" class="btn btn-danger">изтрий</a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="3">Няма добавени резервирани дати</td></tr>
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
                    <h4 class="modal-title" id="myModalLabel"><?= lang('add_reserved_date') ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= lang('date') ?></label>
                        <input type="text" name="date" class="form-control datepicker" value="">
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
<script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        $(".datepicker").datepicker({dateFormat: 'dd.mm.yy'});
    });
</script>
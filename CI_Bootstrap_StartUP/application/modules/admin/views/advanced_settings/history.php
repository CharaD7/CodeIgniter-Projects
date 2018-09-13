<h1><img src="<?= base_url('assets/imgs/timer.png') ?>" class="header-img" style="margin-top:-3px;"> History</h1>
<hr>
<?php if ($history === false) { ?>
    <div class="alert alert-danger"><?= lang('history_stop') ?></div>
<?php } ?>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th><?= lang('user') ?></th>
                <th><?= lang('action') ?></th>
                <th><?= lang('time') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($actions->result()) {
                foreach ($actions->result() as $action) {
                    ?>
                    <tr>
                        <td><?= $action->username ?></td>
                        <td><?= $action->activity ?></td>
                        <td><?= date('Y.m.d / H.m.s', $action->time) ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="3"><?= lang('no_history') ?></td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?= $links_pagination ?>
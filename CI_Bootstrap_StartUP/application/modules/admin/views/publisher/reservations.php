<h1><?= lang('reservations') ?></h1>
<hr>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th><?= lang('names') ?></th>  
                <th><?= lang('count_peoples') ?></th> 
                <th><?= lang('check_in_date') ?></th> 
                <th><?= lang('check_out_date') ?></th> 
                <th><?= lang('email') ?></th> 
                <th><?= lang('phone') ?></th> 
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($dates)) {
                foreach ($dates as $res) {
                    ?>
                    <tr>
                        <td><?= $res['names'] ?></td>  
                        <td><?= $res['peoples'] ?></td> 
                        <td><?= date('d.m.Y', $res['date_check_in']) ?></td> 
                        <td><?= date('d.m.Y', $res['date_check_out']) ?></td> 
                        <td><?= $res['email'] ?></td> 
                        <td><?= $res['phone'] ?></td>
                        <td class="text-right"><a href="<?= base_url('admin/delete/reservation/'.$res['id']) ?>" class="btn btn-danger" onclick="return confirm('<?= lang('are_u_sure_want_to_del') ?>')"><?= lang('delete') ?></a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="7s"><?= lang('no_reservations') ?></td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?= $links_pagination ?>

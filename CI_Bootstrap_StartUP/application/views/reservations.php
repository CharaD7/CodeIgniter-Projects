<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>  
<div class="container reserve-page" id="show-page-content">
    <?php if ($this->session->flashdata('yesReserved')) { ?>
        <div class="alert alert-success" style="margin-top: 30px;"><?= $this->session->flashdata('yesReserved') ?></div>
    <?php } ?> 
    <form method="POST" action="">
        <div class="row"> 
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="names" placeholder="<?= lang('res_names') ?>" value="">
                </div> 
                <div class="form-group"> 
                    <input type="text" class="form-control datepicker" name="date_check_in" placeholder="<?= lang('res_check_in') ?>" value="">
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="peoples" placeholder="<?= lang('res_num_peop') ?>" value="">
                </div>
                <div class="form-group"> 
                    <input type="text" class="form-control datepicker1" name="date_check_out" placeholder="<?= lang('res_check_out') ?>" value="">
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="<?= lang('res_email') ?>" value="">
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="<?= lang('res_phone') ?>" value="">
                </div>
                <div class="form-group">
                    <button type="submit" name="" value="" class="btn btn-reserve btn-default"><?= lang('reserve_now') ?></button>
                </div>
            </div>
        </div>
    </form> 
</div> 
<script>var array_of_recerved_dates = ["<?= $reservedDates ?>"];</script>
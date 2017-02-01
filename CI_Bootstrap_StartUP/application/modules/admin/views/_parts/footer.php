</div>
</div>
</div>
</div>
<?php if ($this->session->userdata('logged_in')) { ?>
    <footer>Powered by <a href="http://eccfze.ae">ECCFZE</a></footer>
<?php } ?>
</div>
<script>
    var urls = {
        changePass: '<?= base_url('admin/changePass') ?>',
        editCategorie: '<?= base_url('admin/editcategorie') ?>',
        changeNavVisibility: '<?= base_url('admin/changeNavVisibility') ?>'
    };
</script>
<script src="<?= base_url('assets/bootstrap-select-1.9.4/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootbox.min.js') ?>"></script>
<script src="<?= base_url('assets/js/zxcvbn.js') ?>"></script>
<script src="<?= base_url('assets/js/zxcvbn_bootstrap3.js') ?>"></script>
<script src="<?= base_url('assets/js/pGenerator.jquery.js') ?>"></script>
<script src="<?= base_url('assets/js/mine.admin.js') ?>"></script>
</body>
</html>
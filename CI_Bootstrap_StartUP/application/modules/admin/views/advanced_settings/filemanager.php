<link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/jquery-ui.css'); ?>">
<script src="<?= base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/elFinder-2.1.9/css/elfinder.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/elFinder-2.1.9/css/theme.css'); ?>">
<script src="<?= base_url('assets/elFinder-2.1.9/js/elfinder.min.js') ?>"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#elfinder').elfinder({
            url: '<?= base_url('assets/elFinder-2.1.9/php/connector.minimal.php'); ?>'
        });
    });
</script>
<h1><?= lang('files') ?></h1> 
<div id="elfinder"></div>
<footer>
    <div class="pull-left">
        <a class="mine-link" href="http://novinitebulgaria.com">NoviniteBulgaria.com</a>
    </div>
    <div class="pull-right">
        <a href="mailto:info@novinitebulgaria.com">info@novinitebulgaria.com</a>
    </div>
	<div class="clearfix"></div>
</footer>
</div>
</div>
<div class="modal fade" id="addArticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $addYourArticle ?></h4>
            </div>
            <div class="modal-body">
                <div class="public-publish-info">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> <?= $publicPublishInfo ?>
                </div>
                <form action="<?= base_url() ?>" enctype="multipart/form-data" method="POST" id="formPublicAdd">
                    <input type="hidden" name="setPublicArticle" value="">
                    <div class="form-group">
                        <label><?= $thetitle ?></label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?= $thedescription ?></label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <script>
                        CKEDITOR.replace('description');
                    </script>
                    <div class="form-group">
                        <label><?= $coverImage ?></label>
                        <input type="file" name="userfile">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $close ?></button>
                <button type="button" class="btn btn-orange" onclick="document.getElementById('formPublicAdd').submit();"><?= $addTheArticle ?></button>
            </div>
        </div>
    </div>
</div>
<?php if ($this->session->flashdata('publicPublishOk')) { ?>
<div class="alert-published">
    <div class="relative">
        <a href="javascript:void(0);" class="closePopPublish">
            <i class="fa fa-2x fa-times" aria-hidden="true"></i>
        </a>
        <?= $this->session->flashdata('publicPublishOk') ?>
    </div>
</div>
<script>
    $('.closePopPublish').click(function () {
        $('.alert-published').hide();
    });
</script>
<?php } ?>
<a href="<?= base_url('?add-news=добави-твоя-новина') ?>"></a>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/placeholders.min.js') ?>"></script>
<script src="<?= base_url('assets/js/mine.js') ?>"></script>
</body>
</html>

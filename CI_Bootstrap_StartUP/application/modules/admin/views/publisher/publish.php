<script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
<h1><?= lang('publish') ?></h1>
<hr>
<?php
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
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
?>
<form role="form" method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : time() ?>" name="folder">
    <div class="form-group available-translations">
        <b><?= lang('language') ?></b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <?= $language->abbr ?>
            </button>
        <?php } ?>
    </div>
    <?php
    $i = 0;
    foreach ($languages as $language) {
        ?>
        <div class="<?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'mine-lang' : 'not-mine-lang' ?> locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
            <div class="form-group"> 
                <label><?= lang('title') ?> (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
            </div>
            <div>
                <?= lang('select_gallery_dir') ?>
                <?php foreach ($gdirs as $dir) { echo '<b>['.$dir.']</b>,'; } ?>
            </div>
            <div class="form-group">
                <label for="description<?= $i ?>"><?= lang('description') ?> (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('description<?= $i ?>');
                </script>
            </div> 
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="form-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $u_path = 'attachments/images/';
            ?>
            <p><?= lang('current_image') ?>:</p>
            <img src="<?= base_url($u_path . $_POST['image']) ?>" class="img-responsive" style="max-width:300px;">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile"><?= lang('head_image') ?></label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group">
        <?php
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            ?>
            <div>       
                <?php
                $dir = "attachments/images/" . $_POST['folder'] . '/';
                if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                        $i = 0;
                        while (($file = readdir($dh)) !== false) {
                            if (is_file($dir . $file)) {
                                ?>
                                <div class="other-img" id="image-container-<?= $i ?>">
                                    <img src="<?= base_url($dir . $file) ?>" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeImage('<?= $file ?>', '<?= $_POST['folder'] ?>', <?= $i ?>)"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                                <?php
                            }
                            $i++;
                        }
                        closedir($dh);
                    }
                }
                ?>
            </div>
        <?php } ?>
        <label for="others"><?= lang('other_images') ?></label>
        <input type="file" name="others[]" id="others" multiple />
    </div>
    <div class="form-group for-shop">
        <label><?= lang('categories') ?></label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="category">
            <?php foreach ($categories as $categorie) { ?>
                <option <?= isset($_POST['category']) && $_POST['category'] == $categorie['id'] ? 'selected=""' : '' ?> value="<?= $categorie['id'] ?>">
                    <?= $categorie['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group for-shop">
        <label><?= lang('in_slider') ?></label>
        <select class="selectpicker" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>><?= lang('yes') ?></option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>><?= lang('no') ?></option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default"><?= lang('publish') ?></button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/articles') ?>" class="btn btn-lg btn-default"><?= lang('cancel') ?></a>
    <?php } ?>
</form>
<script>
    $(document).ready(function () {
        $("#showSliderDescrption").click(function () {
            $("#theSliderDescrption").slideToggle("slow", function () {

            });
        });
    });
    function removeImage(image, folder, container) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('removeImage') ?>",
            data: {image: image, folder: folder}
        }).done(function (data) {
            $('#image-container-' + container).remove();
        });
    }
</script>

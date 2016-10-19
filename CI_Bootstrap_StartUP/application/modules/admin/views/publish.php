<script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
<h1>Publish product</h1>
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
    <?php foreach ($languages->result() as $language) { ?>
        <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
    <?php } foreach ($languages->result() as $language) { ?>
        <div class="form-group"> 
            <label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
        </div>
        <?php
    } $i = 0;
    ?>
    <div class="form-group">
        <a href="javascript:void(0);" class="btn btn-default" id="showSliderDescrption">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
    </div>
    <div id="theSliderDescrption" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
        <?php
        foreach ($languages->result() as $language) {
            ?>
            <div class="form-group">
                <label for="basic_description<?= $i ?>">Slider Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="basic_description[]" id="basic_description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['basic_description']) ? $trans_load[$language->abbr]['basic_description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('basic_description<?= $i ?>');
                </script>
            </div>
            <?php
            $i++;
        }
        ?> 
    </div>
    <?php
    $i = 0;
    foreach ($languages->result() as $language) {
        ?>
        <div class="form-group">
            <label for="description<?= $i ?>">Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
            <script>
                CKEDITOR.replace('description<?= $i ?>');
            </script>
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
            <p>Current image:</p>
            <img src="<?= base_url($u_path . $_POST['image']) ?>" class="img-responsive" style="max-width:300px;">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Cover Image</label>
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
        <label for="others">Other Images</label>
        <input type="file" name="others[]" id="others" multiple />
    </div>
    <div class="form-group for-shop">
        <label>Categories</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="category">
            <?php foreach ($categories->result() as $categorie) { ?>
                <option <?= isset($_POST['categorie']) && $_POST['categorie'] == $categorie->name ? 'selected=""' : '' ?> value="<?= $categorie->name ?>"><?= $categorie->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>In Slider</label>
        <select class="selectpicker" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>>No</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/articles') ?>" class="btn btn-lg btn-default">Cancel</a>
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
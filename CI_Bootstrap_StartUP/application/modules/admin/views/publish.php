<script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
<h1>Publish article</h1>
<hr>
<?php
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
?>
<form role="form" method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?= @$_POST['title'] ?>" class="form-control" id="title">
    </div>
    <!--
    <div class = "form-group">
    <label for = "basic_description">Basic Description:</label>
    <textarea name="basic_description" id="basic_description" rows="50" class="form-control">$_POST['basic_description']</textarea>
    <script>
    CKEDITOR.replace('basic_description');
    </script>
</div>
    -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="50" class="form-control"><?= @$_POST['description'] ?></textarea>
        <script>
            CKEDITOR.replace('description');
        </script>
    </div>
    <div class="form-group">
        <?php if (isset($_POST['image']) && $_POST['image'] != null) { ?>
            <p>Current image:</p>
            <img src="<?= base_url('attachments/images/' . $_POST['image']) ?>" class="img-responsive">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Picture</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group">
        <label for="userfile">Category</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="category">
            <?php foreach ($categoiries->result() as $categorie) { ?>
                <option <?= isset($_POST['category']) && $_POST['category'] == $categorie->name ? 'selected=""' : '' ?> value="<?= $categorie->name ?>"><?= $categorie->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="userfile">Language</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="language">
            <?php foreach ($languages->result() as $language) { ?>
                <option <?= isset($_POST['language']) && !isset($_GET['to_lang']) && $_POST['language'] == $language->abbr || isset($_GET['to_lang']) && $_GET['to_lang'] == $language->abbr ? 'selected=""' : '' ?> value="<?= $language->abbr ?>"><?= $language->abbr ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-lg btn-default">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/articles') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>
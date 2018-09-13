<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.4/css/bootstrap-select.min.css') ?>">
<div id="categories">
    <div class="card">
        <div class="card-body">
            <div class="form-header">
                <h1><?= lang('list_categores') ?></h1>
            </div>
            <div id="errors" class="alert alert-success" <?= $this->session->flashdata('result') ? 'style="display:block;"' : '' ?>><?= $this->session->flashdata('result') ?></div>
            <div class="text-center">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#modalAddEditCategory" class="btn btn-default"><?= lang('add_category') ?></a> 
            </div>
            <ol class="breadcrumb">
                <li><a href="<?= base_url('admin/categories') ?>"><?= lang('head_categores') ?></a></li>
                <?php
                if (isset($_GET['parent_for']) && (int) $_GET['parent_for'] > 0) {
                    foreach ($parents as $parent) {
                        if ($parent['name'] != '') {
                            ?>
                            <li><a href="<?= base_url('admin/categories?parent_for=' . $parent['id']) ?>"><?= $parent['name'] ?></a></li>
                            <?php
                        }
                    }
                }
                ?>
            </ol>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= lang('category') ?></th>
                            <th><?= lang('position') ?></th>
                            <th class="text-right"><?= lang('options') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $hc) { ?>
                            <tr>
                                <td><?= $hc['name'] ?></td>
                                <td><?= $hc['position'] ?></td>
                                <td class="text-right">
                                    <a href="<?= base_url('admin/categories/delete/' . $hc['category_id']) ?>" onclick="return confirm('<?= lang('are_u_sure_want_to_del') ?>?');" class="btn btn-danger"><?= lang('delete') ?></a>
                                    <a href="<?= base_url('admin/categories/edit/' . $hc['category_id']) ?>" class="btn btn-default"><?= lang('edit') ?></a>
                                    <?php if ($hc['have_parents'] > 0) { ?>
                                        <a href="?parent_for=<?= $hc['category_id'] ?>" class="btn btn-default"><?= lang('show_sub_categories') ?> <span class="glyphicon glyphicon-chevron-right"></span></a>
                                    <?php } ?>
                                </td>
                            </tr> 
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddEditCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="title"><i class="fa fa-pencil"></i> <?= lang('add_edit_category') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <form method="POST" action="">
                <div class="modal-body">
                    <div id="errors_c" class="alert alert-success"></div>
                    <div>
                        <span><?= lang('languages') ?></span>
                        <?php foreach ($languages as $language) { ?>
                            <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>"><?= $language->abbr ?></button>
                        <?php } ?>
                    </div>
                    <?php foreach ($languages as $language) { ?>
                        <div class="<?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'mine-lang' : 'not-mine-lang' ?> locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
                            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                            <div class="form-group"> 
                                <label><?= lang('title') ?> (<?= $language->name ?>)</label>
                                <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load['translations'][$language->abbr]['name']) ? $trans_load['translations'][$language->abbr]['name'] : '' ?>" class="form-control">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group"> 
                        <label><?= lang('to_be_sub_category_on') ?></label>
                        <select name="parent" class="selectpicker" id="category_parent">
                            <option value="0" <?= ($edit > 0 && $trans_load['parent'] == 0) || $edit == 0 && !isset($_GET['parent_for']) ? 'selected=""' : '' ?>>Няма</option>
                            <?php foreach ($allCategories as $categorie) { ?>
                                <option value="<?= $categorie['id'] ?>" <?= ($edit > 0 && $trans_load['parent'] == $categorie['id']) || isset($_GET['parent_for']) && $_GET['parent_for'] == $categorie['id'] ? 'selected=""' : '' ?>><?= $categorie['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">  
                        <label><?= lang('position') ?>:</label>
                        <input type="text" class="form-control" placeholder="1" value="<?= isset($trans_load) ? $trans_load['position'] : '' ?>" name="position">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-default" type="submit" name="goSubmit" onclick="return validateCategory()"><?= lang('save') ?></button>
                    </div> 
                </div>
            </form>
        </div> 
    </div>
</div>
<script src="<?= base_url('assets/bootstrap-select-1.12.4/js/bootstrap-select.min.js') ?>"></script>
<?php if ((int) $edit > 0) { ?>
    <script>
                            $(document).ready(function () {
                                $('#modalAddEditCategory').modal('show');
                            });
                            $('.selectpicker').selectpicker({
                                style: 'btn-default',
                                size: 4,
                                liveSearch: true
                            });
    </script>
<?php } ?>
<script>
    var variable_c = {
        is_update: <?= $edit > 0 ? 'true' : 'false' ?>,
        free_url_check: '<?= base_url('urlcategorychecker') ?>'
    };
<?php if (!isset($_GET['parent_for']) && (int) $edit > 0) { ?>
        $('#modalAddEditCategory').on('hidden.bs.modal', function () {
            window.location.href = "<?= base_url('admin/categories') ?>";
        });
<?php } ?>
</script>

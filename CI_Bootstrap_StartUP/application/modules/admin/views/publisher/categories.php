<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<h1>Categories</h1> 
<hr>
<?php if (validation_errors()) { ?>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_add')) {
    ?>
    <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_delete')) {
    ?>
    <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
    <hr>
    <?php
}
?>
<a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary pull-right" style="margin-bottom:10px;"><b>+</b> Add categorie</a>
<?php
if (!empty($categories)) {
    ?>
    <table class="table table-striped custab">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>In Navigation</th>
                <th></th>
            </tr>
        </thead>
        <?php
        $i = 1;
        foreach ($categories as $key_cat => $categorie) {
            $catName = '';
            foreach ($categorie['info'] as $ff) {
                $catName .= '<div>'
                        . '<a href="javascript:void(0);" class="editCategorie" data-indic="' . $i . '" data-for-id="' . $key_cat . '" data-abbr="' . $ff['abbr'] . '" data-toggle="tooltip" data-placement="top" title="Edit this categorie">'
                        . '<i class="fa fa-pencil" aria-hidden="true"></i>'
                        . '</a> '
                        . '[' . $ff['abbr'] . ']<span id="indic-' . $i . '">' . $ff['name'] . '</span>'
                        . '</div>';
                $i++;
            }
            ?>
            <tr>
                <td><?= $key_cat ?></td>
                <td><?= $catName ?></td>
                <td> 
                    <a href="javascript:void(0);" class="editCategorieSub" data-sub-for-id="<?= $key_cat ?>">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <?php foreach ($categorie['sub'] as $sub) { ?>
                        <div> <?= $sub ?> </div>
                    <?php } ?>
                </td>
                <td>
                    <input data-update-id="<?= $categorie['id'] ?>" data-toggle="toggle" <?= $categorie['nav'] == 1 ? 'checked=""' : '' ?> data-for-field="publicQuantity" class="toggle-changer changeNavVisibility" type="checkbox">
                </td>
                <td class="text-center">
                    <a href="<?= base_url('admin/categories/?delete=' . $key_cat) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    echo $links_pagination;
} else {
    ?>
    <div class="clearfix"></div><hr>
    <div class="alert alert-info">No categories found!</div>
<?php } ?>

<!-- add edit home categorie -->
<div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Categorie for magazine</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="nav" value="0">
                    <div class="form-group">
                        <label>Url Name</label>
                        <input type="text" name="name" placeholder="бтв-новините" class="form-control">
                    </div>
                    <?php foreach ($languages->result() as $language) { ?>
                        <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                    <?php } foreach ($languages->result() as $language) { ?>
                        <div class="form-group">
                            <label>Name (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                            <input type="text" name="categorie_name[]" class="form-control">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Parent:</label>
                        <select class="form-control" name="sub_for">
                            <option value="0">None</option>
                            <?php
                            foreach ($categories as $key_cat => $categorie) {
                                $aa = '';
                                foreach ($categorie['info'] as $ff) {
                                    $aa .= '[' . $ff['abbr'] . ']' . $ff['name'] . '/';
                                }
                                ?>
                                <option value="<?= $key_cat ?>"><?= $aa ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Show in nav</label>
                        <input data-toggle="toggle" class="toggle-changer showInNavOnAdd" type="checkbox">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="categorieEditor">
    <input type="text" name="new_value" class="form-control" value="">
    <button type="button" class="btn btn-default saveEditCategorie">
        <i class="fa fa-floppy-o noSaveEdit" aria-hidden="true"></i>
        <i class="fa fa-spinner fa-spin fa-fw yesSaveEdit"></i>
    </button>
    <button type="button" class="btn btn-default closeEditCategorie"><i class="fa fa-times" aria-hidden="true"></i></button>
</div>
<div id="categorieSubEdit">
    <form method="POST" id="categorieEditSubChanger">
        <input type="hidden" name="editSubId" value="">
        <select class="selectpicker" name="newSubIs">
            <option value=""></option>
            <option value="0">None</option>
            <?php
            foreach ($categories as $key_cat => $categorie) {
                $aa = '';
                foreach ($categorie['info'] as $ff) {
                    $aa .= '[' . $ff['abbr'] . ']' . $ff['name'] . '/';
                }
                ?>
                <option value="<?= $key_cat ?>"><?= $aa ?></option>
            <?php } ?>
        </select>
    </form>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<div id="languages">
    <h1>Languages</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right"><b>+</b> Add new language</a>
    <?php
    if ($languages->result()) {
        ?>
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Abbr</th>
                    <th>Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php foreach ($languages->result() as $language) { ?>
                <tr>
                    <td><?= $language->id ?></td>
                    <td><?= $language->abbr ?></td>
                    <td><?= $language->name ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/languages/?delete=' . $language->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure continue deleting?')"><span class="glyphicon glyphicon-remove"></span> Del</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No languages found!</div>
    <?php } ?>
    <div class="alert alert-warning">
        <b>How to:</b>
        <div>To set multilanguage site:</div>
        <ul>
            <li>Add languages here</li>
            <li>Add language folder in <i>application/languages/</i> (copy english folder)</li>
            <li>Set the default language from <i>applicaton/config/config.php (default_language)</i></li>
        </ul><br>
        <div>To get multilanguage site:</div>
        <ul>
            <li>To get article in specific languages add paramenter <i>$this->my_lang</i> to get methods or add <i>NULL</i></li>
            <li>To get translated text from languages folder call with <i>lang('key')</i></li>
            <li>Make links like this example: <i>base_url($this->lang_link.'controller')</i></li>
        </ul>
        <br>
        <p>Set language links maybe like this:</p>
        <b style=" display: block;margin-left:20px;">
            &lt;?php $this->my_lang != $this->def_lang ? preg_match("/\w{2}\/?(.*)/", uri_string(), $controller) : $controller[1] = $this->uri->segment(2); ?&gt;<br>
            &lt;?= base_url('/en/' . $controller[1]) ?&gt;<br>
            &lt;?= base_url('/en/' . $controller[1]) ?&gt;
        </b>
    </div>
    <!-- add edit languages -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Language</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="abbr">Abbrevation</label>
                            <input type="text" name="abbr" class="form-control" id="abbr">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
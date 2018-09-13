<script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script> 
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.4/css/bootstrap-select.min.css') ?>">
<?php if ($this->session->flashdata('result')) { ?> 
	<div class="alert alert-success"><?= $this->session->flashdata('result') ?></div> 
<?php } ?> 

<div class="text-right">
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAddBlogPost">
  <?= lang('add_blog_post') ?>
</button>
</div>

<div class="row" id="blogposts">
<?php if(!empty($posts)) { 
foreach($posts as $post) {
 ?>
 <div class="col-sm-6 col-md-4 col-lg-3">  
	<div class="blog"> 
		<img src="<?= base_url(BLOG_IMAGE.$post['image']) ?>" alt="Няма качена снимка">
		<h3><a href="<?= base_url($post['url']) ?>" target="_blank"><?= $post['title'] ?></a></h3> 
		<hr>
		<div class="text-center">
			<a class="btn btn-danger" href="<?= base_url('admin/blog/delete/'.$post['id']) ?>" onclick="return confirm('Сигурен ли си, че искаш да бъде изтрита?')"><?= lang('delete') ?></a>
			<a class="btn btn-default" href="<?= base_url('admin/blog?editPost='.$post['id']) ?>"><?= lang('edit') ?></a>
		</div>
	</div>
 </div>
 <?php 
}
 } else {
 ?>
<div class="col-xs-12">Няма добавени постове</div>
<?php } ?>
</div>
<?= $links_pagination ?>

<hr>

<h4 class="text-center"><?= lang('list_categories') ?></h4>
<div class="text-center"><button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#modalAddBlogCategory"><?= lang('add_category') ?></button></div>
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
<?php foreach($categories as $hc) { ?>
  <tr>
	<td><?= $hc['title'] ?></td>
	<td><?= $hc['position'] ?></td>
	<td class="text-right">
		<a href="<?= base_url('admin/blog/delete/category/'.$hc['id']) ?>" onclick="return confirm('<?= lang('are_u_sure_want_to_del') ?>');" class="btn btn-danger"><?= lang('delete') ?></a>
		<a href="<?= base_url('admin/blog?editPostCategory='.$hc['id']) ?>" class="btn btn-default"><?= lang('edit') ?></a>
	</td>
  </tr> 
<?php } ?>
</tbody>
</table>
</div>

<div class="modal fade" id="modalAddBlogPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang('edit_post') ?></h4>
      </div>
      <div class="modal-body">
	  <div class="alert alert-danger modal-errors"></div>
        <form method="POST" action="" enctype="multipart/form-data">
		<div class="form-group available-translations">
				<b>Език</b>
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
							<label>Заглавие (<?= $language->name ?>)</label>
							<input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
						</div>
						<div class="form-group">
							<label for="description<?= $i ?>">Описание (<?= $language->name ?>)</label>
							<textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
							<script>
								var editor = CKEDITOR.replace('description<?= $i ?>');
								CKEDITOR.config.extraPlugins = 'uploadimage';
								CKEDITOR.config.uploadUrl = '/uploader/upload.php';
								CKEDITOR.config.entities = false;
								CKFinder.setupCKEditor(editor);
							</script> 
						</div> 
					</div>
					<?php
					$i++;
				}
				?>
            <div class="form-group">
                <?php if (isset($_POST['image'])) { ?>
                    <input type="hidden" name="old_image" value="<?= $_POST['image'] ?>">
                    <div><img class="img-responsive" src="<?= base_url(BLOG_IMAGE . $_POST['image']) ?>"></div>
                    <label for="userfile">Избери друга снимка:</label>
                <?php } else { ?>
                    <label for="userfile">Качи снимка:</label>
                <?php } ?>
                <input type="file" id="userfile" name="userfile">
            </div>
			<div class="form-group">
				<label>Позиция</label>
				<input type="text" class="form-control" placeholder="1" value="<?= isset($_POST['position']) ? $_POST['position'] : 1 ?>" name="position">
            </div>
			<div class="form-group">
				<label>Категория</label>
				<select name="category" class="selectpicker">
				<?php foreach($categories as $hc) { ?>
				  <option <?= isset($_POST['category']) && $_POST['category'] == $hc['id'] ? 'selected=""' : '' ?> value="<?= $hc['id'] ?>"><?= $hc['title'] ?></option>
				<?php } ?>
				</select>
			</div>
            <button type="submit" name="submitPost" class="hidden submitPost"></button> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
        <button type="button" class="btn btn-primary" onclick="blogPostSubmit()"><?= lang('publish') ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddBlogCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang('add_edit_blog_category') ?></h4>
      </div>
      <div class="modal-body">
	  <div class="alert alert-danger modal-errors"></div>
	 <form method="POST" action="">
		<div class="form-group available-translations">
				<b>Език</b>
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
							<label>Заглавие (<?= $language->name ?>)</label>
							<input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
						</div> 
					</div>
					<?php
					$i++;
				} 
				?>
			<div class="form-group">
				<label><?= lang('position') ?></label>
				<input type="text" class="form-control" placeholder="1" value="<?= isset($_POST['position']) ? $_POST['position'] : 1 ?>" name="position">
            </div>
			<button type="submit" name="submitPostCategory" class="hidden submitPostCategory"></button> 
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
        <button type="button" class="btn btn-primary" onclick="blogCategorySubmit()"><?= lang('save') ?></button>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/bootstrap-select-1.12.4/js/bootstrap-select.min.js') ?>"></script>
<script> 
<?php if(isset($_GET['editPost'])) { ?>
$(document).ready(function(){
	$('#modalAddBlogPost').modal('show');
});
<?php } if(isset($_GET['editPostCategory'])) { ?>
$(document).ready(function(){
	$('#modalAddBlogCategory').modal('show');
});
<?php } ?>
 
var variable = {
	is_update: <?= isset($trans_load) ? 'true' : 'false' ?>,
	free_blog_category_url: '<?= base_url('urlblogcategorychecker') ?>',
	free_blog_url: '<?= base_url('urlblogchecker') ?>'
};
</script>
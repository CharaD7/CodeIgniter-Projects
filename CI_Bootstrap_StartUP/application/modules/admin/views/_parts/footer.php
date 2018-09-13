<?php if ($this->session->userdata('logged_in')) { ?>
</div>
</div>
</div>
</div>
<footer>
<div class="row"> 
	<div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
		<ul class="nav hidden-xs">
			<li> 
				<a href="<?= base_url('admin/publish') ?>">
				 Публикувай
				</a>
			</li>
			<li>
				<a href="<?= base_url('admin/categories') ?>">
				Категории
				</a>
			</li>
			<li class="in-right">
				<a href="https://github.com/kirilkirkov" target="_blank">
					Github <i class="fa fa-github" aria-hidden="true"></i> :: Kiril Kirkov
				</a>
			</li>
		</ul>
	</div>
</div>
</footer> 
</div> 
<?php } else { ?>
</div>
</div>
</div> 
<?php } ?>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
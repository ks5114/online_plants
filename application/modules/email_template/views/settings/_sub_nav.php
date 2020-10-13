<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/email_template') ?>" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="list">
			<span>
				<i class="fa fa-list"></i>
				<span><?php echo lang('bf_action_list'); ?></span>
			</span>
		</a>
	</li>
	<?php if ($this->auth->has_permission('Email_Template.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/email_template/create') ?>" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="create_new">
			<span>
				<i class="la la-cart-plus"></i>
				<span><?php echo lang('bf_new'); ?></span>
			</span>
		</a>
	</li>
	<?php endif; ?>
</ul>
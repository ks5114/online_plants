<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/master/country';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == '' ? ' class="active"' : ''; ?>>
		<a class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" href="<?php echo site_url($areaUrl); ?>" id='list'>
			<span><i class="fa fa-list"></i><span><?php echo lang('country_list'); ?></span></span>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Country.Master.Create')) : ?>
	<li<?php echo $checkSegment == 'create' ? ' class="active"' : ''; ?>>
		<a class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" href="<?php echo site_url($areaUrl . '/create'); ?>" id='create_new'>
			<span><i class="la la-cart-plus"></i><span><?php echo lang('country_new'); ?></span></span>
        </a>
	</li>
	<?php endif; ?>
</ul>
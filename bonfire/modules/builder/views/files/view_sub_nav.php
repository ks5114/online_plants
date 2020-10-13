<?php

$controller_name_lower = strtolower($controller_name);
$ucModuleName = preg_replace("/[ -]/", "_", ucfirst($module_name));
$ucControllerName = ucfirst($controller_name);

$createPermission = "{$ucModuleName}.{$ucControllerName}.Create";

//------------------------------------------------------------------------------
// Output the view
//------------------------------------------------------------------------------

echo "<?php

\$checkSegment = \$this->uri->segment(4);
\$areaUrl = SITE_AREA . '/{$controller_name_lower}/{$module_name_lower}';

?>

<ul class='nav nav-pills'>
	<li<?php echo \$checkSegment == '' ? ' class=\"active\"' : ''; ?>>
		<a class='btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill' href=\"<?php echo site_url(\$areaUrl); ?>\" id='list'>
			<span><i class='fa fa-list'></i><span><?php echo lang('{$module_name_lower}_list'); ?></span></span>
        </a>
	</li>
	<?php if (\$this->auth->has_permission('{$createPermission}') && \$checkSegment == '') : ?>
	<li<?php echo \$checkSegment == 'create' ? ' class=\"active\"' : ''; ?>>
		<a class='btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill' href=\"<?php echo site_url(\$areaUrl . '/create'); ?>\" id='create_new'>
			<span><i class='la la-cart-plus'></i><span><?php echo lang('{$module_name_lower}_new'); ?></span></span>
        </a>
	</li>
	<?php endif; ?>
</ul>";
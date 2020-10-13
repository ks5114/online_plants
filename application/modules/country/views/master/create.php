<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class='alert alert-block alert-error fade in'>
	<a class='close' data-dismiss='alert'>&times;</a>
	<h4 class='alert-heading'>
		<?php echo lang('country_errors_message'); ?>
	</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

$id = isset($country->id) ? $country->id : '';
?>
<div class="portlet light bordered">
	<div class="portlet-title double-tile">
		<div class="caption font-green float-left">
			<!--<i class="fa fa-pencil font-green"></i>-->
			<span class="caption-subject bold uppercase"> Create Country</span>
		</div>
		<div class="actions float-right">
			<div class="btn-group">
				<a class="btn btn-sm default dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Settings</a>
				<ul class="dropdown-menu pull-right">
					<li>
						<a href="javascript:;">
							<i class="fa fa-pencil"></i> Edit </a>
					</li>
					<li>
						<a href="javascript:;">
							<i class="fa fa-trash-o"></i> Delete </a>
					</li>
					<li>
						<a href="javascript:;">
							<i class="fa fa-ban"></i> Ban </a>
					</li>
					<li class="divider"> </li>
					<li>
						<a href="javascript:;"> Make admin </a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="portlet-body form">
		<?php echo form_open($this->uri->uri_string(), 'class=""'); ?>
		<div class="row">
			<div class="form-body col-md-6">

				<div class="form-group form-md-line-input form-md-floating-label <?php echo form_error('country_code') ? ' has-error' : ''; ?>">
					<?php echo form_label('Country Code'. lang('bf_form_label_required'), 'country_code', array('class' => '')); ?>
					<input id='country_code' class='form-control input-medium' type='text' required='required' name='country_code' maxlength='255' value="<?php echo set_value('country_code', isset($country->country_code) ? $country->country_code : ''); ?>" />
					<label id='country_code-error' class='error' for='country_code'></label>
					<span class="help-block"><?php echo form_error('country_code'); ?></span>
				</div>

				<div class="form-group form-md-line-input form-md-floating-label <?php echo form_error('country_name') ? ' has-error' : ''; ?>">
					<?php echo form_label('Country Name'. lang('bf_form_label_required'), 'country_name', array('class' => '')); ?>
					<input id='country_name' class='form-control input-medium' type='text' required='required' name='country_name' maxlength='255' value="<?php echo set_value('country_name', isset($country->country_name) ? $country->country_name : ''); ?>" />
					<label id='country_name-error' class='error' for='country_name'></label>
					<span class="help-block"><?php echo form_error('country_name'); ?></span>
				</div>
				<?php
				$options = array(
					1 => 'Active',
					0 => 'Inactive'
				); ?>
				<?php echo form_dropdown('status', $options, set_value('status', isset($country->status) ? $country->status : ''), 'Status'. lang('bf_form_label_required'),'class="form-control"')?>
				<span class="help-inline"><?php echo form_error('status'); ?></span>

			</div>
		</div>
			<div class="form-actions noborder">
				<!--<button type="button" class="btn blue">Submit</button>-->
				<input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('country_action_create'); ?>" />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA . '/master/country', lang('country_cancel'), 'class="btn btn-secondary"'); ?>
				<!--<button type="button" class="btn default">Cancel</button>-->
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

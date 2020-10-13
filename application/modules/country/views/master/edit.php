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
<div class='admin-box portlet box green'>
 <div class='portlet-title'>
        <div class='caption'>
            <i class='fa fa-pencil'></i> Edit Country
        </div>
    </div>
    <div class='portlet-body form'>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
            

			<div class="control-group<?php echo form_error('country_code') ? ' has-error' : ''; ?>">
				<?php echo form_label('Country Code'. lang('bf_form_label_required'), 'country_code', array('class' => 'control-label col-md-6')); ?>
				<div class='controls'>
					<input id='country_code' class='form-control input-medium' type='text' required='required' name='country_code' maxlength='255' value="<?php echo set_value('country_code', isset($country->country_code) ? $country->country_code : ''); ?>" />
					<label id='country_code-error' class='error' for='country_code'></label>
					<span class='help-inline'><?php echo form_error('country_code'); ?></span>
				</div>
			</div>

			<div class="control-group<?php echo form_error('country_name') ? ' has-error' : ''; ?>">
				<?php echo form_label('Country Name'. lang('bf_form_label_required'), 'country_name', array('class' => 'control-label col-md-6')); ?>
				<div class='controls'>
					<input id='country_name' class='form-control input-medium' type='text' required='required' name='country_name' maxlength='255' value="<?php echo set_value('country_name', isset($country->country_name) ? $country->country_name : ''); ?>" />
					<label id='country_name-error' class='error' for='country_name'></label>
					<span class='help-inline'><?php echo form_error('country_name'); ?></span>
				</div>
			</div>
        <?php
        $options = array(
                1 => 'Active',
                0 => 'Inactive'
        ); ?>
        <?php echo form_dropdown('status', $options, set_value('status', isset($country->status) ? $country->status : ''), 'Status'. lang('bf_form_label_required'),'class="form-control input-medium"')?>
        <span class="help-inline"><?php echo form_error('status'); ?></span>
        
        </fieldset>
		<fieldset class='form-actions'>
			<input type='submit' name='save' class='btn green' value="<?php echo lang('country_action_edit'); ?>" />
			<?php echo lang('bf_or'); ?>
			<?php echo anchor(SITE_AREA . '/master/country', lang('country_cancel'), 'class="btn default"'); ?>
			
			<?php if ($this->auth->has_permission('Country.Master.Delete')) : ?>
				<?php echo lang('bf_or'); ?>
				<button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('country_delete_confirm'))); ?>');">
					<span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('country_delete_record'); ?>
				</button>
			<?php endif; ?>
		</fieldset>
    <?php echo form_close(); ?>
</div>
</div>
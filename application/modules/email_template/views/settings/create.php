<?php if (validation_errors()) : ?>

    <div class="alert alert-block alert-error fade in "><a class="close" data-dismiss="alert">&times;</a>
        <h4 class="alert-heading">Please fix the following errors :</h4>
        <?php echo validation_errors(); ?> </div>
<?php endif; ?>
<?php
// Change the css classes to suit your needs
if (isset($email_template)) {
    $email_template = (array)$email_template;
}
$id = isset($email_template['id']) ? $email_template['id'] : '';
?>
<div class="admin-box  portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject">Create Email Template</span>
        </div>
    </div>
    <div class="portlet-body form">
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div
            class="control-group <?php echo form_error('title') ? 'has-error' : ''; ?>"> <?php echo form_label('Title' . lang('bf_form_label_required'), 'title', array('class' => "control-label")); ?>
            <div class='controls'>
                <input id="title" type="text" name="title" maxlength="255" class="form-control input-medium"
                       value="<?php echo set_value('title', isset($email_template['title']) ? $email_template['title'] : ''); ?>"/>
                <span class="help-inline"><?php echo form_error('title'); ?></span></div>
        </div>
        <div
            class="control-group <?php echo form_error('label') ? 'has-error' : ''; ?>"> <?php echo form_label('Label' . lang('bf_form_label_required'), 'label', array('class' => "control-label")); ?>
            <div class='controls'>
                <input id="label" type="text" name="label" maxlength="255" class="form-control input-medium"
                       value="<?php echo set_value('label', isset($email_template['label']) ? $email_template['label'] : ''); ?>"/>
                <span class="help-inline"><?php echo form_error('label'); ?></span></div>
        </div>
        <div class="control-group">
            <div class='controls' id="variables">
                <a href="javascript:void(0);">[USER_FULLNAME]</a>
                <a href="javascript:void(0);">[USER_FNAME]</a>
                <a href="javascript:void(0);">[USER_LNAME]</a>
                <a href="javascript:void(0);">[USER_PHONE_NO]</a>
                <a href="javascript:void(0);">[USER_MESSAGE]</a>
                <a href="javascript:void(0);">[USER_EMAIL]</a>
                <a href="javascript:void(0);">[SITE_NAME]</a>
                <a href="javascript:void(0);">[DATE]</a>
                <a href="javascript:void(0);">[TIME]</a>
                <a href="javascript:void(0);">[SITE_URL]</a>
                <a href="javascript:void(0);">[SITE_MAIL]</a>
                <a href="javascript:void(0);">[ORDER_DETAILS]</a>
                <a href="javascript:void(0);">[DENTIST_NAME]</a>
                <a href="javascript:void(0);">[APPOINTMENT_INFO]</a>
                <a href="javascript:void(0);">[ACTIVATION_LINK]</a>
            </div>
        </div>
        <div
            class="control-group <?php echo form_error('content') ? 'has-error' : ''; ?>"> <?php echo form_label('Content' . lang('bf_form_label_required'), 'content', array('class' => "control-label")); ?>
            <div
                class='controls'> <?php echo form_textarea(array('name' => 'content', 'id' => 'content', 'class' => 'ckeditor', 'rows' => '5', 'cols' => '80', 'value' => set_value('content', isset($email_template['content']) ? $email_template['content'] : ''))) ?>
                <span class="help-inline"><?php echo form_error('content'); ?></span></div>
        </div>
        <?php
        $options = array(
            1 => 'Active',
            0 => 'Inactive'
        );
        ?>
        <?php echo form_dropdown('status', $options, set_value('status', isset($email_template['status']) ? $email_template['status'] : ''), 'Status','class="form-control input-medium"') ?>
        <span class="help-inline"><?php echo form_error('status'); ?></span>

        <div class="form-actions"><br/>
            <input type="submit" name="save" class="btn green" value="Create Email Template"/>
            or <?php echo anchor(SITE_AREA . '/settings/email_template', lang('bf_action_cancel'), 'class="btn default"'); ?>
        </div>
    </fieldset>
    <?php echo form_close(); ?></div> </div>

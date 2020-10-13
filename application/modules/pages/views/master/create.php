<style type="text/css">
    .error {
        color: red;
    }
</style>
<?php if (validation_errors()) : ?>
    <div class="alert alert-block alert-error fade in ">
        <a class="close" data-dismiss="alert">&times;</a>
        <h4 class="alert-heading">Please fix the following errors :</h4>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if (isset($pages)) {
    $pages = (array)$pages;
}
$id = isset($pages['id']) ? $pages['id'] : '';
?>
<div class="admin-box  portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject">Create Pages</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
                <div class="portlet-body form">
                <?php
                $config = array(
                    "class" => "form-horizontal",
                    'id' => "pages",
                    'name' => "pages"
                );
                echo form_open($this->uri->uri_string(), $config);
                ?>
                <fieldset>
                    <div class="control-group  <?php echo form_error('page_title') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Page Title' . lang('bf_form_label_required'), 'page_title', array('class' => "control-label ")); ?>
                        <div class='controls'>
                            <input id="page_title" type="text" name="page_title" maxlength="100" class="form-control input-medium" required="required" value="<?php echo set_value('page_title', isset($pages['page_title']) ? $pages['page_title'] : ''); ?>"/>
                            <span class="help-inline"><?php echo form_error('page_title'); ?></span>
                        </div>


                    </div>
                    <div class="control-group <?php echo form_error('page_slug') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Page Slug' . lang('bf_form_label_required'), 'page_slug', array('class' => "control-label")); ?>
                        <div class='controls'>
                            <input id="page_slug" type="text" name="page_slug" maxlength="100" class="form-control input-medium"
                                   value="<?php echo set_value('page_slug', isset($pages['page_slug']) ? $pages['page_slug'] : ''); ?>"/>
                            <span class="help-inline"><?php echo form_error('page_slug'); ?></span>
                        </div>


                    </div>
                    <div class="control-group <?php echo form_error('page_content') ? 'has-error' : ''; ?>">
                        <?php echo form_label('Page Content', 'page_content', array('class' => "control-label")); ?>
                        <div class='controls'>
                            <?php echo form_textarea(array('name' => 'page_content', 'id' => 'page_content', 'class' => 'ckeditor form-control input-medium', 'rows' => '5', 'cols' => '80', 'value' => set_value('page_content', isset($pages['page_content']) ? $pages['page_content'] : ''))) ?>
                            <span class="help-inline"><?php echo form_error('page_content'); ?></span>
                        </div>

                    </div>

                    <?php
                    $options = array(
                        1 => 'Active',
                        0 => 'Inactive'
                    ); ?>
                    <?php echo form_dropdown('status', $options, set_value('status', isset($pages['status']) ? $pages['status'] : ''), 'Status',"class='form-control input-medium'") ?>
                    <span class="help-inline"><?php echo form_error('status'); ?></span>


                    <div class="form-actions">
                        <br/>
                        <input type="submit" name="save" class="btn btn-primary" value="Create Pages"/>
                        or <?php echo anchor(SITE_AREA . '/master/pages', lang('bf_action_cancel'), 'class="btn btn-secondary"'); ?>

                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

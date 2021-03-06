<?php
$sessionError = $this->session->flashdata('error');
$validationErrors = validation_errors();

// Wrapped the whole page in a div.module-builder so module-level CSS won't mess
// up other pages
?>
<div class='module-builder'>
    <p class="intro alert-warning"><?php e(lang('mb_create_note')); ?></p>
    <div class="alert alert-info fade show in">
        <a class="close" data-dismiss="alert"></a>
        <?php echo lang('mb_form_note'); ?>
    </div>
    <?php
    //--------------------------------------------------------------------------
    // Begin Error Messages section
    //--------------------------------------------------------------------------
    if (! $writable) :
    ?>
    <div class="alert alert-danger fade show in">
        <a class="close" data-dismiss="alert"></a>
        <p><?php echo lang('mb_not_writable_note'); ?></p>
    </div>
    <?php
    endif;

    if ($validationErrors) :
    ?>
    <div class="alert alert-danger fade show in">
        <a data-dismiss="alert" class="close"></a>
        <h4 class="alert-heading"><?php echo lang('mb_form_errors'); ?></h4>
        <?php echo $validationErrors; ?>
    </div>
    <?php
    endif;

    if ($sessionError):
    ?>
    <div class="alert alert-danger fade show in">
        <a data-dismiss="alert" class="close"></a>
        <?php echo $sessionError; ?>
    </div>
    <?php
    endif;

    if (isset($error_message)) :
    ?>
    <div class="alert alert-danger fade show in">
        <a data-dismiss="alert" class="close"></a>
        <?php echo $error_message; ?>
    </div>
    <?php
    endif;
    //--------------------------------------------------------------------------
    // End Error Messages section
    //--------------------------------------------------------------------------
    ?>
    <div class="admin-box  portlet box green ">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject">Create Module</span>
            </div>
        </div>
        <div class="portlet-body form">
        <?php
        // If we just append $field_total to the current_url(), failed form
        // validation results in multiple additions of $field_total, until it
        // eventually can't be routed to the controller
        $formSubmitUrl = current_url();
        if ($field_total > 0) {
            $urlSegments = $this->uri->segment_array();
            if (! is_numeric($urlSegments[$this->uri->total_segments()])) {
                $formSubmitUrl .= "/{$field_total}";
            }
        }
        echo form_open($formSubmitUrl, array('id' => 'module_form', 'class' => 'form-horizontal'));
            //------------------------------------------------------------------
            // Module Details
            //------------------------------------------------------------------
        ?>
            <fieldset id="module_details">
                <legend class="head-title"><?php echo lang('mb_form_mod_details'); ?></legend>
                <div class="control-group<?php echo form_error('module_name') ? ' has-error' : ''; ?>">
                    <label for="module_name" class="control-label block"><?php echo lang('mb_form_mod_name'); ?></label>
                    <div class="controls">
                        <input name="module_name" class="form-control input-medium" id="module_name" type="text" value="<?php echo set_value("module_name"); ?>" placeholder="<?php echo lang('mb_form_mod_name_ph'); ?>" />
                        <span class="help-inline"><?php echo form_error('module_name'); ?></span>
                        <div><a href="#" class="mb_show_advanced small"><?php echo lang('mb_form_show_advanced'); ?></a></div>
                    </div>
                </div>
                <?php
                //--------------------------------------------------------------
                // Module Details - Advanced Options
                //--------------------------------------------------------------
                ?>
                <div class="control-group mb_advanced<?php echo form_error('module_description') ? ' has-error' : ''; ?>">
                    <label for="module_description" class="control-label block"><?php echo lang('mb_form_mod_desc'); ?></label>
                    <div class="controls">
                        <input name="module_description" class="form-control input-medium" id="module_description" type="text" value="<?php echo set_value("module_description", lang('mb_form_mod_desc_ph')); ?>" placeholder="<?php echo lang('mb_form_mod_desc_ph'); ?>" />
                        <span class="help-inline"><?php echo form_error('module_description'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <label class="control-label block" id="contexts_label"><?php echo lang('mb_form_contexts'); ?></label>
                    <div class="controls" aria-labelledby="contexts_label" role="group">
                        <label class="custm-checkbox checkbox" for="contexts_public">
                            <input name="contexts[]" id="contexts_public" type="checkbox" value="public" checked="checked" />
                            <?php echo lang('mb_form_public'); ?>
                            <span></span>
                        </label>
                        <?php
                        // Build the checkboxes for each available Context
                        foreach ($availableContexts as $context) :
                        ?>
                        <label class="custm-checkbox checkbox" for="contexts_<?php echo $context; ?>">
                            <input name="contexts[]" id="contexts_<?php echo $context; ?>" type="checkbox" value="<?php echo $context; ?>" checked="checked" />
                            <?php echo ucwords($context); ?>
                            <span></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('form_action') ? ' has-error' : ''; ?>">
                    <?php echo form_error("form_action"); ?>
                    <label class="control-label" id="form_action_label"><?php echo lang('mb_form_actions'); ?></label>
                    <div class="controls" aria-labelledby="form_action_label" role="group">
                        <?php
                        // Build the checkboxes for the Controller Actions
                        foreach($form_action_options as $action => $label) :
                        ?>
                        <label class="custm-checkbox checkbox" for="form_action_<?php echo $action; ?>">
                            <?php
                            $data = array(
                                'name'        => 'form_action[]',
                                'id'          => "form_action_{$action}",
                                'value'       => $action,
                                'checked'     => 'checked',
                            );
                            echo form_checkbox($data);
                            echo $label;
                            ?>
                            <span></span>
                        </label>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <label class="control-label" for="role_id"><?php echo lang('mb_form_role_id'); ?></label>
                    <div class="controls">
                        <select name="role_id"  class="form-control input-medium" id="role_id">
                            <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['role_id']; ?>"<?php echo $defaultRoleWithFullAccess == $role['role_id'] ? ' selected="selected"' : ''; ?>><?php e($role['role_name']); ?></option>
                            <?php endforeach;?>
                        </select>
                     </div>
                </div>
                <?php
                //--------------------------------------------------------------
                // End of Module Details - Advanced Options
                //--------------------------------------------------------------
                ?>
                <div class="control-group">
                    <label class='control-label' for='mb_module_db'><?php echo lang('mb_module_db'); ?></label>
                    <div class="controls" id='mb_module_db'>
                        <label class="custom-radio inline radio" for="db_no">
                            <input name="module_db" id="db_no" type="radio" value="" <?php echo set_radio('module_db', '', true); ?> class="radio" />
                            <?php echo lang('mb_form_module_db_no'); ?><br/>
                            <span></span>
                        </label>
                        <label class="custom-radio inline radio" for="db_create">
                            <input name="module_db" id="db_create" type="radio" value="new" <?php echo set_radio('module_db', 'new'); ?> class="radio" />
                            <?php echo lang('mb_form_module_db_create'); ?><br/>
                            <span></span>
                        </label>
                        <label class="custom-radio inline radio" for="db_exists">
                            <input name="module_db" id="db_exists" type="radio" value="existing" <?php echo set_radio('module_db', 'existing'); ?> class="radio" />
                            <?php echo lang('mb_form_module_db_exists'); ?><br/>
                            <span></span>
                        </label>
                    </div>
                </div>
            </fieldset>
            <?php
            //------------------------------------------------------------------
            // Table Details
            //------------------------------------------------------------------
            ?>
            <fieldset id="db_details">
                <legend><?php echo lang('mb_form_table_details'); ?></legend>
                <div class="control-group">
                    <div class="controls">
                        <a href="#" class="mb_show_advanced small"><?php echo lang('mb_form_show_advanced'); ?></a>
                    </div>
                </div>
                <?php
                //--------------------------------------------------------------
                // Table Details - Advanced Options
                //--------------------------------------------------------------
                ?>
                <div class="control-group mb_advanced<?php echo form_error('table_name') ? ' has-error' : ''; ?>">
                    <label for="table_name" class="control-label block"><?php echo lang('mb_form_table_name'); ?></label>
                    <div class="controls">
                        <input name="table_name" class="form-control input-medium" id="table_name" type="text" value="<?php echo set_value('table_name'); ?>" placeholder="<?php echo lang('mb_form_table_name_ph'); ?>" />
                        <span class="help-inline"><?php echo form_error('table_name'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('form_error_delimiters') ? ' has-error' : ''; ?>">
                    <label for="form_error_delimiters" class="control-label block"><?php echo lang('mb_form_err_delims'); ?></label>
                    <div class="controls">
                        <input name="form_error_delimiters" class="form-control input-medium" id="form_error_delimiters" type="text" value="<?php echo set_value("form_error_delimiters", "<span class='error'>,</span>"); ?>" />
                        <span class="help-inline"><?php echo form_error('form_error_delimiters'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <label for="textarea_editor" class="control-label  block"><?php echo lang('mb_form_text_ed'); ?></label>
                    <div class="controls">
                        <select class="form-control input-medium" name="textarea_editor" id="textarea_editor">
                        <?php foreach($textarea_editors as $val => $label):?>
                            <option value="<?php echo $val?>"><?php echo $label?></option>
                        <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <div class="controls">
                        <label for="use_pagination" class="custm-checkbox checkbox">
                            <input type='checkbox' name="use_pagination" id="use_pagination" value="1" <?php echo set_checkbox('use_pagination', 1); ?> />
                            <?php echo lang('mb_form_use_pagination'); ?>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <div class="controls">
                        <label for="log_user" class="custm-checkbox checkbox">
                            <input type='checkbox' name="log_user" id="log_user" value='1' <?php echo set_checkbox('log_user', 1); ?> />
                            <?php echo lang('mb_form_log_user'); ?>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <div class="controls">
                        <label for="use_soft_deletes" class="custm-checkbox checkbox">
                            <input type='checkbox' name="use_soft_deletes" id="use_soft_deletes" value='1' <?php echo set_checkbox('use_soft_deletes', 1); ?> />
                            <?php echo lang('mb_form_soft_deletes'); ?>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('soft_delete_field') ? ' has-error' : ''; ?>">
                    <label for="soft_delete_field" class="control-label  block"><?php echo lang('mb_soft_delete_field'); ?></label>
                    <div class="controls">
                        <input name="soft_delete_field" class="form-control input-medium" id="soft_delete_field" type="text" value="<?php echo set_value('soft_delete_field', lang('mb_soft_delete_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('soft_delete_field'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('deleted_by_field') ? ' has-error' : ''; ?>">
                    <label for="deleted_by_field"  class="control-label  block"><?php echo lang('mb_deleted_by_field'); ?></label>
                    <div class="controls">
                        <input name="deleted_by_field" id="deleted_by_field" class="form-control input-medium" type="text" value="<?php echo set_value('deleted_by_field', lang('mb_deleted_by_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('deleted_by_field'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <div class="controls">
                        <label for="use_created" class="custm-checkbox checkbox">
                            <input type='checkbox' name="use_created" id="use_created" value='1' <?php echo set_checkbox('use_created', 1); ?> />
                            <?php echo lang('mb_form_use_created'); ?>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('created_field') ? ' has-error' : ''; ?>">
                    <label for="created_field" class="control-label block"><?php echo lang('mb_form_created_field'); ?></label>
                    <div class="controls">
                        <input name="created_field" class="form-control input-medium" id="created_field" type="text" value="<?php echo set_value('created_field', lang('mb_form_created_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('created_field'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('created_by_field') ? ' has-error' : ''; ?>">
                    <label for="created_by_field" class="control-label block"><?php echo lang('mb_form_created_by_field'); ?></label>
                    <div class="controls">
                        <input name="created_by_field"  class="form-control input-medium" id="created_by_field" type="text" value="<?php echo set_value('created_by_field', lang('mb_form_created_by_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('created_by_field'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced">
                    <div class="controls">
                        <label for="use_modified" class="custm-checkbox checkbox">
                            <input type='checkbox' name="use_modified" id="use_modified" value='1' <?php echo set_checkbox('use_modified', 1); ?> />
                            <?php echo lang('mb_form_use_modified'); ?>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('modified_field') ? ' has-error' : ''; ?>">
                    <label for="modified_field" class="control-label block"><?php echo lang('mb_form_modified_field'); ?></label>
                    <div class="controls">
                        <input name="modified_field" class="form-control input-medium" id="modified_field" type="text" value="<?php echo set_value('modified_field', lang('mb_form_modified_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('modified_field'); ?></span>
                    </div>
                </div>
                <div class="control-group mb_advanced<?php echo form_error('modified_by_field') ? ' has-error' : ''; ?>">
                    <label for="modified_by_field" class="control-label  block"><?php echo lang('mb_form_modified_by_field'); ?></label>
                    <div class="controls">
                        <input name="modified_by_field" class="form-control input-medium" id="modified_by_field" type="text" value="<?php echo set_value('modified_by_field', lang('mb_form_modified_by_field_ph')); ?>" />
                        <span class="help-inline match-existing-notes"><?php echo lang('mb_form_match_existing'); ?></span>
                        <span class="help-inline"><?php echo form_error('modified_by_field'); ?></span>
                    </div>
                </div>

                <!-- Grid Area -->
                <?php
                    $truefalse = array('false' => 'False', 'true' => 'True');
                ?>
                <div class="control-group mb_advanced">
                    <label for="use_status" class="control-label block"><?php echo lang('mb_form_use_status'); ?></label>
                    <div class="controls">
                        <select class="form-control input-medium" name="use_status" id="use_status">
                            <?php foreach ($truefalse as $val => $label): ?>
                                <option value="<?php echo $val ?>"><?php echo $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group mb_advanced <?php echo form_error('status_field') ? 'has-error' : ''; ?>">
                    <label for="status_field" class="control-label block"><?php echo lang('mb_form_status_field'); ?></label>
                    <div class="controls">
                        <input name="status_field" class="form-control input-medium" id="status_field" type="text" value="<?php echo set_value("status_field", "status"); ?>" />
                        <span class="help-inline"><?php echo form_error('status_field'); ?></span>
                    </div>
                </div>

                <div class="control-group mb_advanced">
                    <label for="use_position" class="control-label  block"><?php echo lang('mb_form_use_position'); ?></label>
                    <div class="controls">
                        <select class="form-control input-medium" name="use_position" id="use_position">
                            <?php foreach ($truefalse as $val => $label): ?>
                                <option value="<?php echo $val ?>"><?php echo $label ?></option>
                            <?php                   endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group mb_advanced <?php echo form_error('position_field') ? 'has-error' : ''; ?>">
                    <label for="position_field" class="control-label block"><?php echo lang('mb_form_position_field'); ?></label>
                    <div class="controls">
                        <input name="position_field" class="form-control input-medium" id="position_field" type="text" value="<?php echo set_value("position_field", "position"); ?>" />
                        <span class="help-inline"><?php echo form_error('position_field'); ?></span>
                    </div>
                </div>

                <!-- Grid Area -->

                <?php
                //--------------------------------------------------------------
                // End of Table Details - Advanced Options
                //--------------------------------------------------------------
                ?>
                <div class="alert alert-info fade show in">
                    <a class="close" data-dismiss="alert"></a>
                    <?php echo lang('mb_table_note'); ?>
                </div>
                <div class="control-group mb_new_table<?php echo form_error('primary_key_field') ? ' has-error' : ''; ?>">
                    <label for="primary_key_field" class="control-label  block"><?php echo lang('mb_form_primarykey'); ?></label>
                    <div class="controls">
                        <input name="primary_key_field" class="form-control input-medium" id="primary_key_field" type="text" value="<?php echo set_value("primary_key_field", (isset($existing_table_fields[0]) && $existing_table_fields[0]['primary_key']) ? $existing_table_fields[0]['name'] : 'id'); ?>" />
                        <span class="help-inline"><?php echo form_error('primary_key_field'); ?></span>
                    </div>
                </div>
                <div id="field_numbers" class="control-group">
                    <label class="control-label "><?php echo lang('mb_form_fieldnum'); ?></label>
                    <div class="controls">
                        <?php
                        $field_num_count = count($field_numbers);
                        $lastFieldNumIndex = $field_num_count - 1;
                        for ($ndx = 0; $ndx < $field_num_count; $ndx++) :
                        ?>
                        <a href="<?php echo site_url(SITE_AREA . '/developer/builder/create_module/' . $field_numbers[$ndx]); ?>"<?php echo $field_numbers[$ndx] == $field_total ? ' class="current"' : ''; ?>>
                            <?php echo $field_numbers[$ndx]; ?>
                        </a><?php echo $ndx < $lastFieldNumIndex ? ' | ' : ''; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </fieldset>
            <?php
            //------------------------------------------------------------------
            // Field Details
            //------------------------------------------------------------------
            ?>
            <div id="all_fields">
                <?php
                // Loop to build fields
                for ($count = 1; $count <= $field_total; $count++) :
                    $viewFieldLabel = "view_field_label{$count}";
                    $viewFieldName  = "view_field_name{$count}";
                    $viewFieldType  = "view_field_type{$count}";
                    $dbFieldType    = "db_field_type{$count}";
                    $dbFieldLength  = "db_field_length_value{$count}";
                    $validationLbl  = "validation_label{$count}";
                    $validLimitLbl  = "validation_limit_label{$count}";
                ?>
                <fieldset id="field<?php echo $count; ?>_details">
                    <legend><?php echo lang('mb_form_field_details') . " {$count}"; ?></legend>
                    <?php if ($count == 1) : ?>
                    <div class="alert alert-info fade show in">
                        <a class="close" data-dismiss="alert"></a>
                        <?php echo lang('mb_field_note'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="control-group<?php echo form_error($viewFieldLabel) ? ' has-error' : ''; ?>">
                        <label class="control-label " for="<?php echo $viewFieldLabel; ?>"><?php echo lang('mb_form_label'); ?></label>
                        <div class="controls">
                            <input class="form-control input-medium" name="<?php echo $viewFieldLabel; ?>" id="<?php echo $viewFieldLabel; ?>" type="text" value="<?php echo set_value($viewFieldLabel, isset($existing_table_fields[$count]) ? ucwords(str_replace('_', ' ', $existing_table_fields[$count]['name'])) : ''); ?>" placeholder="<?php echo lang('mb_form_label_ph'); ?>" />
                            <span class="help-inline"><?php echo form_error($viewFieldLabel); ?></span>
                        </div>
                    </div>
                    <div class="control-group<?php echo form_error($viewFieldName) ? ' has-error' : ''; ?>">
                        <label class="control-label " for="<?php echo $viewFieldName; ?>"><?php echo lang('mb_form_fieldname'); ?></label>
                        <div class="controls">
                            <input class="form-control input-medium" name="<?php echo $viewFieldName; ?>" id="<?php echo $viewFieldName; ?>" type="text" value="<?php echo set_value($viewFieldName, isset($existing_table_fields[$count]) ? $existing_table_fields[$count]['name'] : ''); ?>" maxlength="30" placeholder="<?php echo lang('mb_form_fieldname_ph'); ?>" />
                            <span class="help-inline"><?php
                                echo form_error($viewFieldName) ? form_error($viewFieldName) . '<br />' : '';
                                echo lang('mb_form_fieldname_help');
                            ?></span>
                        </div>
                    </div>
                    <?php
                    $default_field_type = 'INPUT';
                    if (isset($existing_table_fields[$count])) {
                        if (in_array($existing_table_fields[$count]['type'], $textFieldTypes)) {
                            $default_field_type = 'textarea';
                        } elseif (in_array($existing_table_fields[$count]['type'], $listFieldTypes)) {
                            $default_field_type = 'select';
                        } elseif (in_array($existing_table_fields[$count]['type'], $boolFieldTypes)) {
                            $default_field_type = 'checkbox';
                        }
             
                    }

                    echo form_dropdown($viewFieldType, $view_field_types, set_value($viewFieldType, $default_field_type), lang('mb_form_type'),"class='form-control input-medium'", '', '<span class="help-inline">' . form_error($viewFieldType) . '</span>');
                    echo form_dropdown($dbFieldType, $db_field_types, set_value($dbFieldType, isset($existing_table_fields[$count]) ? $existing_table_fields[$count]['type'] : ''), lang('mb_form_dbtype'),"class='form-control input-medium'", '', '<span class="help-inline">' . form_error($dbFieldType) . '</span>');

                    $default_max_len = '';
                    if (isset($existing_table_fields[$count])
                        && ! in_array($existing_table_fields[$count]['type'], $textFieldTypes)
                       ) {
                        $default_max_len = in_array($existing_table_fields[$count]['type'], $listFieldTypes) ? $existing_table_fields[$count]['values'] : $existing_table_fields[$count]['max_length'];
                    }
                    ?>
                    <div class="control-group <?php echo form_error($dbFieldLength) ? 'has-error' : ''; ?>">
                        <label class="control-label" for="<?php echo $dbFieldLength; ?>"><?php echo lang('mb_form_length'); ?></label>
                        <div class="controls">
                            <input class='form-control input-medium' name="<?php echo $dbFieldLength; ?>" id="<?php echo $dbFieldLength; ?>" type="text" value="<?php echo set_value($dbFieldLength, $default_max_len); ?>" placeholder="<?php echo lang('mb_form_length_ph'); ?>" />
                            <span class="help-inline"><?php echo form_error($dbFieldLength); ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" id="<?php echo $validationLbl; ?>"><?php echo lang('mb_form_rules'); ?></label>
                        <div class="controls" aria-labelledby="<?php echo $validationLbl; ?>" role="group">
                            <?php
                            echo form_error("cont_validation_rules{$count}[]");
                            foreach ($validation_rules as $validation_rule) :
                                $validationRulesRuleCount = "validation_rules_{$validation_rule}{$count}";
                                $validationRulesCount = "validation_rules{$count}[]";
                            ?>
                            <span class="faded">
                                <label class="custm-checkbox checkbox" for="<?php echo $validationRulesRuleCount; ?>">
                                    <input name="<?php echo $validationRulesCount; ?>" id="<?php echo $validationRulesRuleCount; ?>" type="checkbox" value="<?php echo $validation_rule; ?>" <?php echo set_checkbox($validationRulesCount, $validation_rule); ?> />
                                    <?php echo lang("mb_form_{$validation_rule}"); ?>
                                    <span></span>
                                </label>
                            </span>
                            <?php endforeach; ?>
                            <a class="small mb_show_advanced_rules" href="#"><em><?php echo lang('mb_form_show_more'); ?></em></a>
                        </div>
                    </div>
                    <div class="control-group mb_advanced">
                        <label class="control-label" id="<?php echo $validLimitLbl; ?>"><?php echo lang('mb_form_rules_limits'); ?></label>
                        <div class="controls" aria-labelledby="<?php echo $validLimitLbl; ?>" role="group">
                            <?php
                            foreach ($validation_limits as $validation_limit) :
                                $validationRulesLimitCount = "validation_rules_{$validation_limit}{$count}";
                                $validationRulesCount = "validation_rules{$count}[]";
                            ?>
                            <span class="faded">
                                <label class="new-cstm-rdio radio col-md-2" for="<?php echo $validationRulesLimitCount; ?>">
                                    <input name="<?php echo $validationRulesCount; ?>" id="<?php echo $validationRulesLimitCount; ?>" type="radio" value="<?php echo $validation_limit; ?>" <?php echo set_radio($validationRulesCount, $validation_limit); ?> />
                                    <?php echo lang("mb_form_{$validation_limit}"); ?>
                                    <i></i>
                                </label>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <div>
                        <h2><?php echo lang('grid_form_field_detail'); ?></h2>
                        <div class="control-group">
                            <label class="control-label" for="chkbx_1<?php echo $count; ?>"><?php echo lang('grid_form_search_label'); ?></label>
                            <div class="controls">
                                <input name="grid_search[]" type="checkbox" id="chkbx_1<?php echo $count; ?>" value="view_field_name<?php echo $count; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="chkbx_2<?php echo $count; ?>"><?php echo lang('grid_form_sort_label'); ?></label>
                            <div class="controls">
                                <input name="grid_sort[]" type="checkbox" id="chkbx_2<?php echo $count; ?>" value="view_field_name<?php echo $count; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="chkbx_3<?php echo $count; ?>"><?php echo lang('grid_form_between_label'); ?></label>
                            <div class="controls">
                                <input name="grid_between[]" type="checkbox" id="chkbx_3<?php echo $count; ?>" value="view_field_name<?php echo $count; ?>" />
                            </div>
                        </div>
                    </div>

                </fieldset>
                <?php endfor; ?>
            </div><!-- /#all_fields -->
            <fieldset class="form-actions">
                <?php
                if ($writable):
                    echo form_submit('build', lang('mb_form_build'), 'class="btn btn-primary"');
                endif;
                ?>
            </fieldset>
        <?php echo form_close(); ?>
    </div>
    </div>
</div>
<?php if (!isset($ajax)) : ?>
    <div class="admin-box m-portlet__body">
    <div class="responsive-scroll">
    <?php
    $attributes = array(
        'name' => 'admin_listing_form',
        'id' => 'admin_listing_form',
        'class'=>''
    );
    ?>
    <?php echo form_open($this->uri->uri_string() . '/index', $attributes); ?>
    <div class='grid-filters m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30'>
        <input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
        <input type="hidden" value="" name="order" id="order" class="reset-input">
        <input type="hidden" value="" name="action" id="action" class="reset-input">
        <table>
            <tr>
                <td><select name='category' class='category-dropdown reset-dropdown form-control input-medium'>
                        <option value='all'>All</option>
                        <option value='active'>Active</option>
                        <option value='inactive'>Inactive</option>
                        <option value='newest'>Newest</option>
                        <option value='oldest'>Oldest</option>
                    </select></td>
                <td> <input type='text' class='search-field reset-input form-control input-medium' rel_id='serach_filed1' name='search[title]'/></td>
                <td>
                    <select class='search-field-dropdown reset-dropdown form-control input-medium' rel='serach_filed1'>
                        <option value='title'>Title</option>
                        <option value='label'>Label</option>
                    </select>
                </td>
                <td>
                    <button type='button' class='btn submit-filters' title='Find' data-original-title=''>Find</button>&nbsp;
                </td>
                <td>
                    <button type='button' class='btn reset-filters' title='Reset' data-original-title=''>Reset</button>&nbsp;
                </td>
                <td>
                    <?php if ($this->auth->has_permission('Email_Template.Settings.Delete')) : ?>
                        <button type='button' class='btn delete-selected btn-danger' title='Delete Selected'
                                data-original-title=''>Delete Selected
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="m_datatable m-datatable m-datatable--default m-datatable--brand m-datatable--loaded" id="table_content">
<?php endif; ?>
    <table class="m-datatable__table">
        <thead class="m-datatable__head">
        <tr class="m-datatable__row">
            <?php if ($this->auth->has_permission('Email_Template.Settings.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                <th class="column-check m-datatable__cell--center m-datatable__cell m-datatable__cell--check"><span><label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand"><input class="check-all" type="checkbox"/>&nbsp;<span></span></label></span></th>
            <?php endif; ?>
            <th class="m-datatable__cell m-datatable__cell--sort sorting">
                <span>Title
                    <i class="la la-arrow-down sort" rel="desc" for="title" title="Desc"></i>
                    <i class="la la-arrow-up sort" rel="asc" for="title" title="Asc"></i>
                    <!--<i class="icon-arrow-up sort" rel="asc" for="title" title="Asc" effect="tooltip"></i>
                    <i class="icon-arrow-down sort" rel="desc" for="title" title="Desc" effect="tooltip"></i>-->
                </span>
            </th>
            <th class="m-datatable__cell m-datatable__cell--sort sorting">
                <span>Label
                <i class="la la-arrow-down sort" rel="desc" for="label" title="Desc"></i>
                <i class="la la-arrow-up sort" rel="asc" for="label" title="Asc"></i>
               <!-- <i class="icon-arrow-up sort" rel="asc" for="label" title="Asc" effect="tooltip"></i>
                <i class="icon-arrow-down sort" rel="desc" for="label" title="Desc" effect="tooltip"></i>-->
                </span>
            </th>
            <th class="m-datatable__cell m-datatable__cell--sort"><span>Created</span></th>
            <th class="m-datatable__cell m-datatable__cell--sort"><span>Status</span></th>
            <?php if ($this->auth->has_permission('Email_Template.Settings.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                <th class="m-datatable__cell m-datatable__cell--sort"><span>Actions</span></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody class="m-datatable__body">
        <?php if (isset($records) && is_array($records) && count($records)) : ?>
            <?php foreach ($records as $record) : ?>
                <tr class="m-datatable__row">
                    <?php if ($this->auth->has_permission('Email_Template.Settings.Delete')) : ?>
                        <td class="column-check m-datatable__cell--center m-datatable__cell m-datatable__cell--check"><span><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>"/><span></span></label></span></td>
                    <?php endif; ?>

                    <td class="m-datatable__cell"><span><?php echo $record->title ?></span></td>

                    <td class="m-datatable__cell"><span><?php echo $record->label ?></span></td>
                    <td class="m-datatable__cell"><span>
                        <?php
                        $created_date = new DateTime($record->created_on);
                        echo $created_date->format("d M Y, H:i A");
                        ?>
                            </span>
                    </td>

                    <?php
                    if ($record->status == 1) {
                        $status = "Active";
                        $btn_status = "Inactive";
                        $class = "success";
                    } else {
                        $status = "Inactive";
                        $btn_status = "Active";
                        $class = "warning";
                    }
                    ?>
                    <td class="m-datatable__cell"><span style="cursor: pointer;" class="badge badge-<?php echo $class; ?> toggle_status" rel_id="<?php echo $record->id; ?>"><?php echo $status ?></span></td>
                    <td>
                        <?php if ($this->auth->has_permission('Email_Template.Settings.Edit')) : ?>
                            <?php echo anchor(SITE_AREA . '/settings/email_template/edit/' . $record->id, '<i class="glyphicon glyphicon-edit" title="Edit" effect="tooltip">&nbsp;</i>') ?>&nbsp;&nbsp;
                        <?php endif; ?>
                        <?php if ($this->auth->has_permission('Email_Template.Settings.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                            <span style="cursor: pointer;" class="delete" data-original-title="" title=""
                                  rel="<?php echo $record->id; ?>"><i class="glyphicon glyphicon-trash" title="Delete"
                                                                      effect="tooltip">&nbsp;</i></span>&nbsp;&nbsp;
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="m-datatable__row">
                <td class="m-datatable__cell">No records found that match your selection.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
<?php
if (isset($pagination)) {
    echo $pagination;
}
?>
<?php if (!isset($ajax)) : ?>
    </div>
    <?php echo form_close(); ?>
    </div>
    </div>
<?php endif; ?>
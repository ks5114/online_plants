<?php if (!isset($ajax)) : ?>
<div class="admin-box">
    <?php
    $attributes = array(
        'name' => 'admin_listing_form',
        'id' => 'admin_listing_form'
    );
    ?>
    <?php echo form_open($this->uri->uri_string() . '/index', $attributes); ?>
    <div class='grid-filters'>
        <input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
        <input type="hidden" value="" name="order" id="order" class="reset-input">
        <input type="hidden" value="" name="action" id="action" class="reset-input">
        <table>
            <tr>
                <td><select name='category' class='category-dropdown form-control input-small reset-dropdown'>
                        <option value='all'>All</option>
                        <option value='active'>Active</option>
                        <option value='inactive'>Inactive</option>
                        <option value='newest'>Newest</option>
                        <option value='oldest'>Oldest</option>
                    </select></td>&nbsp;
                <td>&nbsp;</td>
                <td><input type='text' class='search-field reset-input form-control' rel_id='serach_filed1'
                           name='search[page_title]'/></td>
                <td>&nbsp;</td>
                <td>
                    <select class='search-field-dropdown reset-dropdown form-control input-small' rel='serach_filed1'>
                        <option value='page_title'>Page Title</option>
                    </select>  </td> &nbsp;
                <td>&nbsp;</td>
                <td>
                    <button type='button' class='btn submit-filters' title='Find' data-original-title=''>Find</button>&nbsp;</td>
                <td>
                    <button type='button' class='btn reset-filters' title='Reset' data-original-title=''>Reset</button>&nbsp;</td>
                <td>
                    <?php if ($this->auth->has_permission('Pages.Master.Delete')) : ?>
                        <button type='button' class='btn delete-selected btn-danger' title='Delete Selected'
                                data-original-title=''>Delete Selected
                        </button>
                    <?php endif; ?>
                    &nbsp;</td>
            </tr>
        </table>
    </div>


    <div id="table_content">
        <?php endif; ?>
        <table class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
            <tr>
                <?php if ($this->auth->has_permission('Pages.Master.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                    <th class="column-check"><input class="check-all" type="checkbox"/></th>
                <?php endif; ?>

                <th>Page <i class="icon-arrow-up sort" rel="asc" for="page_title" title="Asc" effect="tooltip"></i>
                    <i class="icon-arrow-down sort" rel="desc" for="page_title" title="Desc" effect="tooltip"></i></th>
                <!--<th>Page Slug</th>
                <th>Page Content</th>
                <th>Created</th>
                <th>Modified</th>-->
                <th>Created</th>
                <th width="10%">Status</th>
                <?php if ($this->auth->has_permission('Pages.Master.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                    <th width="10%">Actions</th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>
            <?php if (isset($records) && is_array($records) && count($records)) : ?>
                <?php foreach ($records as $record) : ?>
                    <tr>

                    <?php if ($this->auth->has_permission('Pages.Master.Delete')) : ?>
                        <td><input type="checkbox" name="checked[]" value="<?php echo $record->id ?>"/></td>
                    <?php endif; ?>

                    <td><?php echo $record->page_title ?></td>

                    <td><?php
                        $created_date = new DateTime($record->created_on);
                        echo $created_date->format("d M Y, H:i A");
                        ?>
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
                    <td><span style="cursor: pointer;" class="badge badge-<?php echo $class; ?> toggle_status"
                              rel_id="<?php echo $record->id; ?>"><?php echo $status ?></span></td>
                    <td>
                        <a class="fancybox fancybox.iframe"
                           href="<?php echo site_url() . 'pages/index/' . $record->id; ?>"><i class="icon-eye-open"
                                                                                              title="Preview"
                                                                                              title="View"
                                                                                              effect="tooltip">
                                &nbsp;</i></a>&nbsp;&nbsp;
                        <?php if ($this->auth->has_permission('Pages.Master.Edit')) : ?>
                            <?php echo anchor(SITE_AREA . '/master/pages/edit/' . $record->id, '<i class="glyphicon glyphicon-edit" title="Edit" effect="tooltip">&nbsp;</i>') ?>&nbsp;&nbsp;
                        <?php endif; ?>
                        <?php if ($this->auth->has_permission('Pages.Master.Delete') && isset($records) && is_array($records) && count($records)) : ?>
                            <span style="cursor: pointer;" class="delete" data-original-title="" title=""
                                  rel="<?php echo $record->id; ?>"><i
                                    class="glyphicon glyphicon-trash" title="Delete" effect="tooltip">&nbsp;</i></span>&nbsp;&nbsp;
                        <?php endif; ?>
                    </td>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No records found that match your selection.</td>
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
<?php endif; ?>

  
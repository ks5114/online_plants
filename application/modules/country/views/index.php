<?php

$hiddenFields = array('id', 'deleted', 'deleted_by', 'created_by', 'modified_by',);
?>
<h1 class='page-header'>
    <?php echo lang('country_area_title'); ?>
</h1>
<?php if (isset($records) && is_array($records) && count($records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            
            <th>Country Code</th>
            <th>Country Name</th>
            <th><?php echo lang('country_column_created'); ?></th>
            <th><?php echo lang('country_column_modified'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($records as $record) :
        ?>
        <tr>
            <?php
            foreach($record as $field => $value) :
                if ( ! in_array($field, $hiddenFields)) :
            ?>
            <td>
                <?php
                if ($field == 'deleted') {
                    e(($value > 0) ? lang('country_true') : lang('country_false'));
                } else {
                    e($value);
                }
                ?>
            </td>
            <?php
                endif;
            endforeach;
            ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php

    echo $this->pagination->create_links();
endif; ?>
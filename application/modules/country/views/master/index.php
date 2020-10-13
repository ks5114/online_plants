<?php
$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Country.Master.Delete');
$can_edit		= $this->auth->has_permission('Country.Master.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
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
	<?php echo form_open($this->uri->uri_string().'/index', $attributes); ?>
	<div id='ajax_loader' style="display:none;"><p>Please Wait..</p></div>
	<!--begin: Search Form -->
	<div class="grid-filters m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
				<input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
                <input type="hidden" value="" name="order" id="order" class="reset-input">
                <input type="hidden" value="" name="action" id="action" class="reset-input">
		<!-- <table>
			<tbody>
			   <tr>
				   <td>
					   <div class="m-input-icon m-input-icon--left">
						   <input type="text" class="search-field reset-input form-control m-input" rel_id='serach_filed1' name='search[country_name]' placeholder="Search..." id="generalSearch">
								<span class="m-input-icon__icon m-input-icon__icon--left">
									<span><i class="la la-search"></i></span>
								</span>
					   </div>
				   </td>
				   <td>
					   <div class="dropdown bootstrap-select">
						   <select class="search-field-dropdown reset-dropdown selectpicker" rel='serach_filed1' >
						   		<option value='country_name'>Country Name</option>
						   </select>
					   </div>
				   </td>
				   <td><button type='button' class='btn submit-filters' title='Find' data-original-title=''>Find</button></td>
				   <td><button type='button' class='btn reset-filters' title='Reset' data-original-title=''>Reset</button></td>
				   <td><?php //if ($can_delete) : ?>
						   <button type='button' class='btn delete-selected btn-danger' title='Delete Selected' data-original-title=''>Delete Selected</button>
					   <?php //endif; ?>
				   </td>
			   </tr>
			</tbody>
		</table> -->

		<table>
			<tbody>
			   <tr>
				   <td>
						<input type="text" class="search-field reset-input form-control m-input" rel_id='serach_filed1' name='search[country_code]' placeholder="Country Code" filter-type="country_code">
				   </td>
				   <td>
						<input type="text" class="search-field reset-input form-control m-input" rel_id='serach_filed1' name='search[country_name]' placeholder="Country Name" filter-type="country_name">
					</td>
					<td>
						<input type="text" class="search-field reset-input form-control m-input" rel_id='serach_filed1' name='search[deleted]' placeholder="Deleted" filter-type="deleted">
					</td>
					<td><?php if ($can_delete) : ?>
						   <button type='button' class='btn delete-selected btn-danger' title='Delete Selected' data-original-title=''>Delete Selected</button>
					   <?php endif; ?>
				   </td>
			   </tr>
			</tbody>
		</table>
	</div>
	<div class="m_datatable m-datatable m-datatable--default m-datatable--brand m-datatable--loaded" id='table_content'>
		<?php endif; ?>
		<table class="m-datatable__table">
			<thead class="m-datatable__head">
				<tr class="m-datatable__row">
				<?php if ($can_delete && $has_records) : ?>
				<th class="column-check m-datatable__cell--center m-datatable__cell m-datatable__cell--check"><span><label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand"><input  class='check-all' type="checkbox">&nbsp;<span></span></label></span></th>
				<?php endif;?>
				
				<th class="m-datatable__cell m-datatable__cell--sort"><span><?php echo lang('country_field_country_code'); ?></span></th>
				<th class="m-datatable__cell m-datatable__cell--sort sorting"><span><?php echo lang('country_field_country_name'); ?><i class="la la-arrow-down sort" rel="desc" for="country_name" title="Desc"></i><i class="la la-arrow-up sort" rel="asc" title="Asc"></i></span></th>
				<th class="m-datatable__cell m-datatable__cell--sort"><span><?php echo lang('country_column_deleted'); ?></span></th>
				<th class="m-datatable__cell m-datatable__cell--sort"><span><?php echo lang('country_column_created'); ?></span></th>
				<th class="m-datatable__cell m-datatable__cell--sort"><span><?php echo lang('country_column_modified'); ?></span></th>
				<th class="m-datatable__cell m-datatable__cell--sort"><span>Status</span></th>
				<th class="m-datatable__cell m-datatable__cell--sort"><span>Action</span></th>
				
				</tr>
			</thead>
			
			<tbody class="m-datatable__body">
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr class="m-datatable__row">
					<?php if ($can_delete) : ?>
					<td class="column-check m-datatable__cell--center m-datatable__cell m-datatable__cell--check"><span><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /><span></span></label></span></td>
					<?php endif;?>
					<td class="m-datatable__cell"><span><?php e($record->country_code); ?></span></td>
					<td class="m-datatable__cell--sorted m-datatable__cell"><span><?php e($record->country_name); ?></span></td>
					<td class="m-datatable__cell"><span><?php echo $record->deleted > 0 ? lang('country_true') : lang('country_false'); ?></span></td>
					<td class="m-datatable__cell"><span><?php echo show_formatted_date($record->created_on); ?></span></td>
					<td class="m-datatable__cell"><span><?php echo show_formatted_date($record->modified_on); ?></span></td>
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
					<td class="m-datatable__cell"><span><span class="m-badge  m-badge--primary m-badge--wide toggle_status" rel_id="<?php echo $record->id; ?>"><?php echo $status ?></span></span></td>
					
					<td class="m-datatable__cell"><span>
					<?php echo anchor(SITE_AREA .'/master/country/edit/'.$record->id, '<i class="la la-edit" title="Edit"></i>', array('class'=>'m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill')) ?>
					<!-- <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a> -->
					<a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete" title="Delete" rel="<?php echo $record->id;  ?>"><i class="la la-trash"></i></a></span></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td class="m-datatable__cell" colspan='<?php echo $num_columns; ?>'><span><?php echo lang('country_records_empty'); ?></span></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<?php if ($has_records)  : ?>

			<?php if ($can_delete) : ?>
				<div class="m-datatable m-datatable--default">
					<?php
					if (isset($pagination)) {
						echo $pagination;
					}
					?>
				</div>
			<?php endif; ?>

		<?php endif; ?>
	</div>
		
		<?php if (!isset($ajax)) : ?>
		<?php echo form_close(); ?>
	</div>
	<?php endif; ?>
	<!--end: Datatable -->
</div>

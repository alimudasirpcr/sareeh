<?php if ($row == 0) : ?>
	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['serial_number'] ? $serial_item_number['serial_number'] : lang('empty'), array('data-value' => H($serial_item_number['serial_number']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'text', 'data-name' => 'serial_number', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable serial_numbers_check', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>
	<span class="error_message text-danger"></span>
<?php elseif ($row == 1) : ?>

	<div class="form-check form-check-custom form-check-solid">
		<?php
		echo form_checkbox(array(
			'name' => 'add_to_inventory[' . $serial_item_number['id'] . ']',
			'id' => 'add_to_inventory' . $serial_item_number['id'],
			'class' => 'add_to_inventory  form-check-input',
			'value' => 1
		));
		?>
		<label class="form-check-label" for="add_to_inventory<?php echo $serial_item_number['id']; ?>"><span></span></label>




	</div>

<?php elseif ($row == 2) : ?>



	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['replace_sale_date'] ? lang('Yes') : lang('No'), array('data-value' => H($serial_item_number['replace_sale_date']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'select', 'id' => 'replace_sale_date' . $serial_item_number['id'] . '', 'data-name' => 'replace_sale_date', 'data-pk' => $serial_item_number['id'], 'class' => ' ', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>

	<?php
	$source_data = array();
	$source_data[] = array(
		'value' => 1, 'text' => lang('yes')
	);
	$source_data[] = array(
		'value' => 0, 'text' => lang('no')
	);

	?>
	<script>
		$('#replace_sale_date<?php echo $serial_item_number['id']; ?>').editable({
			source: <?php echo json_encode($source_data); ?>
		});
	</script>



<?php elseif ($row == 3) : ?>
	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['cost_price']  !== NULL ? to_currency_no_money($serial_item_number['cost_price']) : lang('empty'), array('data-value' => H($serial_item_number['cost_price']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'text', 'data-name' => 'cost_price', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>

<?php elseif ($row == 4) : ?>
	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['unit_price']  !== NULL ? to_currency_no_money($serial_item_number['unit_price']) : lang('empty'), array('data-value' => H($serial_item_number['unit_price']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'text', 'data-name' => 'unit_price', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>

<?php elseif ($row == 5) : ?>
	<?php
	$item_var_options = array('' => lang('none'));
	$selected_val = lang('none');
	foreach ($item_variations as $item_variation_id => $item_variation) {

		$item_var_options[$item_variation_id] = array(
			$item_variation['name'] ?   $item_variation['name'] : implode(', ', array_column($item_variation['attributes'], 'label'))
		);

		if ($serial_item_number['variation_id'] == $item_variation_id) {
			$selected_val = $item_variation['name'] ?   $item_variation['name'] : implode(', ', array_column($item_variation['attributes'], 'label'));
		}
	}
	?>

	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['variation_id'] ? $selected_val : lang('none'), array('data-value' => H($selected_val), 'data-id' => H($serial_item_number['id']), 'data-type' => 'select', 'id' => 'variation_id' . $serial_item_number['id'] . '', 'data-name' => 'variation_id', 'data-pk' => $serial_item_number['id'], 'class' => ' ', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>

	<?php


	?>
	<script>
		$('#variation_id<?php echo $serial_item_number['id']; ?>').editable({
			source: <?php echo json_encode($item_var_options); ?>
		});
	</script>
<?php elseif ($row == 6) : ?>
	<?php
	$serial_locations = array('' => lang('all'));

	//Get all locations
	foreach ($locations as $location) {
		$serial_locations[$location->location_id] = $location->name;
	}

	//echo form_dropdown("serial_locations[".$serial_item_number['id']."]", $serial_locations,$serial_item_number['serial_location_id'], 'class="form-control"');

	?>

<?php elseif ($row == 7) : ?>
	<?php
	$serial_locations = array('' => lang('all'));
	$selected_val = lang('all');
	foreach ($locations as $location) {

		$serial_locations[$location->location_id] = array(
			$location->name
		);

		if ($serial_item_number['serial_location_id'] == $location->location_id) {
			$selected_val = $location->name;
		}
	}
	?>

	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['serial_location_id'] ? $selected_val : lang('all'), array('data-value' => H($selected_val), 'data-id' => H($serial_item_number['id']), 'data-type' => 'select', 'id' => 'serial_location_id' . $serial_item_number['id'] . '', 'data-name' => 'serial_location_id', 'data-pk' => $serial_item_number['id'], 'class' => ' ', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>

	<?php


	?>
	<script>
		$('#serial_location_id<?php echo $serial_item_number['id']; ?>').editable({
			source: <?php echo json_encode($serial_locations); ?>
		});
	</script>
<?php elseif ($row == 8) : ?>
	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['warranty_start']  ? $serial_item_number['warranty_start'] : lang('empty'), array('data-value' => H($serial_item_number['warranty_start']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'date', 'data-name' => 'warranty_start', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>
<?php elseif ($row == 9) : ?>

	<?php
	echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['warranty_end']  ? $serial_item_number['warranty_end'] : lang('empty'), array('data-value' => H($serial_item_number['warranty_end']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'date', 'data-name' => 'warranty_end', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	?>


<?php elseif ($row == 10) : ?>

	<td class="text-end">
		<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"><?php echo lang('actions'); ?>
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
			<span class="svg-icon svg-icon-5 m-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
				</svg>
			</span>
			<!--end::Svg Icon--></a>
		<!--begin::Menu-->
		<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="">
			<!--begin::Menu item-->
			<div class="menu-item px-3">
				<a data-id="<?= $serial_item_number['id'] ?>" href="#" class="menu-link px-3 show_log"><?php echo lang('view_log'); ?></a>
			</div>
			<!--end::Menu item-->
			<!--begin::Menu item-->
			<div class="menu-item px-3">
				<a data-serial-number="<?php echo H($serial_item_number['serial_number']); ?>" class="delete_serial_number menu-link px-3" href="#"><?php echo lang('delete'); ?></a>
			</div>

			<!--end::Menu item-->
		</div>
		<!--end::Menu-->

		<div class="form-check form-check-sm form-check-custom form-check-solid me-3"><input class="form-check-input edit" type="checkbox" id="item_<?= $serial_item_number['id'] ?>" value="<?= $serial_item_number['id'] ?>"> <label for="item_<?= $serial_item_number['id'] ?>"><span></span></label></div>
	</td>

<?php endif ?>


<?php
$data = []; // Initialize data array

foreach ($serial_numbers as $serial_item_number) {
    $row = []; // Initialize row for each serial number

    // Section 1: Serial Number Edit
    ob_start();
    echo anchor('items/sn_number_edit/' . $serial_item_number['id'], 
                $serial_item_number['serial_number'] ? $serial_item_number['serial_number'] : lang('empty'), 
                [
                    'data-value' => H($serial_item_number['serial_number']), 
                    'data-id' => H($serial_item_number['id']), 
                    'data-type' => 'text', 
                    'data-name' => 'serial_number', 
                    'data-pk' => $serial_item_number['id'], 
                    'class' => 'xeditable serial_numbers_check', 
                    'data-title' => lang('edit'), 
                    'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])
                ]);
    echo '<span class="error_message text-danger"></span>';
    $row[0] = ob_get_clean();

    // Section 2: Add to Inventory Checkbox
    ob_start();
    ?>
    <div class="form-check form-check-custom form-check-solid">
        <?php
        echo form_checkbox([
            'name' => 'add_to_inventory[' . $serial_item_number['id'] . ']',
            'id' => 'add_to_inventory' . $serial_item_number['id'],
            'class' => 'add_to_inventory form-check-input',
            'value' => 1
        ]);
        ?>
        <label class="form-check-label" for="add_to_inventory<?= $serial_item_number['id']; ?>"><span></span></label>
    </div>
    <?php
    $row[1] = ob_get_clean();

    // Assuming similar structure for sections 3 to 7, capturing HTML content

	  // Section 3: Replace Sale Date Edit
	  ob_start();
	  echo anchor('items/sn_number_edit/' . $serial_item_number['id'], 
				  $serial_item_number['replace_sale_date'] ? lang('Yes') : lang('No'), 
				  [
					  'data-value' => H($serial_item_number['replace_sale_date']), 
					  'data-id' => H($serial_item_number['id']), 
					  'data-type' => 'select', 
					  'id' => 'replace_sale_date' . $serial_item_number['id'], 
					  'data-name' => 'replace_sale_date', 
					  'data-pk' => $serial_item_number['id'], 
					  'class' => '', 
					  'data-title' => lang('edit'), 
					  'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])
				  ]);
	  ?>
	  <script>
		  $('#replace_sale_date<?= $serial_item_number['id']; ?>').editable({
			  source: [
				  {value: 1, text: '<?= lang("yes"); ?>'},
				  {value: 0, text: '<?= lang("no"); ?>'}
			  ]
		  });
	  </script>
	  <?php
	  $row[2] = ob_get_clean();

	  ob_start();
	  echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['cost_price']  !== NULL ? to_currency_no_money($serial_item_number['cost_price']) : lang('empty'), array('data-value' => H($serial_item_number['cost_price']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'text', 'data-name' => 'cost_price', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));
	  $row[3] = ob_get_clean();
	  ob_start();

	  echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['unit_price']  !== NULL ? to_currency_no_money($serial_item_number['unit_price']) : lang('empty'), array('data-value' => H($serial_item_number['unit_price']), 'data-id' => H($serial_item_number['id']), 'data-type' => 'text', 'data-name' => 'unit_price', 'data-pk' => $serial_item_number['id'], 'class' => 'xeditable', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));

	  $row[4] = ob_get_clean();
	  ob_start();
	  $item_var_options = array('' => lang('none'));
	  $selected_val = lang('none');
	  foreach ($item_variations as $item_variation_id => $item_variation) {
  
		  $item_var_options[$item_variation_id] = array(
			  $item_variation['name'] ?   $item_variation['name'] : implode(', ', array_column($item_variation['attributes'], 'label'))
		  );
  
		  if ($serial_item_number['variation_id'] == $item_variation_id) {
			  $selected_val = $item_variation['name'] ?   $item_variation['name'] : implode(', ', array_column($item_variation['attributes'], 'label'));
		  }
	  }
	  ?>
  
	  <?php
	  echo anchor('items/sn_number_edit/' . $serial_item_number['id'], $serial_item_number['variation_id'] ? $selected_val : lang('none'), array('data-value' => H($selected_val), 'data-id' => H($serial_item_number['id']), 'data-type' => 'select', 'id' => 'variation_id' . $serial_item_number['id'] . '', 'data-name' => 'variation_id', 'data-pk' => $serial_item_number['id'], 'class' => ' ', 'data-title' => lang('edit'), 'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])));
   ?>
   	<script>
				$('#variation_id<?php echo $serial_item_number['id']; ?>').editable({
					source: <?php echo json_encode($item_var_options); ?>
				});
			</script>
			<?php
	
	  $row[5] = ob_get_clean();

	  ob_start();
	  $row[6] = ob_get_clean();
    // Section 8: Warranty Start Edit
    ob_start();
    echo anchor('items/sn_number_edit/' . $serial_item_number['id'], 
                $serial_item_number['warranty_start'] ? $serial_item_number['warranty_start'] : lang('empty'), 
                [
                    'data-value' => H($serial_item_number['warranty_start']), 
                    'data-id' => H($serial_item_number['id']), 
                    'data-type' => 'date', 
                    'data-name' => 'warranty_start', 
                    'data-pk' => $serial_item_number['id'], 
                    'class' => 'xeditable', 
                    'data-title' => lang('edit'), 
                    'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])
                ]);
    $row[7] = ob_get_clean();

    // Section 9: Warranty End Edit
    ob_start();
    echo anchor('items/sn_number_edit/' . $serial_item_number['id'], 
                $serial_item_number['warranty_end'] ? $serial_item_number['warranty_end'] : lang('empty'), 
                [
                    'data-value' => H($serial_item_number['warranty_end']), 
                    'data-id' => H($serial_item_number['id']), 
                    'data-type' => 'date', 
                    'data-name' => 'warranty_end', 
                    'data-pk' => $serial_item_number['id'], 
                    'class' => 'xeditable', 
                    'data-title' => lang('edit'), 
                    'data-url' => site_url('items/sn_number_edit/' . $serial_item_number['id'])
                ]);
    $row[8] = ob_get_clean();

    // Actions and Additional Info (Assuming this is the final section)
    ob_start();
    ?>
    <td class="text-end">
        <!-- Actions Dropdown Trigger -->
        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <?php echo lang('actions'); ?>
            <span class="svg-icon svg-icon-5 m-0">
                <!-- SVG Icon content -->
            </span>
        </a>
        <!-- Actions Dropdown Menu -->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3 show_log" data-id="<?= H($serial_item_number['id']); ?>">
                    <?php echo lang('view_log'); ?>
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="delete_serial_number menu-link px-3" data-serial-number="<?= H($serial_item_number['serial_number']); ?>">
                    <?php echo lang('delete'); ?>
                </a>
            </div>
        </div>
        <!-- Checkbox for Edit -->
        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
            <input class="form-check-input edit" type="checkbox" id="item_<?= H($serial_item_number['id']); ?>" value="<?= H($serial_item_number['id']); ?>">
            <label for="item_<?= H($serial_item_number['id']); ?>"><span></span></label>
        </div>
    </td>
    <?php
    $row[9] = ob_get_clean();

    $data[] = $row; // Add the row to the data array
}

// After completing the loop, $data is ready for further processing or output.
?>

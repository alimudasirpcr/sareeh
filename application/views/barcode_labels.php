<?php $this->load->view("partial/header");
$barcode_width 		= $this->input->get('barcode_width') ? $this->input->get('barcode_width') : ($this->config->item('barcode_width') ? $this->config->item('barcode_width') : 1.9);
$barcode_height 	= $this->input->get('barcode_height') ? $this->input->get('barcode_height') : ($this->config->item('barcode_height') ? $this->config->item('barcode_height') : .79);
$scale 				= $this->input->get('scale') ? $this->input->get('scale') : ($this->config->item('scale') ? $this->config->item('scale') : 1);
$thickness 			= $this->input->get('thickness') ? $this->input->get('thickness') : ($this->config->item('thickness') ? $this->config->item('thickness') : 30);
$font_size 			= $this->input->get('font_size') ? $this->input->get('font_size') : ($this->config->item('font_size') ? $this->config->item('font_size') : 13);
$overall_font_size 	= $this->input->get('overall_font_size') ? $this->input->get('overall_font_size') : ($this->config->item('overall_font_size') ? $this->config->item('overall_font_size') : 10);

if (isset($font_enlarge)) {
	$font_size = 16;
}
?>
<style>
	@page {
		margin: 0 !important;
		padding: 0 !important;
	}

	@media print {
		.wrapper {
			overflow: visible;
			font-family: serif !important;
		}
	}

	.barcode-label {
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
		width: <?php echo $barcode_width; ?>in;
		height: <?php echo $barcode_height; ?>in;
		letter-spacing: normal;
		word-wrap: break-word;
		overflow: hidden;
		margin: 0 auto;
		text-align: center;
		padding: 10px;
		font-size: <?php echo $overall_font_size; ?>pt;
		line-height: .9em;
		font-family: serif !important;
	}

	.item-price-barcode {
		font-size: 115%;
	}
</style>
<div class="card hidden-print ">
	<div class="card-body">
		<div class="hidden-print" style="text-align: center;margin-top: 20px;">
		<div class="fv-row mb-7 fv-plugins-icon-container px-5">
			<?php
			$labels_saved = $this->Appconfig->get_barcoded_labels()->result_array();
			?>
			<select id="saved_barcoded_labels" class="form-control w-25">
				<option value="">--<?php echo H(lang('load_saved_value')); ?>--</option>
				<?php
				foreach ($labels_saved as $label_saved) {
					$label_settings = unserialize($label_saved['value']);
					echo "<option value='" . H(json_encode($label_settings)) . "'>" . $label_settings['saved_name'] . "</option>";
				}
				?>
			</select>

		</div>
			<form method="get" action="<?php echo site_url('home/save_barcode_settings'); ?>" id="barcode_form">
				<div class="row">
					<div class="col-md-12 ">
						<div class=" ">

							<div class="col-md-6">
								<?php echo form_label(lang('items_overall_barcode_width') . ':', 'barcode_width', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'barcode_width',
										'id' => 'barcode_width',
										'class' => 'form-control form-inps',
										'value' => $barcode_width
									)
								); ?>
							</div>

							<div class="col-md-6">
								<?php echo form_label(lang('items_overall_barcode_height') . ':', 'barcode_height', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'barcode_height',
										'id' => 'barcode_height',
										'class' => 'form-control form-inps',
										'value' => $barcode_height
									)
								); ?>
							</div>

							<div class="col-md-6">
								<?php echo form_label(lang('items_overall_font_size') . ':', 'overall_font_size', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'overall_font_size',
										'id' => 'overall_font_size',
										'class' => 'form-control form-inps',
										'value' => $overall_font_size
									)
								); ?>
							</div>

							<div class="col-md-6">
								<?php echo form_label(lang('items_barcode_image_width') . ':', 'scale', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'scale',
										'id' => 'scale',
										'class' => 'form-control form-inps',
										'value' => $scale
									)
								); ?>
							</div>


							<div class="col-md-6">
								<?php echo form_label(lang('items_barcode_image_height') . ':', 'thickness', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'thickness',
										'id' => 'thickness',
										'class' => 'form-control form-inps',
										'value' => $thickness
									)
								); ?>
							</div>

							<div class="col-md-6">
								<?php echo form_label(lang('items_barcode_image_font_size') . ':', 'font_size', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'font_size',
										'id' => 'font_size',
										'class' => 'form-control form-inps',
										'value' => $font_size
									)
								); ?>
							</div>

							<div class="col-md-6">
								<?php echo form_label(lang('items_zerofill_barcode') . ':', 'zerofill_barcode', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'zerofill_barcode',
										'id' => 'zerofill_barcode',
										'class' => 'form-control form-inps',
										'value' => $this->config->item('zerofill_barcode') ? $this->config->item('zerofill_barcode') : 10
									)
								); ?>
							</div>
							<div class="col-md-6">
								<?php echo form_label(lang('save_above_values_name') . ':', 'saved_name', array('class' => 'form-label w-100 text-left')); ?>

								<?php echo form_input(
									array(
										'name' => 'saved_name',
										'id' => 'saved_name',
										'class' => 'form-control form-inps',
										'value' => ''
									)
								); ?>
							</div>


						</div>
						<input type="submit" class="btn btn-lg btn-primary btn-sm w-100px pull-right my-3" value="<?= lang("submit"); ?>">
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
	if (isset($excel_url) && $excel_url) {
	?>
		<form action="<?php echo $excel_url; ?>" method="POST" class="d-flex justify-content-center mb-2">
			<br />
			<?php



			if ($this->input->post('item_id')) {
				echo form_hidden('item_id', $this->input->post('item_id'));
			}

			if ($this->input->post('items_number_of_barcodes')) {
				echo form_hidden('items_number_of_barcodes', $this->input->post('items_number_of_barcodes'));
			}

			if ($this->input->post('item_variations_number_of_barcodes')) {
				foreach ($this->input->post('item_variations_number_of_barcodes') as $var_id => $qty) {
					echo form_hidden('item_variations_number_of_barcodes[' . $var_id . ']', $qty);
				}
			}
			?>
			<input type="submit" class="btn btn-success btn-sm hidden-print" value="<?php echo lang('excel_export'); ?>">
		<?php
	}
		?>
		</form>

		<div class="d-flex justify-content-center mb-3 gap-1">
			<a class="btn btn-danger text-white hidden-print btn-sm w-200px" id="reset_labels" href="<?php echo site_url('home/reset_barcode_labels'); ?>"><?php echo lang('items_reset_labels'); ?></a>
  <?php if(isset($work_order)){ ?>
	<a class="btn btn-primary text-white hidden-print btn-sm w-100px " target="_blank" href="<?php echo site_url() ; ?>work_orders/print_service_tag_print/<?php echo $this->uri->segment(3); ?>" ><?php echo lang('print'); ?></a>
	<?php 
  }else{ ?>
	<a class="btn btn-primary text-white hidden-print btn-sm w-100px " target="_blank" href="<?php echo site_url() ; ?>items/generate_barcode_labels_print/<?php echo $this->uri->segment(3); ?>" ><?php echo lang('print'); ?></a>
	<?php 
  } ?>

			</div>
</div>
<div id="receipt_wrapper_inner" class="main-content">
<?php
$company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');

for ($k = 0; $k < count($items); $k++) {
	$customer_name = "";
	if (isset($customers) && array_key_exists($k, $customers)) {
		$customer_name = $customers[$k]['customer_name'];
	}
	// customer phone 
	$customer_phone = "";
	if (isset($customers) && array_key_exists($k, $customers)) {
		$customer_phone = $customers[$k]['customer_phone'];
	}

	$item 			= $items[$k];
	$expire_key 	= (isset($from_recv) ? $from_recv : 0) . '|' . ltrim($item['id'], 0);
	$barcode 		= $item['id'];
	$text 			= $item['name'];
	$description 	= $item['description'];

	// Check Store Config to see if Show Description on Service Tag is enabled or not 
	if ($this->config->item('show_item_description_service_tag') && $this->uri->segment(1) == 'work_orders') {
		$text .= ' <br> ' . $description;
	}
	// Check Store Config to see if Show Show Custom Fields on Service Tag is enabled or not 
	if ($this->config->item('show_custom_fields_service_tag_work_orders')) {
		if (isset($item['custom_fields'])) {
			if ($this->config->item('show_custom_fields_label_service_tag_work_orders')) {
				$text .= '<br>' . implode('<br> ', $item['custom_fields']);
			} else {
				$text .= '<br> ' . implode(', ', $item['custom_fields']);
			}
		}
	}

	if ($this->config->item('show_estimated_repair_date_on_service_tag_work_orders')) {
		if (isset($item['estimated_repair_date'])) {
			$text .= '<br>' . $item['estimated_repair_date'];
		}
	}

	if (!$this->config->item('hide_expire_date_on_barcodes') && isset($items_expire[$expire_key]) && $items_expire[$expire_key] && !$this->config->item('hide_name_on_barcodes')) {
		$text .= " (" . lang('expire_date') . ' ' . $items_expire[$expire_key] . ')';
	} elseif (isset($from_recv) && !$this->config->item('hide_name_on_barcodes')) {
		if (!$this->config->item('disable_recv_number_on_barcode')) {
			$text .= " (RECV $from_recv)";
		}
	}

	if ($customer_name != "") {
		echo '<p style="font-size: 10pt;
		line-height: .9em;
		font-family: Arial, Helvetica, sans-serif !important;
		color: #000000 !important;
		width: 100%; 
		text-align: center;
		margin: 20px 0 0 0; ">' . $customer_name . '</p>';
	}
	// Check Store Config to see if Show Customer Phone on Service Tag is enabled or not
	if ($this->config->item('show_phone_number_service_tag')) {
		if ($customer_phone != "") {
			echo '<p style="font-size: 10pt;
			line-height: .9em;
			font-family: Arial, Helvetica, sans-serif !important;
			color: #000000 !important;
			width: 100%; 
			text-align: center;
			margin: 2px 0 0 0; ">' . $customer_phone . '</p>';
		}
	}

	$page_break_after = ($k == count($items) - 1) ? 'auto' : 'always';
	echo "<div class='barcode-label' style='page-break-after: $page_break_after'>" . ($this->config->item('show_barcode_company_name') ? $company . "<br />" : '') . (!$this->config->item('hide_barcode_on_barcode_labels') ? "<img style='vertical-align:baseline;'src='" . site_url('barcode/index/svg') . '?barcode=' . rawurlencode($barcode) . '&text=' . rawurlencode($barcode) . "&scale=$scale&thickness=$thickness&font_size=$font_size' /><br />" : $barcode . '<br />') . $text . "</div>";
}
?>
</div>
<script>
	<?php if (isset($_POST) && count($_POST)) { ?>

		show_feedback('success',
            <?php echo json_encode(lang('saved_successfully')); ?>,
            <?php echo json_encode(lang('success')); ?>);

			
		var post_data = <?php echo json_encode($_POST); ?>;
		var post_data_clean = [];

		for (var name in post_data) {
			var value = post_data[name];
			post_data_clean.push({
				name: name,
				value: value
			});
		}
	<?php } ?>

	if (typeof post_data !== 'undefined') {
		$("#barcode_form").submit(function(e) {
			e.preventDefault();
			$(this).ajaxSubmit(function() {
				


				post_submit(<?php echo json_encode(current_url()); ?>, "POST", post_data_clean);
			});
		});

		$("#excel_form").submit(function(e) {
			e.preventDefault();
			$(this).ajaxSubmit(function() {
				post_submit(<?php echo json_encode(current_url()); ?>, "POST", post_data_clean);
			});
		});


		$("#reset_labels").click(function(e) {
			e.preventDefault();
			$.get($(this).attr('href'), function() {
				post_submit(<?php echo json_encode(current_url()); ?>, "POST", post_data_clean);
			});
		});
	} else {
		$("#barcode_form").submit(function(e) {
			e.preventDefault();
			$(this).ajaxSubmit(function() {
				window.location.reload();
			});
		});
	}

	$("#saved_barcoded_labels").change(function() {
		if ($(this).val()) {
			var settings = JSON.parse($(this).val());

			for (var key in settings) {
				$("#" + key).val(settings[key]);
			}
		}
	});
</script>
<?php $this->load->view("partial/footer"); ?>
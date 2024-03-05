<?php 
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
			<?php
			$labels_saved = $this->Appconfig->get_barcoded_labels()->result_array();
			?>
			
			
		</div>
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
     window.print();
	<?php if (isset($_POST) && count($_POST)) { ?>
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
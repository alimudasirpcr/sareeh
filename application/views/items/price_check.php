<?php $this->load->view("partial/header_standalone"); ?>
 <style>
    /* Custom styles */
    .header {
      background-color: #489ee7;
      color: white;
      text-align: center;
      padding: 10px;
    }
    .search-box {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .input-group-lg {
      margin-top: 20px;
    }
    .form-control {
      font-size: 32px;
      height: auto;
      padding: 10px;
    }
    .input-group-addon {
      font-size: 24px;
    }
    .btn-lg {
      font-size: 32px;
      padding: 20px 40px;
      background-color: #489ee7;
      border: none;
      margin-top: 20px;
    }
    .container {
      margin-top: 80px;
    }
	
    .error-message {
         background-color: #ff8080;
         color: white;
         font-size: 28px;
         font-weight: bold;
         padding: 15px;
         border-radius: 10px;
         margin-bottom: 20px;
       }
  </style>
 <!-- Header -->
   <div class="header">
     <h1><?php echo $this->config->item('company')?></h1>
   </div>

   <!-- Main Content -->
   <div class="container">
     <div class="row">
       <div class=" m-auto col-sm-6 ">
		   
		 <?php
         if (isset($not_found) && $not_found === true) 
		 {
           echo '<div class="error-message text-center">'.lang('item_not_found').'</div>';
         }
		  ?>
         <div class="search-box">
          <form action="" method="POST" id="lookup">
           <h2><?php echo lang('start_typing_item_name')?></h2>
           <div class="input-group input-group-lg">
             <input id="item" type="text" class="form-control" placeholder="" name="item">
             <span class="input-group-addon">
               <i class="glyphicon glyphicon-barcode"></i>
             </span>
           </div>
           <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo lang('lookup')?></button>
         	</form>
		 </div>
       </div>
     </div>
   </div>
 <script>
	setInterval(function(){$.get('<?php echo site_url('home/keep_alive'); ?>');}, 300000);
	$("#item").autocomplete({
		source: '<?php echo site_url("items/price_check?allowed=".$this->input->get('allowed')); ?>',
		delay: 500,
		autoFocus: false,
		minLength: 0,
		select: function(event, ui) {
			if(ui.item.value == "") return;
			
			$("#item").val(decodeHtml(ui.item.value) + '|FORCE_ITEM_ID|');
			
			$("#lookup").submit();
		},
	}).data("ui-autocomplete")._renderItem = function(ul, item) {
		return $("<li class='item-suggestions'></li>")
			.data("item.autocomplete", item)
			.append('<a class="suggest-item" data-value="' + item.value + '" data-attributes="' + item.attributes + '"><div class="item-image">' +
				'<img src="' + item.image + '" alt="">' +
				'</div>' +
				'<div class="details">' +
				'<div class="name">' +
				decodeHtml(item.label) +
				'</div>' +
				'<span class="attributes">' + '<?php echo lang("category"); ?>' + ' : <span class="value">' + (item.category ? item.category : <?php echo json_encode(lang('none')); ?>) + '</span></span>' +
				<?php if ($this->Employee->has_module_action_permission('items', 'see_item_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
					(typeof item.quantity !== 'undefined' && item.quantity !== null ? '<span class="attributes">' + '<?php echo lang("quantity"); ?>' + ' <span class="value">' + item.quantity + '</span></span>' : '') +
				<?php } ?>
				(item.attributes ? '<span class="attributes">' + '<?php echo lang("attributes"); ?>' + ' : <span class="value">' + item.attributes + '</span></span>' : '') +
				'<?php if(!$this->config->item('hide_supplier_in_item_search_result')){ ?>'+
				(item.supplier_name ? '<span class="attributes">' + '<?php echo lang("supplier"); ?>' + ' : <span class="value">' + item.supplier_name + '</span></span>' : '') +
				'<?php } ?>'+
				'</div>')
			.appendTo(ul);
	};
	
	$("#item").focus();
	
 </script>
<?php $this->load->view("partial/footer_standalone"); ?>
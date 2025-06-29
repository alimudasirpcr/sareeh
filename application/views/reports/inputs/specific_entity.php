<div class="form-group one">
	<?php echo form_label($specific_input_label.':', $specific_input_name, array('class'=>'col-sm-3 col-md-3 col-lg-2 form-label ')); ?> 
	<div class="col-sm-9 col-md-2 col-lg-10 two">
		
		<?php  
		
	
		if (isset($search_suggestion_url)) {?>
			<?php echo form_input(array(
				'class' => 'form-control form-control-solid three  ',
				'name'=>$specific_input_name,
				'id'=>$specific_input_name,
				'size'=>'10'
			));
			?>									
		<?php } else { ?>
			<?php echo form_dropdown($specific_input_name,$specific_input_data, $this->input->get($specific_input_name), 'id="'.$specific_input_name.'" class="form-select"'); ?>
		<?php } ?>
	</div>
</div>

<script type="text/javascript" language="javascript">
	$(document).ready(function()
	{
		<?php
		if (isset($search_suggestion_url))
		{
		
		?>

		var $el = $("#<?php echo $specific_input_name;?>");

		if ($el.length) {
			$el.select2(
			{
				placeholder: <?php echo json_encode(lang('search')); ?>,
				id: function(suggestion){ return suggestion.value; },
				ajax: {
					url: <?php echo json_encode($search_suggestion_url); ?>,
					dataType: 'json',
				   data: function(term, page) 
					{
				      return {
				          'term': term
				      };
				    },
					results: function(data, page) {
						console.log('data' , data);
						return {results: data};
					}
				},
				formatSelection: function(suggestion) {
					return suggestion.label;
				},
				formatResult: function(suggestion) {
					return suggestion.label;
				}
			});
		}
		<?php
		}
		else
		{
			
		?>
			$("#<?php echo $specific_input_name; ?>").select2();		
		<?php
		}
		?>
	});
</script>


		
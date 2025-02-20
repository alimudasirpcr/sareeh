<?php
$this->load->view("partial/header_standalone");
?>
	<div class="container">
		<div class="card  row invoice_body">
			
			<?php echo form_open("public_view/start_cc_processing_coreclear2",array('id'=>'invoice_save_form','class'=>'form-horizontal')); ?>
			
			<div class="card-body row">
				<div class="col-md-12">
					<h1 class="payment-title text-center"><?php echo lang('payment_success')?></h1> 
					<div class="panel panel-success"> 
						<div class="card-header rounded rounded-3 p-5"> 
							<h3 class="panel-title"><?php echo lang('details')?></h3> 
							<span class="label label-danger pull-right term"></span>
						</div> 
						<div class="card-body"> 
							<table class="table table-bordered">
								<tr>
									<td class="text-strong"><?php echo lang('reports_payment_date');?></td>
									<td class="text-right">
										<?php echo date(get_date_format().' '.get_time_format(),strtotime($payment_date));?>
									</td>
								</tr>
								<tr>
									<td class="text-strong"><?php echo lang('reports_payment_type');?></td>
									<td class="text-right"><?php echo $payment_type;?></td>
								</tr>

								<tr>
									<td class="text-strong">Card Number</td>
									<td class="text-right"><?php echo $truncated_card;?></td>
								</tr>
								<tr class="total_bg">
									<td class="text-strong"><?php echo lang('payment_amount');?></td>
									<td class="text-right text-strong"><?php echo to_currency($payment_amount);?></td>
								</tr>
							</table>
						</div> 

						<br>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		<?php
			$message = 'Card Charged Successfully';
			echo "show_feedback('success', ".json_encode($message).", ".json_encode(lang('success')).");";
		?>
	
		</script>
<?php
$this->load->view("partial/footer_standalone");
?>
<?php
if(isset($payments) && !empty($payments))
{
	
$is_coreclear_processing = $this->Location->get_info_for_key('credit_card_processor') == 'coreclear' || $this->Location->get_info_for_key('credit_card_processor') == 'coreclear2';
	
?>

	<div class="">
		<h5><strong><?php echo lang('payments');?></strong></h5>
	</div>
	
		<div class="" id="unpaid_payments">
			<table class="table table-bordered">
				<thead>
					<tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
						<th><?php echo lang('id');?></th>
						<th><?php echo lang('reports_payment_date');?></th>
						<th><?php echo lang('reports_payment_type');?></th>
						<th><?php echo lang('payment_amount');?></th>
						<?php if ($invoice_type == 'customer' && $is_coreclear_processing) { ?>
						<th><?php echo lang('card_number');?></th>
						<th><?php echo lang('sales_ebt_auth_code');?></th>
						<?php } ?>
					</tr>
				</thead>
		
				<?php foreach($payments as $payment) { ?>
				<tr>
					<td><?php echo $payment['payment_id'];?></td>
					<td><?php echo date(get_date_format().' '.get_time_format(),strtotime($payment['payment_date']));?></td>
					<td><?php echo $payment['payment_type'];?></td>
					<td><?php echo to_currency($payment['payment_amount']);?></td>
					<?php if ($invoice_type == 'customer' && $is_coreclear_processing) { ?>
					
					<td><?php echo $payment['truncated_card'];?></td>
					<td><?php echo $payment['auth_code'];?></td>
					<?php } ?>
				</tr>
				<?php } ?>
			</table>
		</div>
	
<?php } ?>
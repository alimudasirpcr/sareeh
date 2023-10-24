<?php $this->load->view("partial/header"); 
$tracking_cash = false;

$track_payment_types =  $this->config->item('track_payment_types') ? unserialize($this->config->item('track_payment_types')) : array();

if ($this->config->item('track_payment_types') && !empty($track_payment_types))
{
	$payment_types = unserialize($this->config->item('track_payment_types'));
	$tracking_cash = in_array('common_cash',$payment_types);
}
?>
<style scoped>
	a
	{
		text-decoration: none !important;
	}
</style>

<?php echo form_open('sales', array('id'=>'opening_amount_form')); ?>

<div class="row">
	<div class="col-md-12">
	<div class="card card-flush h-lg-100" id="kt_contacts_main">
												<!--begin::Card header-->
												<div class="card-header pt-7" id="kt_chat_contacts_header">
													<!--begin::Card title-->
													<div class="card-title">
														<!--begin::Svg Icon | path: /Users/shuhratsaipov/www/keenthemes/products/core/html/src/media/icons/duotune/finance/fin008.svg-->
														<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z" fill="currentColor"/>
														<path opacity="0.3" d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z" fill="currentColor"/>
														<path d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z" fill="currentColor"/>
														</svg>
														</span>
														<!--end::Svg Icon-->
														<h2>	<?php echo lang('sales_opening_amount_desc'); ?></h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-5">
												<?php
														if($tracking_cash)
														{
														?>
														<div class="col-md-4">
															<div class="table-responsive">
																<table class="table table-striped table-hover text-center opening_bal">
																	<tr>
																		<th><?php echo lang('common_denomination');?></th>
																		<th><?php echo lang('common_count');?></th>
																	</tr>

																	<?php foreach($denominations as $denomination) { ?>
																	<tr>
																		<td><?php echo $denomination['name']; ?></td>
																		<td>
																			<div class="form-group">
																				<?php echo form_input(array(
																				'name'=>'denoms['.$denomination['id'].']',
																					'id'=>'denom_'.$denomination['id'],
																					'data-value' => $denomination['value'],
																					'value' => isset($denoms[$denomination['id']]) && $denoms[$denomination['id']] ? $denoms[$denomination['id']] : '',
																					'class'=> 'form-control denomination',
																					)
																				);?>
																			</div>
																		</td>
																	</tr>
																	<?php } ?>
																</table>
															</div>
														</div>
														<?php } ?>
														
														<div class="col-md-8">
															<?php
															$reg_info = $this->Register->get_info($this->Employee->get_logged_in_employee_current_register_id());
															$reg_name =  '&nbsp;<span class="badge bg-primary">'.$reg_info->name.'&nbsp;(<small>'.lang('sales_change_register').'</small>)</span>';
															?>

																
																
															<?php foreach(unserialize($this->config->item('track_payment_types')) as $payment_type_track) { ?>
															<div class="form-group clearfix">
																
																<div class="from-group text-center fw-bold">
																	<?php echo lang('sales_previous_closing_amount');?>: <?php echo to_currency(isset($previous_closings[$payment_type_track]) ? $previous_closings[$payment_type_track] : 0);?>
																</div>
																<div class="col-md-12 text-center">
																	<div class="fv-row mb-7 fv-plugins-icon-container">
																	<?php echo form_label((strpos($payment_type_track, 'common_') !== FALSE ? lang($payment_type_track) : $payment_type_track). ' '.lang('common_opening_amount').':', 'opening_amount',array('class'=>'fs-6 fw-semibold form-label mt-3 pull-left')); ?>
															
																		<?php echo form_input(array(
																		'name'=>'opening_amount['.$payment_type_track.']',
																		'class'=>'form-control form-control-solid opening_amount',
																		'value'=>'',
																		'required' => '')
																		);?>
																	</div>
																	<!-- /input-group -->
																</div>
															</div>
																				<hr />
																	<?php } ?>

																		<span class="input-group-btn bg">
																			<?php echo form_submit(array(
																				'name'=>'submit',
																				'id'=>'submit',
																				'value'=>lang('common_save'),
																				'class'=>'btn btn-primary')
																			);
																			?>
																		</span>

															<div class="from-group text-center">
																<h3><?php echo lang('common_or'); ?></h3>					
																<?php echo lang('common_register_name');?>: <?php echo anchor('sales/clear_register', $reg_name);?>
															</div>
															<br />
															<div class="from-group text-right">
															<?php if ($this->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
																<?php echo anchor_popup(site_url('sales/open_drawer'), '<i class="ion-android-open"></i> '.lang('common_pop_open_cash_drawer'),array('class'=>'', 'target' => '_blank')); ?>
															<?php } ?>
															</div>
															
														</div>
												</div>
												<!--end::Card body-->
											</div>

	
		
	</div>	
</div>
<?php
echo form_close();
?>

<script type='text/javascript'>

	//validation and submit handling
	$(document).ready(function()
	{
		$(".opening_amount").eq(0).focus();
		
		jQuery.extend(jQuery.validator.messages, {
		    required: <?php echo json_encode(lang('sales_amount_required')); ?>
		});
		
		$('#opening_amount_form').validate();
		
		function calculate_total()
		{
			var total = 0;
			
			$(".denomination").each(function( index ) 
			{
				if ($(this).val())
				{
					total+= $(this).data('value') * $(this).val();
				}
			});			
			
			$(".opening_amount").eq(0).val(parseFloat(Math.round(total * 100) / 100).toFixed(<?php echo $this->config->item('number_of_decimals') !== NULL && $this->config->item('number_of_decimals') != '' ? (int)$this->config->item('number_of_decimals') : 2; ?>));
		}
		
		$(".denomination").change(calculate_total);
		$(".denomination").keyup(calculate_total);

	});
</script>
<?php $this->load->view('partial/footer.php'); ?>
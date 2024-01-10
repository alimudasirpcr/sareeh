<?php
$company = ($company = $this->Location->get_info_for_key('company')) ? $company : $this->config->item('company');
?>
<script src="<?php echo base_url('assets/css_good/plugins/global/plugins.bundle.js');?>"></script>
<div class="row">
	<?php foreach($summary_data as $name=>$value) { ?>
	    <div class="col-md-3 col-xs-12 col-sm-6 summary-data">
	        <!-- <div class="info-seven primarybg-info">
	            <div class="logo-seven"><i class="ti-widget dark-info-primary"></i></div>
							
							
	        </div> -->

			<div class="card card-flush  mb-5 mb-xl-10">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<div class="card-title d-flex flex-column">
													<?php
							if( $name == 'sales_per_time_period')
							{
				            echo '<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted" >'.str_replace(' ','&nbsp;', to_quantity($value)).'</span>';
							}
	            else
							{
								echo '<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2 counted" >'.to_currency($value).'</span>';
	            }
							?>
							<span class="text-gray-400 pt-1 fw-semibold fs-6"><?php echo lang('reports_'.$name); ?></span>
													</div>
												</div>
			</div>
	    </div>
	<?php }?>
</div>

<div class="row">
	<div id="report_summary"  class="repors-summarys col-md-12 ">
		<div class="panel panel-piluku">
			<div class="panel-heading rounded rounded-3 p-5">
				<?php echo lang('reports_reports'); ?> - <?php echo $company; ?> <?php echo $title ?>
				<?php if($key) { ?>
					<a href="<?php echo site_url("reports/delete_saved_report/".$key);?>" class="btn btn-primary text-white hidden-print delete_saved_report pull-right"> <?php echo lang('reports_unsave_report'); ?></a>	
				<?php } else { ?>
					<button class="btn btn-primary text-white hidden-print save_report_button pull-right" style="margin-top: -12px;" data-message="<?php echo H(lang('reports_enter_report_name'));?>"> <?php echo lang('reports_save_report'); ?></button>
				<?php } ?>
			</div>
			<div class="panel-body">


				<div id="chart_wrapper">
					<div id="chart-legend" class="chart-legend"></div>
					<!-- <canvas id="chart"></canvas> -->
					<div id="chart"> </div>
				</div>


					<?php if(isset($owner_have_to_pay_to_sp)): ?>
				<div id="chart_wrapper1">
					<div id="chart-legend1" class="chart-legend"><?php echo lang('reports')." - ".lang('owner_have_to_pay_to_sp') ?></div>
					<div id="chart1" style="    margin: 0 auto;width: 90%;height: 500px"> </div>
				</div>
						<?php endif; ?>
						<?php if(isset($owner_have_to_pay_for_parts)): ?>

				<div id="chart_wrapper2">
					<div id="chart-legend2" class="chart-legend"><?php echo lang('reports')." - ".lang('owner_have_to_pay_for_parts') ?></div>
					<div id="chart2" style="    margin: 0 auto;width: 90%;height: 500px"> </div>
				</div>

				<?php endif; ?>

				
					<?php if(isset($net_amount_for_owner)): ?>


					<div id="chart_wrapper3">
						<div id="chart-legend3" class="chart-legend"><?php echo lang('reports')." - ".lang('net_amount_for_owner') ?></div>
						<div id="chart3" style="    margin: 0 auto; width: 90%; height: 500px"> </div>
					</div>

				<?php endif; ?>

			</div>
		</div>
	</div>
	</div>
</div>

<script>
	
</script>

<script type="text/javascript">
	<?php $this->load->view('reports/outputs/graphs/'.$graph); ?>
</script>
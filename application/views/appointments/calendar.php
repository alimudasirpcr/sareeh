<?php $this->load->view("partial/header"); ?>
<div class="manage_buttons">
<div class="manage-row-options hidden">
	<div class="email_buttons text-center">		
		
	</div>
</div>
	<div class="row hidden-print">
		<div class="col-md-9 col-sm-9 col-xs-10">
			
			<div class="date search no-left-border">
				<ul class="list-inline">
					<li>
						<input type="text" name="start_date" value="<?php echo $selected_date ?>" id="date" placeholder="<?php echo lang('appointments_select_date'); ?>" class="form-control datepicker">
					</li>
					<li>
						
						<div class="btn-group " role="group" aria-label="...">
						  <a href="<?php echo H($monthly_url); ?>" class="btn btn-default <?php echo (!$week && !$day) ? 'active' : '' ?>"><?php echo lang('month'); ?></a>
						  <a href="<?php echo H($weekly_url); ?>" class="btn btn-default <?php echo ($week && !$day) ? 'active' : '' ?>"><?php echo lang('week'); ?></a>
						  <a href="<?php echo H($daily_url); ?>" class="btn btn-default <?php echo $day ? 'active' : '' ?>"><?php echo lang('day'); ?></a>
						</div>
												
					</li>
					<li>						<?php
						 echo	anchor("appointments/view/-1?date=$selected_date",
							'<span class="ion-plus"></span> '.lang('appointments_new'),
							array('class'=>'btn btn-primary btn-lg hidden-sm hidden-xs', 
								'title'=>lang('appointments_new')));
						?>
					</li>
				</ul>	
			</div>
			
		</div>
		<div class="col-md-3 col-sm-3 col-xs-2">	
			<div class="buttons-list">
				<div class="pull-right-btn">
					<!-- right buttons-->
					<div class="btn-group" role="group" aria-label="...">
						<?php echo anchor('appointments', '<span class="ion-ios-arrow-back"></span>', array('class' => 'btn btn-more btn-light-primary hidden-xs')) ?>
						
						
						
					</div>
					<?php if($deleted) { 
						echo 
						anchor("$controller_name/toggle_show_deleted/0",
							'<span class="ion-android-exit"></span> <span class="hidden-xs">'.lang('done').'</span>',
							array('class'=>'btn btn-primary btn-lg toggle_deleted','title'=> lang('done')));
					} ?>
			</div>
		</div>				
	</div>
</div>
</div>

<div class="main-content">
	<div class="container-fluid">
			<div class="row manage-table  card p-5">
				<div class="card ">
					<div class="card-header rounded rounded-3 p-5">
					<h3 class="card-title">
						<?php echo lang('calendar') ?>
					</h3>
					</div>
					<div class="card-body nopadding table_holder table-responsive" id="table_holder">
						<?php echo $calendar;?>
					</div>
				</div>
			</div>
		</div>
</div>
<script>
	
	date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);
	var $date = $("#date");
	var picker = $date.data("DateTimePicker");
	
	$date.on('dp.change', function (e) {
		window.location = SITE_URL + '/appointments/calendar/'+ e.date.format('YYYY')+'/'+ e.date.format('M') +'/'+ '-1' +'/'+ e.date.format('D');
	});
	
</script>
						
<?php $this->load->view("partial/footer"); ?>
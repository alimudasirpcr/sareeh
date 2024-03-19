<?php $this->load->view("partial/header"); ?>
<div class="card ">
	<div class="card-header rounded rounded-3 p-5">
		<h3 class="card-title">
			<?php echo lang('config_backup_overview'); ?>
		</h3>
	</div>
	<div class="card-body">
		<p><?php echo lang('config_backup_overview_desc'); ?></p>

		<p><?php echo lang('config_backup_options'); ?></p>

		<ol>
			
			<li>
				<p><?php echo lang('config_backup_mysqldump');?> <a href="http://dev.mysql.com/doc/refman/5.1/en/mysqldump.html" target="_blank">http://dev.mysql.com/doc/refman/5.1/en/mysqldump.html</a></p>
				<p><?php echo anchor('config/do_mysqldump_backup', lang('config_backup_database'), array('class' => 'btn btn-primary text-white dbBackup')); ?></p>
			</li>
			<li>
				<p><?php echo lang('config_backup_simple_option'); ?></p>
				<p><?php echo anchor('config/do_backup', lang('config_backup_database'), array('class' => 'btn btn-primary text-white dbBackup')); ?></p>
			</li>
			<li>
				<p><?php echo lang('config_backup_phpmyadmin_1'); ?> <a href="http://127.0.0.1/phpmyadmin/" target="_blank">http://127.0.0.1/phpmyadmin/</a>. <?php echo lang('config_backup_phpmyadmin_2'); ?></p>
			</li>
			<li><p><?php echo lang('config_backup_control_panel');?></p></li>
		</ol>
	</div>
</div>
<script type='text/javascript'>

</script>
<?php $this->load->view("partial/footer"); ?>
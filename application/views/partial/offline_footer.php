		<div id="footers" class="col-md-12 hidden-print text-center">
			<?php echo lang('please_visit_my'); ?>
			<a tabindex="-1" href="http://<?php echo $this->config->item('branding')['domain']; ?>" target="_blank"><?php echo lang('website'); ?></a> <?php echo lang('learn_about_project'); ?>.
			<span class="text-info"><?php echo lang('you_are_using_phppos') ?> <span class="badge bg-primary"> <?php echo APPLICATION_VERSION; ?></span></span> <?php echo lang('built_on') . ' ' . BUILT_ON_DATE; ?>
		</div>
	</div>
	<!---content -->
</div> <!-- wrapper -->


<script>
	function change_pos_settings(id , status){
	$.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo site_url('sales/change_pos_settings'); ?>',
                                                    data: {
                                                        'id': id,
														'status': status,
                                                    },
                                                    success: function() {
                                                        // window.location.reload(true);
                                                    }
                                                });
}


</script>
</body>
</html>
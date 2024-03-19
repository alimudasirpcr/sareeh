<?php $this->load->view("partial/header_standalone"); ?>
<h1 class="text-center"><?php echo lang('success');?>...<?php echo lang('reloading')?></h1>

<script>
setTimeout(function()
{
	window.location.href = window.location.href;
},5000);
</script>
<?php $this->load->view("partial/footer_standalone"); ?>
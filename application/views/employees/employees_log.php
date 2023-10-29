<?php $this->load->view("partial/header"); ?>

<style>
	.required{
		color: black;
	}
</style>

<div id="kt_app_content_container" class="app-content flex-column-fluid">
  
    <div class="card">
        <div class="card-header">
        <h3 class="card-title"><?php echo lang('deleted_item_log'); ?></h3>
        </div>
        <div class="card-body">

        <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
    <thead>
        <tr class="fw-semibold fs-6 text-muted">
            <th><?php echo lang('item_name'); ?></th>
            <th><?php echo lang('sales_id'); ?></th>
            <th><?php echo lang('date'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if($log): ?>
            <?php foreach($log as $l): ?>
        <tr>
            <td><?php echo $l->name; ?></td>
            <td> <a href="<?php echo base_url(); ?>sales/receipt/<?php echo $l->sales_id; ?>"> <?php echo $l->sales_id; ?> </a></td>
            <td><?php echo $l->created_at; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>

        </div>
    </div>
</div>

<script>

$("#kt_datatable_zero_configuration").DataTable();
</script>
<?php $this->load->view("partial/footer"); ?>
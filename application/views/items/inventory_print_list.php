<?php $this->load->view("partial/header"); ?>

<style>
table td {
    min-width: 155px;
    width: 20%;
    padding-right: 10px;
    padding-top: 7px;
    padding-bottom: 8px;
    vertical-align: top;
}
td {
    display: table-cell;
    vertical-align: inherit;
    word-wrap: break-word;
}
table {
    min-width: 540px;
    max-width: 945px;
    width: 100%;
}
table {
    display: table;
    border-collapse: separate;
    table-layout: fixed
}
</style>
<div class="card ">
	<div class="card-header rounded rounded-3 p-5  rounded border-primary border border-dashed rounded-3hidden-print">
		<h3 class="panel-title">
			<?php echo lang('items_inventory_print_list'); ?>
		</h3>
		<div class="text-center">	<button class="btn btn-primary text-white hidden-print" id="print_button" onclick="window.print();"><?php echo lang('print'); ?></button></div>
		<div class="text-right"><?php echo anchor($summary_only ? 'items/inventory_print_list/1/1' : 'items/inventory_print_list/0/1',lang('excel_export'));?></div>
	</div>
	<div class="card-body">
		<div class="text-cetner"><?php echo lang('date').': '.date(get_date_format().' '.get_time_format());?></div>
		
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-reports tablesorter" id="sortable_table">
				<thead>
					<tr>
						<th><?php echo lang('item_id')?></th>
						<th><?php echo lang('name')?></th>
						<th><?php echo lang('category')?></th>
						<th><?php echo lang('product_id')?></th>
						<th><?php echo lang('item_number')?></th>
						<th><?php echo lang('supplier')?></th>
						<th><?php echo lang('quantity')?></th>
					</tr>
				</thead>
					<tbody>
						<?php foreach($items as $row) { ?>
							<tr <?php echo $row['is_variation'] ? 'style="background-color: #eee;"' : '';?>>
								<td><?php echo $row['item_id'];?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $this->Category->get_full_path($row['category_id']);?></td>
								<td><?php echo $row['product_id'];?></td>
								<td><?php echo $row['item_number'];?></td>
								<td><?php echo $row['supplier'];?></td>
								<td><?php echo to_quantity($row['quantity']);?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
		</div>
	</div>
</div>
<script type='text/javascript'>

</script>
<?php $this->load->view("partial/footer"); ?>
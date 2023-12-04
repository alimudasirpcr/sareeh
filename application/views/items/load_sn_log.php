<div class="table-responsive">
 <table class="table table-striped gy-7 gs-7">
  <thead>
   <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
    <th>Id</th>
    <th>Created_at</th>
    <th>added_by</th>
    <th>Remarks</th>
   </tr>
  </thead>
  <tbody>
    <?php
  $this->load->model('Employee');
    foreach($res as $rec ): ?>
   <tr>
    <td><?= $rec['id']; ?></td>
    <td><?= date(get_date_format(), strtotime($rec['created_at'])) ; ?> </td>
    <td><?php 
    
    $emp = $this->Employee->get_info( $rec['added_by']);
    
     echo  $emp->full_name; ?>

    	
</td>
    <td>

	<?php 
 if ($this->Employee->has_module_action_permission('items', 'allow_edit_sn_log_remarks', $this->Employee->get_logged_in_employee_info()->person_id)) {
						
								echo anchor('items/sn_number_log_edit/'.$rec['id'],$rec['Remarks']  !== NULL ? $rec['Remarks'] : lang('empty'), array('data-value' => H($rec['Remarks']),'data-id' => H($rec['id']),'data-type' => 'text','data-name' => 'Remarks','data-pk' => $rec['id'],'class' => 'xeditable','data-title' => lang('edit'),'data-url' => site_url('items/sn_number_log_edit/'.$rec['id'])));	
 }else{
  echo $rec['Remarks'] ;
 }
								?>

</td>
   </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
</div>

<script>
						$('.xeditable').editable();
					</script>
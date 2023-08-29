
<?php
  $chairs = 4;

?>

<style>



<?php foreach($tablest as $tables){ ?>
		.table-square-<?php echo $tables['table']['id']; ?> {
			width: <?php echo calculateTableWidth(count($tables['chairs'])) ?>px;
			background: white;
			border-radius: 9px;
			height: 100px;
			margin: 0 auto;
			position: relative;
			/* background: #d34a220f; */
			color: #d9dee4;
			font-weight: 500;
		}
		.table-square-<?php echo $tables['table']['id']; ?>::before {
			content: "";
			position: absolute;
			border-radius: 10px 0px 0px 10px;
			height: 100%;
			width: 6px;
			left: 0px;
			background-color: <?php if($tables['table']['status']=='Free'){
				echo "#d9dee4";
			}elseif($tables['table']['status']=='Reserved'){
				echo "#ffc144";
			}else{
				echo "#0dc266";
			} ?>;
		}
		.chair-square-<?php echo $tables['table']['id']; ?> {
			position: absolute;
			width: 50px;
			height: 25px;
			border-radius: 0 0 50% 50%;
			
		}
		
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(1) {
			left: -44px;
			top: 35px;
			transform: rotate(90deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(2) {
			left: <?php echo calculatesecondchairposition(count($tables['chairs'])) ?>px;
			top: 35px;
			transform: rotate(270deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(3) {
			left: 52px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(4) {
			left: 52px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(5) {
			left: <?= 52 + 150 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(6) {
			left: <?= 52 + 150 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(7) {
			left: <?= 52 + 300 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(8) {
			left: <?= 52 + 300 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(9) {
			left: <?= 52 + 400 ?>px;
			top: -30px;
			transform: rotate(180deg);
		}
		.chair-square-<?php echo $tables['table']['id']; ?>:nth-child(10) {
			left: <?= 52 + 400 ?>px;
			top: 104px;
			transform: rotate(0deg);
		}
 <?php } ?>

 .plate {
    width: 63%;
    margin-top: -71px;
    margin-left: 9px;
}
</style>
<div class="col-4 draggable d-none">
                                                          
															  	

																<div class="table">
																	<div class="chair"></div>
																	<div class="chair"></div>
																	<div class="chair"></div>
																	<div class="chair"></div>
																</div>
                                                            </div>
															


															<?php if(count($tablest) > 0): foreach($tablest as $tablesd){ ?>


															<div  data-rotate="<?= ($tablesd['table']['rotate']=='')?'0':$tablesd['table']['rotate']; ?>" data-title="<?php echo $tablesd['table']['title'] ?>" data-status="<?php echo $tablesd['table']['status'] ?>"  ondblclick="change_table_status(this)" data-title="<?php echo $tablesd['table']['id'] ?>"  id="<?php echo $tablesd['table']['id'] ?>" data-left="<?php echo $tablesd['table']['pleft'] ?>" data-top="<?php echo $tablesd['table']['ptop'] ?>" class="  draggable col-<?= (count($tablesd['chairs']) >6)?6:4; ?> " style="position: absolute; left:<?php echo $tablesd['table']['pleft'] ?>; top:<?php echo $tablesd['table']['ptop'] ?>; transform: rotate(<?php echo $tablesd['table']['rotate'] ?>deg)">
															<div  class=" table-text">
															<span class="rotate"><i class="fas fa-redo"></i></span> <br>
															<?php echo $tablesd['table']['title'] ?>  <br>
																<?php echo $tablesd['table']['status'] ?> 
																
																</div>	
																
															<div class="table-square-<?php echo $tablesd['table']['id'] ?>">
																
																	<?php foreach( $tablesd['chairs'] as $chair ){ ?>
																			<div onclick="change_chair_status(<?php echo $chair['id'] ?>)" class="chair-square-<?php echo $tablesd['table']['id'] ?>" style="background-color: <?php if($chair['status']=='free'){
																		echo "#d9dee4";
																	}elseif($chair['status']=='reserved'){
																		echo "#ffc144";
																	}else{
																		echo "#0dc266";
																	} ?>;"></div>
																	<?php } ?>
																</div>
                                                            </div>
															<?php } endif; ?>


                                                            <div class="modal fade" tabindex="-1" id="kt_modal_5">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-title">Edit Floor</h3>

											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span class="svg-icon svg-icon-1"></span>
											</div>
											<!--end::Close-->
										</div>
                                        <form id="uploadFormedit" enctype="multipart/form-data">
										<div class="modal-body">
										
										<!--begin::solid autosize textarea-->
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Title</label>
											<input class="form-control form-control form-control-solid" id="title" value="<?php echo $floors['title']; ?>" name="title" data-kt-autosize="true"/>
                                            <input type="hidden" name="id" value="<?php echo $floors['id'] ?>" required>
										</div>
										<div class=" d-flex flex-column p-10">
											<label for="" class="form-label">Image</label>
											<input type="file" class="form-control form-control form-control-solid" id="image" name="image" data-kt-autosize="true"/>
										</div>
										</div>

										<div class="modal-footer">
											<button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Save changes</button>
										</div>
										</form>
									</div>
								</div>
							</div>

                            <script>
                                $('#uploadFormedit').on('submit', function(e) {
									e.preventDefault(); // Prevent the default form submission behavior

									var formData = new FormData(this); // Create a FormData object from the form

									$.ajax({
										url: '<?php echo site_url("booking/edit_floor"); ?>', // URL to your server-side upload handler
										type: 'POST',
										data: formData,
										processData: false, // Important! Do not process the data
										contentType: false, // Important! Do not set the content type
										success: function(response) {
											show_feedback('success', <?php echo json_encode(lang('common_success')); ?>, <?php echo json_encode(lang('common_success')); ?>);
												setTimeout(function(){
												window.location.reload(1);
												}, 1000);
										},
										error: function(jqXHR, textStatus, errorThrown) {
										console.log('File upload failed:', textStatus, errorThrown);
										}
									});
									});
                            </script>
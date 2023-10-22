<?php
$count = count($data);
for ($i=0; $i < $count ; $i++) {

		?>


		
														<!--end::Separator-->
														<!--begin::User-->
														<div class="d-flex flex-stack py-4 innerBox user" id='avtar_and_details'>
															<!--begin::Details-->
															<div class="d-flex align-items-center ">
																<!--begin::Avatar-->
																
																<!--begin::Avatar-->
																<div class="symbol symbol-45px symbol-circle" id="user_avtar">
																	<span class="symbol-label bg-light-warning text-warning fs-6 fw-bolder"><?php echo strtoupper(mb_substr($data[$i]['username'], 0, 1)); ?></span>
																	 <?php if($data[$i]['is_active']){ ?>
																	<div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>
																	<?php }else{ ?>

																		<div class="symbol-badge bg-secondary start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>
																

																	 <?php } ?>
																	<input type="hidden" class="is_active" value="<?php echo $data[$i]['is_active'];?>">
																	<input type='hidden' name='hdn' id='hidden_id' value="<?php echo $data[$i]['id'];?>">
																</div>
																<!--end::Avatar-->
																<!--end::Avatar-->
																<!--begin::Details-->
																<div class="ms-5">
																	<span class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2 searchdata" id="fullname"><?php echo $data[$i]['username']?></span>
																	<div class="fw-semibold text-muted"><p class='m-0' id="message">
																		<?php
																	
																		
																				$output = "";
																				for($j = 0; $j < count($last_msg); $j++){
																					
																					if($data[$i]['id'] == $last_msg[$j]['sender_id']){

																						$output = $last_msg[$j]['message'];

																					}elseif($data[$i]['id'] == $last_msg[$j]['receiver_id']){

																						$output = "You : ".$last_msg[$j]['message'];
																						
																					}else{
																						// $output = "No message yet..";
																						
																					}
																					
																				}
																				if(strlen($output) > 30){
																					echo substr($output,0,30)."...";
																				}else{
																					echo $output;
																				}
																				
																			?>
																		</p>
																	</div>
																</div>
																<!--end::Details-->
															</div>
															<!--end::Details-->
															<!--begin::Lat seen-->
															<div class="d-flex flex-column align-items-end ms-2">
																<span class="text-muted fs-7 mb-1">		
																	<p id="time">
																	<?php

																		$messageTime = "";
																		for($j = 0; $j < count($last_msg); $j++){
																			if($data[$i]['id'] == $last_msg[$j]['sender_id'] || $data[$i]['id'] == $last_msg[$j]['receiver_id']){

																				$messageTime = $last_msg[$j]['time'];

																			}
																		}
																		echo $messageTime;
																	?>
																	</p>
																</span>
																<!-- <span class="badge badge-sm badge-circle badge-light-success">6</span> -->
															</div>
															<!--end::Lat seen-->
														</div>
														<!--end::User-->
														<div class="separator separator-dashed d-none"></div>

		
		<?php
	
}
	?>
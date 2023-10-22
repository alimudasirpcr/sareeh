<?php
    $mysession  = $this->Employee->get_logged_in_employee_info()->id;
    $count = count($data);
    for($i = 0; $i < $count; $i++){
        if($data[$i]['sender_id'] == $mysession){
        ?>
            
            <!--begin::Message(out)-->
            <div class="d-flex justify-content-end mb-10">
															<!--begin::Wrapper-->
															<div class="d-flex flex-column align-items-end">
																<!--begin::User-->
																<div class="d-flex align-items-center mb-2">
																	<!--begin::Details-->
																	<div class="me-3">
																		<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
																	</div>
																	<!--end::Details-->
																</div>
																<!--end::User-->
																<!--begin::Text-->
																<div id="receiver_ptag" class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text"><?php echo $data[$i]['message'];?></div>
																<!--end::Text-->
															</div>
															<!--end::Wrapper-->
														</div>
														<!--end::Message(out)-->
        <?php
        }else{
        ?>
        <!--begin::Message(in)-->
        <div class="d-flex justify-content-start mb-10">
															<!--begin::Wrapper-->
															<div class="d-flex flex-column align-items-start">
																<!--begin::User-->
																<div class="d-flex align-items-center mb-2">
																	
																	<!--begin::Details-->
																	<div class="ms-3">
																		<a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1"><?php echo $othername; ?></a>
																		
																	</div>
																	<!--end::Details-->
																</div>
																<!--end::User-->
																<!--begin::Text-->
																<div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text"><?php echo $data[$i]['message'];?></div>
																<!--end::Text-->
															</div>
															<!--end::Wrapper-->
														</div>
														<!--end::Message(in)-->
      
        <?php
        }
    }
?>


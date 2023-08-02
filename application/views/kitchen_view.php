<div class="row mt-3">
                                        <div class="col-4 border-right-dotted">
                                            <h3 class="text-center bg-danger bg-opacity-70 rounded-2 px-6 py-5">New</h3>
                                            <div class="row">

                                                <?php if(isset($New)):  foreach($New as $order): ?>
                                                   
                                                <div class="col-xl-6 mb-2">
                                                    <div class="w-100 h-100 align-items-center">
                                                        <!--begin::Option-->
                                                        <div class="w-100 d-flex flex-column flex-center rounded bg-danger py-5 px-5">
                                                            <!--begin::Heading-->
                                                            <div class="mb-2 text-center">
                                                                <!--begin::Title-->
                                                                <h1 class="text-white mb-5 fw-bolder"> <?php echo $order['sales']->table_name; ?></h1>
                                                                <!--end::Title-->
                                                                <div data-id="<?php echo    strtotime( $order['sales']->to_new_time) ?>" id="timer<?php echo $order['sales']->sale_id; ?>" class="timer"></div>
                                                                <div class="text-white opacity-75 fw-semibold mb-5">
                                                                   Reservation  : <?php echo $order['sales']->delivery_type ?>  <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->from_new_time)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->to_new_time)); ?>
                                                                </div>
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Features-->
                                                            <div class="w-100 mb-10">
                                                            <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>

                                                               

                                                            </div>
                                                            <!--end::Features-->
                                                            <!--begin::Select-->
                                                            <div class="row">
                                                                <div class=" col-md-6   text-center">   
                                                                    <button onclick="change_status('Processing' , <?php echo $order['sales']->sale_id; ?>)" class="btn btn-dark btn-sm fw-bold  rounded-1">Mark Processing</button>
                                                                </div>
                                                                <div class=" col-md-6   text-center ">  
                                                                    <button  class="btn btn-dark btn-sm fw-bold  rounded-1">Paid</button>
                                                                </div>
                                                                <div class=" col-md-6   text-center mt-2 ">  
                                                                    <button  class="btn btn-warning btn-sm fw-bold  rounded-1">Suspend</button>
                                                                </div>
                                                            </div>
                                                            <!--end::Select-->
                                                        </div>
                                                        <!--end::Option-->
                                                    </div>
                                                </div>
                                                <?php endforeach; else: echo " <div class='text-center fw-bold'> No record found </div>"; endif; ?>

                                            </div>
                                        </div>
                                        <div class="col-4 border-right-dotted">
                                            <h3 class="text-center bg-info bg-opacity-70 rounded-2 px-6 py-5">Processing</h3>

                                            <div class="row">
                                            <?php if(isset($Processing)):  foreach($Processing as $order): ?>
                                                   
                                                   <div class="col-xl-6 mb-2">
                                                       <div class="w-100 h-100 align-items-center">
                                                           <!--begin::Option-->
                                                           <div class="w-100 d-flex flex-column flex-center rounded bg-info py-5 px-5">
                                                               <!--begin::Heading-->
                                                               <div class="mb-2 text-center">
                                                                   <!--begin::Title-->
                                                                   <h1 class="text-white mb-5 fw-bolder"><?php echo $order['sales']->table_name; ?></h1>
                                                                   <!--end::Title-->
                                                                   <div data-id="<?php echo    strtotime( $order['sales']->to_new_time) ?>" id="timer<?php echo $order['sales']->sale_id; ?>" class="timer"></div>
                                                                  
                                                             
                                                                   <div class="text-white opacity-75 fw-semibold mb-5">
                                                                   Reservation : <?php echo $order['sales']->delivery_type ?>  <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->from_new_time)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->to_new_time)); ?>

                                                              
                                                                </div>
                                                               </div>
                                                               <!--end::Heading-->
                                                               <!--begin::Features-->
                                                               <div class="w-100 mb-10">
                                                               <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>
   
                                                                  
   
                                                               </div>
                                                               <!--end::Features-->
                                                               <!--begin::Select-->
                                                              <!--begin::Select-->
                                                            
                                                              <div class="row">
                                                                <div class=" col-md-6   text-center">   
                                                                    <button onclick="change_status('Completed' , <?php echo $order['sales']->sale_id; ?>)" class="btn btn-dark btn-sm fw-bold  rounded-1">Mark Completed</button>
                                                                </div>
                                                                <div class=" col-md-6   text-center ">  
                                                                    <button  class="btn btn-dark btn-sm fw-bold  rounded-1">Paid</button>
                                                                </div>
                                                                <div class=" col-md-6   text-center mt-2 ">  
                                                                    <button  class="btn btn-warning btn-sm fw-bold  rounded-1">Suspend</button>
                                                                </div>
                                                            </div>


                                                              <!--end::Select-->
                                                               <!--end::Select-->
                                                           </div>
                                                           <!--end::Option-->
                                                       </div>
                                                   </div>
                                                   <?php endforeach; else: echo " <div class='text-center fw-bold'> No record found </div>"; endif; ?>
                                            </div>


                                        </div>
                                        <div class="col-4 ">
                                         
                                            <h3 class="text-center bg-primary bg-opacity-70 rounded-2 px-6 py-5">Completed</h3>
                                            <div class="row">
                                            <?php if(isset($Completed)):  foreach($Completed as $order): ?>
                                                   
                                                   <div class="col-xl-6 mb-2 ">

                                                       <div class="w-100 h-100 align-items-center card card-rounded overflow-hidden">
                                                        
                                                            <!--begin::Ribbon-->
                                                            <div class="ribbon ribbon-triangle ribbon-top-start border-danger">
                                                                <!--begin::Ribbon icon-->
                                                                <div class="ribbon-icon mt-n5 ms-n6">
                                                                    <i class="bi bi-check2 fs-2 text-white"></i>
                                                                </div>
                                                                <!--end::Ribbon icon-->
                                                            </div>
                                                            <!--end::Ribbon-->
                                                           <!--begin::Option-->
                                                           <div class="w-100 d-flex flex-column flex-center rounded bg-primary py-5 px-5">
                                                               <!--begin::Heading-->
                                                               <div class="mb-2 text-center">
                                                                   <!--begin::Title-->
                                                                   <h1 class="text-white mb-5 fw-bolder"><?php echo $order['sales']->table_name; ?></h1>
                                                                   <!--end::Title-->
                                                                   <!-- <div   class="timer"><i class="fa fa-check-circle text-light"></i> </div> -->
                                                                   <div class="text-white opacity-75 fw-semibold mb-5">
                                                                   Reservation   : <?php echo $order['sales']->delivery_type ?> <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->date_from)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->date_to)); ?>
                                                                </div>
                                                               </div>
                                                               <!--end::Heading-->
                                                               <!--begin::Features-->
                                                               <div class="w-100 mb-10">
                                                               <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>
   
                                                                  
   
                                                               </div>
                                                               <!--end::Features-->
                                                               <!--begin::Select
                                                               <a href="#" class="btn btn-color-primary btn-sm fw-bold btn-white rounded-1">Change Status</a>
                                                              end::Select-->
                                                           </div>
                                                           <!--end::Option-->
                                                       </div>
                                                   </div>
                                                   <?php endforeach; else: echo " <div class='text-center fw-bold'> No record found </div>"; endif; ?>
                                            </div>
                                        </div>

                                            


                                </div>
                                
                               

                              
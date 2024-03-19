<script>

    
</script>
<div class="row mt-3">
                                        <div class="col-4 border-right-dotted">
                                            <h3 class="text-center bg-danger bg-opacity-70 rounded-2 px-6 py-5">New</h3>
                                            <div class="row">

                                                <?php
                                                $i=0;
                                                 if(isset($New)):  foreach($New as $order): 
                                                 
                                                 ?>
                                                   
                                                <div class="col-xl-6 mb-2">
                                                    <div class="w-100 h-100 align-items-center">
                                                        <!--begin::Option-->
                                                        <div class="w-100 d-flex flex-column flex-center rounded bg-danger py-5 px-5">
                                                            <!--begin::Heading-->
                                                            <div class="mb-2 text-center">
                                                                <!--begin::Title-->
                                                                <h1 class="text-white mb-5 fw-bolder"> <?php echo $order['sales']->table_name; ?> </h1>
                                                                <!--end::Title-->
                                                                <div data-id="<?php echo    strtotime( $order['sales']->to_new_time) ?>" class="timer"><?php echo $order['sales']->delivery_type ?></div>
                                                                <div class="text-white opacity-75 fw-semibold mb-5">
                                                                Order #  : <?php echo $order['sales']->sale_id ?>  <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->from_new_time)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->to_new_time)); ?>
                                                                </div>
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Features-->
                                                           
                                                            <!--end::Features-->
                                                            <!--begin::Select-->
                                                           
                                                            <div class="w-100 d-flex justify-content-between">
                                                          
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary " onclick="show_view_modal( <?php echo $order['sales']->sale_id; ?>)">
                                                View
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary view-btn" data-kt-menunew-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                                <span class="svg-icon svg-icon-5 m-0">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon--></a>
                                                                <!--begin::Menu-->
                                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                                   
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="javascript:void(0);"   onclick="change_status('Processing' , <?php echo $order['sales']->sale_id; ?>)"  class="menu-link px-3">Mark Processing</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="javascript:void(0);" onclick="show_modal( <?php echo $order['sales']->sale_id; ?>)" class="menu-link px-3">change time </a>
                                                                    </div> 
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 d-none">
                                                                        <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                </div>
                                                                <!--end::Menu-->
                                                               
                                                            </div>
                                                            <!--end::Select-->
                                                        </div>
                                                        <!--end::Option-->
                                                    </div>
                                                </div>

                                                <div class="modal fade" tabindex="-1" id="kt_modal_<?php echo $order['sales']->sale_id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Change Status</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-1"></span>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >5</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >10</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >15</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >20</button>
                                                                
                                                                </div>
                                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >30</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >40</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >50</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >60</button>
                                                                </div>

                                                                <input type="number" class="form-control form-control-solid time_selected" placeholder="Enter Time" id="time_selected_<?php echo $order['sales']->sale_id; ?>" name="time_selected" value="10" />
                                                            

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">No</button>
                                                                <button type="button" class="btn btn-primary" onclick="change_time(<?php echo $order['sales']->sale_id; ?>)">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal fade" tabindex="-1" id="kt_view_modal_<?php echo $order['sales']->sale_id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Detail</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-1"></span>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                               
                                                            <div class="w-100 mb-10">
                                                            <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary "  onclick="print_receipt_wrapper(<?php echo $order['sales']->sale_id; ?>)">
                                                Receipt 
                                                                </a>
                                                               

                                                            </div>
                                                            

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
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
                                                                   <div data-id="<?php echo    strtotime( $order['sales']->to_new_time) ?>"  class="timer"><?php echo $order['sales']->delivery_type ?></div>
                                                                  
                                                             
                                                                   <div class="text-white opacity-75 fw-semibold mb-5">
                                                                   Order #  : <?php echo $order['sales']->sale_id ?>  <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->from_new_time)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->to_new_time)); ?>

                                                              
                                                                </div>
                                                               </div>
                                                               <!--end::Heading-->
                                                               <!--begin::Features-->
                                                                 <!--begin::Select-->
                                                            <div class="w-100 d-flex justify-content-between">
                                                               
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary " onclick="show_view_modal( <?php echo $order['sales']->sale_id; ?>)">
                                                View
                                                                </a>
                                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary  view-btn" data-kt-menunew-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                                <span class="svg-icon svg-icon-5 m-0">
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon--></a>
                                                                <!--begin::Menu-->
                                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                                    
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="javascript:void(0);"   onclick="change_status('Completed' , <?php echo $order['sales']->sale_id; ?>)"  class="menu-link px-3">Mark Completed</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="javascript:void(0);" onclick="show_modal( <?php echo $order['sales']->sale_id; ?>)" class="menu-link px-3">change time </a>
                                                                    </div> 
                                                                    <!--end::Menu item-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 d-none">
                                                                        <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                </div>
                                                                <!--end::Menu-->
                                                               
                                                            </div>
                                                            <!--end::Select-->
                                                              




                                                              <!--end::Select-->
                                                               <!--end::Select-->
                                                           </div>
                                                           <!--end::Option-->
                                                       </div>
                                                   </div>

                                                   <div class="modal fade" tabindex="-1" id="kt_modal_<?php echo $order['sales']->sale_id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Change Status</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-1"></span>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >5</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >10</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >15</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >20</button>
                                                                
                                                                </div>
                                                                <div class="d-flex flex-stack gap-5 mb-3">
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >30</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >40</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >50</button>
                                                                    <button type="button" class="btn btn-light-primary w-25 selecttime" >60</button>
                                                                </div>

                                                                <input type="number" class="form-control form-control-solid time_selected" placeholder="Enter Time" id="time_selected_<?php echo $order['sales']->sale_id; ?>" name="time_selected" value="10" />
                                                            

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">No</button>
                                                                <button type="button" class="btn btn-primary" onclick="change_time(<?php echo $order['sales']->sale_id; ?>)">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal fade" tabindex="-1" id="kt_view_modal_<?php echo $order['sales']->sale_id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Detail</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-1"></span>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                               
                                                            <div class="w-100 mb-10">
                                                            <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>

                                                               
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary " onclick="print_receipt_wrapper(<?php echo $order['sales']->sale_id; ?>)" >
                                                Receipt 
                                                                </a>
                                                            </div>
                                                            

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
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
                                                                   <div data-id="<?php echo    strtotime( $order['sales']->to_new_time) ?>"  class="timer"><?php echo $order['sales']->delivery_type ?></div>
                                                                  
                                                                   <!--end::Title-->
                                                                   <!-- <div   class="timer"><i class="fa fa-check-circle text-light"></i> </div> -->
                                                                   <div class="text-white opacity-75 fw-semibold mb-5">
                                                                   Order #  : <?php echo $order['sales']->sale_id ?>  <br>
                                                                    Form <?php echo date( "h:i A" , strtotime ($order['sales']->date_from)); ?>  
                                                                     to <?php echo date( "h:i A" , strtotime ($order['sales']->date_to)); ?>
                                                                </div>
                                                               </div>
                                                               <div class="w-100 d-flex justify-content-between">
                                                              
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary " onclick="show_view_modal( <?php echo $order['sales']->sale_id; ?>)">
                                                View
                                                                </a>
                                                               </div>
                                                           </div>
                                                           <!--end::Option-->
                                                       </div>
                                                   </div>

                                                   <div class="modal fade" tabindex="-1" id="kt_view_modal_<?php echo $order['sales']->sale_id; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Detail</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-1"></span>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <div class="modal-body">
                                                               
                                                            <div class="w-100 mb-10">
                                                            <?php $this->load->view('single_card_kitchen' , $order['receipt']) ?>

                                                            <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary " onclick="print_receipt_wrapper(<?php echo $order['sales']->sale_id; ?>)" >
                                                                        Receipt 
                                                                </a>

                                                            </div>
                                                            

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" onclick="closebtn()"  class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                   <?php endforeach; else: echo " <div class='text-center fw-bold'> No record found </div>"; endif; ?>
                                            </div>
                                        </div>

                                            


                                </div>
                                
                               <script>

function print_receipt_wrapper(id){
        console.log(id);
        $.ajax({
                                                        type: 'POST',
                                                        url: '<?php echo site_url("sales/kitchen_receipt"); ?>',
                                                        data: {  'id' : id  },
                                                        success: function(res){
                                                                $('#printdiv').html(res);
                                                                $('#printdiv').hide();
                                                            let element = document.getElementById('receipt_wrapper');

                                                                // Store original background color
                                                                let originalBG = element.style.backgroundColor;

                                                                // Temporarily change the background color to white
                                                                element.style.backgroundColor = 'white';

                                                                // Capture the element with html2canvas
                                                                html2canvas(element).then(function(canvas) {
                                                                    // Revert the background color back to its original
                                                                    element.style.backgroundColor = originalBG;

                                                                    let imgData = canvas.toDataURL('image/png');
                                                                    printJS({
                                                                        printable: imgData,
                                                                        type: 'image',
                                                                    });
                                                                    $('#printdiv').hide();
                                                                });


                                                            }
                                                        });
    }
          

    
$(document).ready(function () {
    
    $('.selecttime').on('click', function() {
    var selectedTime = $(this).text(); // Get the text of the clicked button
    var modalBody = $(this).closest('.modal-body'); // Get the parent modal of the clicked button
    var inputField = modalBody.find('.time_selected'); // Find the input field within the modal
    inputField.val(selectedTime); // Update the value of the input field
});
});

function check_item_sale(item , salesid , st , dt){
    if(st){
        $(dt).removeClass();
        $(dt).addClass('fa fa-check-circle  text-success fs-1');
    }else{
        $(dt).removeClass();
        $(dt).addClass('fa fa-circle  text-primary fs-1');
    }
   
    $.ajax({
											type: 'POST',
											url: '<?php echo site_url("booking/change_sales_item_status"); ?>',
											data: { item:item , salesid:salesid , st },
											success: function(result){
                                            }
    })
}




                               </script>

                              
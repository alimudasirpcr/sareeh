<?php $this->load->view("partial/header_standalone"); ?>
 <style>
    /* Custom styles */
    .header {
      background-color: #489ee7;
      color: white;
      text-align: center;
      padding: 10px;
    }
    .search-box {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .input-group-lg {
      margin-top: 20px;
    }
    .form-control {
      font-size: 32px;
      height: auto;
      padding: 10px;
    }
    .input-group-addon {
      font-size: 24px;
    }
    .btn-lg {
      font-size: 32px;
      padding: 20px 40px;
      background-color: #489ee7;
      border: none;
      margin-top: 20px;
    }
    .container {
      margin-top: 80px;
    }
	
    .error-message {
         background-color: #ff8080;
         color: white;
         font-size: 28px;
         font-weight: bold;
         padding: 15px;
         border-radius: 10px;
         margin-bottom: 20px;
       }
  </style>
 <!-- Header -->
   <div class="header">
     <h1><?php echo $this->config->item('company')?></h1>
   </div>

   <!-- Main Content -->
   <div class="container">
     <div class="row">
       <div class=" m-auto col-sm-6 ">
		
         <div class="search-box">
          <form action="" method="GET" id="lookup">
           <h2><?php echo lang('start_typing_meter_number')?></h2>
           <div class="input-group input-group-lg">
             <input id="search" type="text" class="form-control" placeholder="" name="search">
           </div>
           <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo lang('get_receipt')?></button>
         	</form>
		 </div>
       </div>
     </div>
   </div>

<?php $this->load->view("partial/footer_standalone"); ?>
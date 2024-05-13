<?php
require_once ("Secure_area.php");
class Receipt extends Secure_area 
{
	public $log_text = '';

	function _log($msg)
	{
		$msg = date(get_date_format().' h:i:s ').': '.$msg."\n"; 
		if (is_cli())
		{
			echo $msg;
		}
		$this->log_text.=$msg;
	}

	function _save_log()
	{
		$CI =& get_instance();	
		$CI->load->model("Appfile");
		$this->Appfile->save('quickbooks_log.txt',$this->log_text,'+72 hours');
	}

	function __construct()
	{
		parent::__construct('receipt');
		$this->module_access_check();
		$this->lang->load('config');
		$this->lang->load('module');	
		$this->load->model('Appfile');	
		$this->load->model('Sale');
		$this->load->model('License_lib');
	}

    public function index(){
		//  $result = get_query_data('SELECT GROUP_CONCAT(module_id) AS module_ids FROM phppos_modules');

		//  echo "<pre>";
		// 	print_r($result);
		//  exit();
		// $this->load->library('License_lib');
		 // $res = $this->License_lib->generate_license(1);
		//  $res = $this->License_lib->check_license();
		//   echo "<pre>";
		//   print_r($res);
		//   exit();
	
		$query = $this->db->query("select * from phppos_receipts_template");
		$data['receipts'] = $query->result_array();
		$this->load->view("customize_receipts", $data);
	}

	public function add_custom_label()
	{
		$custom_label_id = $this->input->post('custom_label_id');
		$label_name = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', strtolower($custom_label_id)));

		$recp = $this->input->post('receipt');
		 $id = save_data('phppos_receipts_template_label' , [
			'receipts_template_id' =>  $recp ,
			'label_name'=>$label_name,
			'label_text'=>$custom_label_id,
			'is_general'=>0,
		]);

		?>


                <div class="draggable d-flex align-items-center my-1 py-3 bg-light  rounded-1 "
                    style="position: relative; text-wrap:nowrap; width:100%;" id="<?php echo $label_name; ?>">
                    <!--begin::Icon-->
                    <div class="d-flex h-25px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 6C5.10457 6 6 5.10457 6 4C6 2.89543 5.10457 2 4 2C2.89543 2 2 2.89543 2 4C2 5.10457 2.89543 6 4 6Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M14 12C14 13.1 13.1 14 12 14C10.9 14 10 13.1 10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12ZM4 10C2.9 10 2 10.9 2 12C2 13.1 2.9 14 4 14C5.1 14 6 13.1 6 12C6 10.9 5.1 10 4 10ZM20 10C18.9 10 18 10.9 18 12C18 13.1 18.9 14 20 14C21.1 14 22 13.1 22 12C22 10.9 21.1 10 20 10ZM12 2C10.9 2 10 2.9 10 4C10 5.1 10.9 6 12 6C13.1 6 14 5.1 14 4C14 2.9 13.1 2 12 2ZM20 2C18.9 2 18 2.9 18 4C18 5.1 18.9 6 20 6C21.1 6 22 5.1 22 4C22 2.9 21.1 2 20 2ZM12 18C10.9 18 10 18.9 10 20C10 21.1 10.9 22 12 22C13.1 22 14 21.1 14 20C14 18.9 13.1 18 12 18ZM4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C5.1 22 6 21.1 6 20C6 18.9 5.1 18 4 18ZM20 18C18.9 18 18 18.9 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 18.9 21.1 18 20 18Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </div>

                    <div class="kt-dark fw-bold fs-6 lh-lg">
                        <?php echo $custom_label_id ?>
                    </div>
                </div>

                <?php
	}

	public function customize_receipt($id){
		$query = $this->db->query("select * from phppos_receipts_template where id=".$id." ");
		$data['receipt'] = $query->result_array()[0];
		// $data['is_pos'] = true;
		$data['minimize_sidebar'] = 'on';
		$data['receipt_builder'] = true;

		$data['gallery_images'] = $this->Appfile->get_gallery_images();
		$query = $this->db->query("select * from phppos_receipts_template_label where receipts_template_id=".$id." or is_general=1 ");
		$data['labels'] = $query->result_array();

		$this->load->view("customize_receipt", $data);
	}
	

	public function update_receipt(){
		$tables = $this->input->post('tables');
		$checks = $this->input->post('checks');

		$data = json_decode($tables, true);  // Set 'true' to decode as associative array
		$data = array_reverse($data);
			// Create an associative array to store unique IDs
			$unique_ids = [];

			// Loop through the data to filter by unique IDs
			foreach ($data as $entry) {
				$id = $entry['id'];
				
				if (!array_key_exists($id, $unique_ids)) {
					// If the ID is not already in the unique_ids, add it
					$unique_ids[$id] = $entry;
				}
			}


			$unique_data = json_encode(array_values($unique_ids)); 
		$recp = $this->input->post('receipt');
		if($_POST["background_image_id"]){
			$background_image=$_POST["background_image_id"];
		}
			$data_up =	['positions' =>$unique_data , 'checks' => $checks];
		if($background_image!=''){
			$data_up['background_image'] =$background_image;
		 }

		 $first_page_items = $this->input->post('first_page_items');
		$other_page_items = $this->input->post('other_page_items');
		if($first_page_items!=''){
			$data_up['first_page_items'] =$first_page_items;
		 }
		 if($other_page_items!=''){
			$data_up['other_page_items'] =$other_page_items;
		 }
		 $table_image_position = $this->input->post('table_image_position');
		 if($table_image_position!=''){
			$data_up['table_image_position'] =$table_image_position;
		 }
		 $table_image_size = $this->input->post('table_image_size');
		 if($table_image_size!=''){
			$data_up['table_image_size'] =$table_image_size;
		 }
		 $table_element_order = $this->input->post('table_element_order');
		 if($table_element_order!=''){
			$data_up['table_element_order'] =$table_element_order;
		 }
		update_data('phppos_receipts_template',  $data_up , $recp );
		echo "true";
	}

	public function update_receipt_detail(){

		$custom_logo='';
		if(!empty($_FILES["custom_logo"]) && $_FILES["custom_logo"]["error"] == UPLOAD_ERR_OK  )
		{
			$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
			$extension = strtolower(pathinfo($_FILES["custom_logo"]["name"], PATHINFO_EXTENSION));
			
			if (in_array($extension, $allowed_extensions))
			{
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["custom_logo"]["tmp_name"];
				$this->load->library('image_lib', $config); 
				
				$custom_logo = $this->Appfile->save($_FILES["custom_logo"]["name"], file_get_contents($_FILES["custom_logo"]["tmp_name"]), NULL, $this->input->post('delete_custom_logo'));
			}
		}
		$background_image='';
		if(!empty($_FILES["background_image"]) && $_FILES["background_image"]["error"] == UPLOAD_ERR_OK )
		{
			$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
			$extension = strtolower(pathinfo($_FILES["background_image"]["name"], PATHINFO_EXTENSION));
			
			if (in_array($extension, $allowed_extensions))
			{
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_FILES["background_image"]["tmp_name"];
				$this->load->library('image_lib', $config); 
				
				$background_image = $this->Appfile->save($_FILES["background_image"]["name"], file_get_contents($_FILES["background_image"]["tmp_name"]), NULL, $this->input->post('delete_background_image'));
			}
		}

		if($_POST["background_image_id"]){
			$background_image=$_POST["background_image_id"];
		}

		$title = $this->input->post('title');
		$size = $this->input->post('size');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$status = $this->input->post('status');
		$template_group = $this->input->post('template_group');
		
		$default_wo = $this->input->post('default_wo');
		$default_pos = $this->input->post('default_pos');
		$header_percentage = $this->input->post('header_percentage');
		$body_percentage = $this->input->post('body_percentage');
		$footer_percentage = $this->input->post('footer_percentage');
		$default_estimate = $this->input->post('default_estimate');
		$id = $this->input->post('id');
		
		 $data= array(
			'title' =>$title,
			'size' =>$size,
			'width' =>$width,
			'height' =>$height,
			'status' =>$status,
			'template_group' =>$template_group,
			'default_wo' =>$default_wo,
			'default_pos' =>$default_pos,
			'header_percentage' =>$header_percentage,
			'body_percentage' =>$body_percentage,
			'footer_percentage' =>$footer_percentage,
			'default_estimate' =>$default_estimate,
		 );
		 if($custom_logo!=''){
			$data['logo_image'] =$custom_logo;
		 }
		 if($background_image!=''){
			$data['background_image'] =$background_image;
		 }
		update_data('phppos_receipts_template', 
		$data, $id );
		redirect('Receipt/customize_receipt/'.$id);
	}

	public function submitForm(){
		$checks = '["checkbox_item_name","checkbox_item_price","checkbox_item_quantity","checkbox_item_total","checkbox_element_variation_name","checkbox_element_description","checkbox_element_item_serialnumber","checkbox_custom_fields_to_display","checkbox_element_item_kit_info_name","checkbox_element_item_kit_custom_fields_to_display","checkbox_element_discount","checkbox_element_image"]';
		$title = $this->input->post('title');
		save_data('phppos_receipts_template', ['title' =>$title , 'checks' => $checks]  );
		echo json_encode(['success' => true]);
	}

	public  function delete(){
		$id = $this->input->post('form_id');
		delete_data('phppos_receipts_template',$id);
		echo json_encode(['success' => true]);
	}

}
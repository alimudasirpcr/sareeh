<?php
trait taxOverrideTrait
{
	public function edit_taxes()
	{
		$data = array();
		$data['controller_name']=strtolower(get_class());
		$data['tax_info'] = $this->cart->get_override_tax_info();
		$data['tax_class_selected'] = $this->cart->override_tax_class;
		$data['tax_classes'] = array();
		$data['tax_classes'][''] = lang('none');
		
		foreach($this->Tax_class->get_all()->result_array() as $tax_class)
		{
			$data['tax_classes'][$tax_class['id']] = $tax_class['name'];
		}
		
		$this->load->view("tax_override",$data);
		
	}
	
	function save_tax_overrides()
	{
		$data = array();
		$this->cart->override_tax_names = $this->input->post('tax_names');
		$this->cart->override_tax_percents = $this->input->post('tax_percents');
		$this->cart->override_tax_cumulatives = $this->input->post('tax_cumulatives');
		$this->cart->override_tax_class = $this->input->post('tax_class');
		$this->cart->save();
  		$this->sales_reload($data);
		
	}

	function save_tax_overrides_rep(){
		$max = 4;
		$data = array();
		$tax_names = array();
		$tax_percents = array();
		$tax_cumulatives =array(0,0,0,0,0);
		if($this->input->post('tax_class')==''){
			for($i=0; $i<=$max; $i++){
				if(isset($_POST['kt_docs_repeater_basic'][$i]['tax_names'])){
					$tax_names[$i] =	$_POST['kt_docs_repeater_basic'][$i]['tax_names'];
					$tax_percents[$i] =	$_POST['kt_docs_repeater_basic'][$i]['tax_percents'];
				}
			
			};
		}	
		
		
		$this->cart->override_tax_names = $tax_names;
		$this->cart->override_tax_percents = $tax_percents;
		$this->cart->override_tax_cumulatives = $tax_cumulatives;
		$this->cart->override_tax_class = $this->input->post('tax_class');
		$this->cart->save();
  		$this->sales_reload($data);
	}
	
	public function edit_taxes_line($line)
	{
		$data = array();
		$data['controller_name']=strtolower(get_class());
		$data['line']=$line;
		$data['tax_info'] = $this->cart->get_item($line)->get_override_tax_info();
		$data['tax_class_selected'] = $this->cart->get_item($line)->override_tax_class;
		
		$data['tax_classes'] = array();
		$data['tax_classes'][''] = lang('none');
		
		foreach($this->Tax_class->get_all()->result_array() as $tax_class)
		{
			$data['tax_classes'][$tax_class['id']] = $tax_class['name'];
		}
		
		$this->load->view("tax_override",$data);
		
	}
	
	function save_tax_overrides_line($line)
	{
		$data = array();
		$this->cart->get_item($line)->override_tax_names = $this->input->post('tax_names');
		$this->cart->get_item($line)->override_tax_percents = $this->input->post('tax_percents');
		$this->cart->get_item($line)->override_tax_cumulatives = $this->input->post('tax_cumulatives');
		$this->cart->get_item($line)->override_tax_class = $this->input->post('tax_class');
		$this->cart->save();
  		$this->sales_reload($data);
		
	}
}
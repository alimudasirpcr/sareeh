<?php
require_once ("Secure_area.php");

defined('BASEPATH') OR exit('No direct script access allowed');

class Installer extends Secure_area {

   
    
    public function industries() {
        $this->load->view('add_industries');
        

    }

    public function add()
{
    $this->load->library('upload');
    $this->load->model('Appfile');

   
    $name = $this->input->post('name');
    $category_name = $this->input->post('category_name');

    if (empty($name) || empty($category_name) || !isset($_FILES['image'])) {
        $this->session->set_flashdata('error', 'All fields are required.');
        redirect('Installer/industries');
        return;
    }

    
    $this->db->where('category_name', $category_name);
    $query = $this->db->get('industries');

    if ($query->num_rows() > 0) {
        $this->session->set_flashdata('error', 'Category already exists.');
        redirect('Installer/industries');
        return;
    }

    
    $config['image_library'] = 'gd2';
    $config['source_image'] = $_FILES["image"]["tmp_name"];
    $config['create_thumb'] = FALSE;
    $config['maintain_ratio'] = TRUE;
    $config['width'] = 1200;
    $config['height'] = 900;

  

   
    $category_image_id = $this->Appfile->save(
        $_FILES["image"]["name"],
        file_get_contents($_FILES["image"]["tmp_name"]),
        NULL,
        NULL
    );

 
    $data = array(
        'name' => $name,
        'category_name' => $category_name,
        'image' => $category_image_id
    );

    if ($this->db->insert('industries', $data)) {
        $this->session->set_flashdata('success', 'Record added successfully with Image ID: ' . $category_image_id);
    } else {
        $this->session->set_flashdata('error', 'Failed to insert record.');
    }

  
    redirect('Installer/industries');
}


    public function add_categories() {
        $pos_industry = getenv('POS_INDUSTRY'); 
    
        if (!$pos_industry) {
            echo "POS INDUSTRY is not set.";
            return;
        }
    
        
        $this->db->select('category_name');
        $this->db->select('image');

        $this->db->where('name', $pos_industry);
        $query = $this->db->get('industries');
    
        if (!$query) {
            echo "No Category Found " ;
            return;
        }
    
        if ($query->num_rows() > 0) {
            $categories = $query->result();
    
            foreach ($categories as $row) {
               
                $this->db->where('name', $row->category_name);
                $exists_category = $this->db->get('categories');
    
                if ($exists_category->num_rows() == 0) {
                   
                    $data = array(
                        'name' => $row->category_name,
                        'image_id' => $row->image,
                
                    );
                    $this->db->insert('categories', $data);
                    echo "Added category:".$row->category_name."<br>";
                } else {
                    echo "Category already exists:".$row->category_name."<br>";
                }
            }
        } else {
            echo "No matching categories found.";
        }
    }
    
}
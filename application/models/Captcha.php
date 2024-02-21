<?php 

class Captcha extends MY_Model {
    public function __construct()
	{
      parent::__construct();
         $this->load->helper('captcha');	
	}

    public function create_captcha(){
        $this->load->helper('captcha');
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url().'captcha/',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 100,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(200, 200, 200)
        )
        );
    
        $cap = create_captcha($vals);
    
            $data = array(
                'captcha_time'  => $cap['time'],
                'ip_address'    => $this->input->ip_address(),
                'word'          => $cap['word']
        );
        $query = $this->db->insert('captcha', $data);

        return $cap;
    }
}
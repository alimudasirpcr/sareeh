<?php
class Booking extends CI_Controller 
{	
		

        public function index(){
  


             $tables = get_query_data('select * from phppos_tables ', 'array');
             $new_table=array();
             $i=0;
             foreach( $tables as $table){
                $chairs = get_query_data('select * from phppos_charis where table_id='.$table['id'].' ', 'array');
                $new_table[$i]['table'] = $table;
                $new_table[$i]['chairs'] = $chairs;
                $i++;
             }
            $data['tablest'] = $new_table ; 
            $this->load->view('booking' ,  $data);
        }

        public function save_position(){
                $tables = json_decode($this->input->post('tables'));
               foreach($tables as $table){
                    if(isset($table->id)){
                      
                        update_data('phppos_tables', ['pleft' => $table->newleft , 'ptop' => $table->newtop, 'rotate' => $table->rotate] ,  $table->id );
                        echo "<br>".$this->db->last_query();
                    }
               }

        }

        public function add_table(){
            $title = $this->input->post('title');
            $chairs = $this->input->post('chairs');

             $last_id = save_data('phppos_tables' , ['status' => 'Free' , 'title' => $title, 'ptop' => '25px'   , 'pleft' => '25px' ]);

                for($i=0; $i < $chairs; $i++    ){
                    save_data('phppos_charis', ['table_id' => $last_id , 'status'=> 'free']);
                }
        }

        public function update_chair_status(){
            $status = $this->input->post('status');
            $chair_id = $this->input->post('chair_id');
            update_data('phppos_charis', ['status' => $status ] ,$chair_id  );
        }

        public function update_table_status(){
            $table_status = $this->input->post('table_status');
            $table_id = $this->input->post('table_id');
            $table_title = $this->input->post('table_title');
            update_data('phppos_tables', ['status' => $table_status , 'title' => $table_title  ] ,$table_id  );
        }
}
<?php
require_once (APPPATH."traits/saleTrait.php");
require_once (APPPATH."models/cart/PHPPOSCartSale.php");
class Log extends MY_Model
{
    public function getDatatable($tableName, $columns, $input, $count = false)
    {
        $columnOrder = array_keys($columns); // Array of database column names to be used for ordering.
        $columnSearch = array_filter($columns, function ($key) {
            return $key !== 'default_order';
        }, ARRAY_FILTER_USE_KEY);
        

        $this->db->save_queries = true;
        $where = "where 1=1 ";
        if(isset($input['from_date'])){
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
       
            if ($from_date && $to_date) {
                $where .= " AND CAST(combined.created_at as DATE) BETWEEN '$from_date' AND '$to_date'" ;
            } elseif ($from_date) {
                $where .="AND  CAST(combined.created_at as DATE) >= '$from_date'";
            } elseif ($to_date) {
                $where .=" AND CAST(combined.created_at as DATE) <= '$to_date'";
            }
        }
     

          // Filtering
          $i = 0;
          foreach ($columnSearch as $item) {
             
              if (isset($input['search']) && isset($input['search']['value']) && $input['search']['value'] != '') {
                 $value= $input["search"]['value'];
                  if ($i === 0) {
                      $this->db->group_start();
                      $where .=" AND ( ".$item." like '%". $value ."%' ";
                  } else {
  
                    $where .="  OR ".$item." LIKE  '%". $value ."%' ";
                  }
                  if (count($columnSearch) - 1 == $i) {
                    $where .=")";
                  }
              }
              $i++;
          }
          $i = 0;
          $j = 0;

          foreach ($columnSearch as $item) {
            if (isset($input['columns'][$i]['search']) && isset($input['columns'][$i]['search']['value']) && $input['columns'][$i]['search']['value'] != ''&& $input['columns'][$i]['search']['value'] != '-1' ) {
                $value =   $input['columns'][$i]['search']['value'];
                 if ($j === 0) {
                    $where .="AND ( ".$item." like '%". $value ."%' ";
                 }else{
                    $where .="  AND ".$item." LIKE  '%". $value ."%'  ";
                 }
                $j++;

            }
            $i++;
          }
          if($j > 0){
            $where .="  ) ";
          }
       
        $query ="
        SELECT combined.* ,people.full_name  FROM (
            SELECT id, work_order_id AS main_id, employee_id AS user_id, activity_date AS created_at, activity_text AS comment, 'work_order' AS type FROM phppos_work_order_log
            UNION ALL
            SELECT id, sn_id AS main_id, added_by AS user_id, created_at, remarks AS comment, 'sn_log' AS type FROM phppos_sn_log
            UNION ALL
            SELECT register_log_id AS id, register_id AS main_id, employee_id_open AS user_id, created_at, CONCAT(shift_start, '==',shift_end) AS comment, 'register_log' AS type FROM phppos_register_log
        ) AS combined
        JOIN phppos_employees AS employees ON combined.user_id = employees.id
        JOIN phppos_people AS people ON employees.person_id = people.person_id
        ".$where."
        order by ";
        // dd($query);

        if (isset($input['order'])) {
            $columnIdx = $input['order'][0]['column'];
            $orderBy = $columnOrder[$columnIdx]; // Ensure this matches the DataTables column index sent in the request
            $direction = $input['order'][0]['dir'];
            $this->db->order_by($orderBy, $direction);
            $query.=" ".$orderBy."  ".$direction." ";
        } else if (isset($columns['default_order'])) {
            // Here, we directly access the 'default_order' from the $columns array
            foreach ($columns['default_order'] as $column => $dir) {
                // $this->db->order_by($column, $dir);
                $query.=" ".$column."  ".$dir." ";
                break; // Assuming 'default_order' contains only one column and direction
            }
        }

    


        // Inside your getDatatable function in the model
      
        if (!$count) {
            if (isset($input['length']) && $input['length'] != -1) {
                $start = isset($input['start']) ? $input['start'] : 0;
                $query .="LIMIT ".$input['length']." OFFSET  ". $start." "; 
            }
          
            $query  = $this->db->query( $query);
            // echo $this->db->last_query();
            
            if ($query !== false && $query->num_rows() > 0) {
                return $query->result();
            } else {
                return [];
            }
        } else {

        $this->db->query( $query);

        $query  = $this->db->query( $query);
            if ($query !== false && $query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return 0;
            }
        }


    }

    public function countFiltered($tableName, $columns, $input)
    {
        return $this->getDatatable($tableName, $columns, $input, true);
    }

    public function countAll($tableName)
    {
        $query ="
        SELECT id , work_order_id as main_id , employee_id as user_id ,  activity_date as created_at , activity_text as comment , 'work_order' as type FROM phppos_work_order_log
          UNION ALL
         SELECT id , sn_id as main_id, created_at , added_by as user_id ,  remarks  as comment,  'sn_log'  as type FROM phppos_sn_log 
          UNION ALL
        SELECT register_log_id as id , register_id as main_id , created_at ,employee_id_open as user_id , concat(shift_start , ' ' , 'shift_end' ) as comment , 'register_log' as type from  phppos_register_log 
      ";
      $query  =  $this->db->query( $query);
        return $query->num_rows();
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *
 * Crud helper .
 *
 * @package        Crud helper
 * @author         Mudasir Hussain
 * @version        1.0.0
 * @license        GPL v3
 */


// error_reporting(0);

$ci =& get_instance();

/*----------------------------------------------------------------------------------------------------

*                                      	CRUD OPERATIONS

-----------------------------------------------------------------------------------------------------*/



if ( ! function_exists('save_data')) :

	function save_data($table,$data)

	{

		$ci =& get_instance();

		$ci->db->insert($table, $data); 

		return $ci->db->insert_id();

	} 

endif;



if ( ! function_exists('save_bulk_data')) :

function save_bulk_data($table, $data)

  {

		$ci =& get_instance();

		$ci->db->insert_batch($table, $data);

		return true;

  }

endif;



if ( ! function_exists('update_data')) :

	function update_data($table,$data,$id)

	{

		$ci =& get_instance();

		$ci->db->where('id', $id);

		$ci->db->update($table, $data); 

		return true;

	} 

endif;

if ( ! function_exists('update_data_by_where')) :

	function update_data_by_where($table,$data,$where)
	{

		$ci =& get_instance();

		$ci->db->where($where);	

		$ci->db->update($table, $data); 

	}
endif;



if ( ! function_exists('delete_data')) :

function delete_data($table, $id)

	{
		$ci =& get_instance();

		$ci->db->where('id', $id);

		$ci->db->delete($table);
		return true;
	}

endif;	



if ( ! function_exists('delete_data_by_where')) :

function delete_data_by_where($table, $where)

	{
		$ci =& get_instance();

		$ci->db->where($where);	

		$ci->db->delete($table);

	}

endif;	



if ( ! function_exists('execute_query')) :

function execute_query($sql_query)

	{

		# code...

		$ci =& get_instance();

		$ci->db->query($sql_query);

		return true;

		

	}

endif;



if ( ! function_exists('get_query_data')) :

	function get_query_data($sql_query , $res_type='obj')
	
		{
	
			# code...
	
			$ci =& get_instance();
	
			$data = $ci->db->query($sql_query);
	
			
	
		if ($data !== FALSE && $data->num_rows()>0) {
			if($res_type=='obj'){
				return $data->result();
			}else{
				return $data->result_array();
			}
	
		  
		} else {
			return false;
		}
	
			
	
		}
	
	endif;





if ( ! function_exists('get_total')) :

function get_total($index_colum, $table, $where=''){

		if(!empty($where)){

			$where_clause = " WHERE $where";

		}else{

			$where_clause = "";

		}

		$ci =& get_instance();

	    $sql_query = "SELECT COUNT($index_colum) AS cnt FROM $table  $where_clause";	

	    $query = $ci->db->query($sql_query);					 

		$result = $query->row();

		return $result->cnt; 

	}

endif;



if ( ! function_exists('get_sum')) :

function get_sum($index_colum, $table, $where=''){

		if(!empty($where)){

			$where_clause = " WHERE $where";

		}else{

			$where_clause = "";

		}

		$ci =& get_instance();

	    $sql_query = "SELECT SUM($index_colum) AS cnt FROM $table  $where_clause";	

	    $query = $ci->db->query($sql_query);					 

		$result = $query->row();

		return $result->cnt; 

	}

endif;



if ( ! function_exists('get_average')) :

function get_average($index_colum, $table, $where=''){

		if(!empty($where)){

			$where_clause = " WHERE $where";

		}else{

			$where_clause = "";

		}

		$ci =& get_instance();

	    $sql_query = "SELECT AVG($index_colum) AS cnt FROM $table  $where_clause";	

	    $query = $ci->db->query($sql_query);					 

		$result = $query->row();

		return $result->cnt; 

	}

endif;



if ( ! function_exists('select_data')) :

	function select_data($table, $where,$order='')

	{

		$ci =& get_instance();

		$ci->db->select('*');

		$ci->db->from($table);

		$ci->db->where($where);

		if( !empty($order) && isset($order) ):

		      $ci->db->order_by($order);

		endif;

		$query = $ci->db->get();

		return $query->result();

	} 

endif;



if ( ! function_exists('select_columns')) :

function select_columns($colulmns,$table, $where,$order='')

      {

	      	$ci =& get_instance();

	      	$ci->db->select($colulmns);

			$ci->db->from($table);

			$ci->db->where($where);

			if( !empty($order) && isset($order) ):

		      $ci->db->order_by($order);

		    endif;

			$query = $ci->db->get();

			return $query->result();

      }

endif;



if ( ! function_exists('select_column_name')) :

 function select_column_name($col,$table,$id){
// $id=12121212;
	        $ci =& get_instance();

            $ci->db->select($col);

		    $ci->db->from($table);

			$ci->db->where('id', $id);
			$data = $ci->db->get();
			
			if ($data !== FALSE && $data->num_rows()>0) {
		
			return	$get_col =  $data->row()->$col;
	
		  
		} else {
			return false;
		}



		

}

endif;


if ( ! function_exists('select_column_name_find_in_set')) :

 function select_column_name_find_in_set($val,$col,$table,$id){

	        $ci =& get_instance();

            $ci->db->select('FIND_IN_SET("'.$val.'", '.$col.' ) as val');

		    $ci->db->from($table);

			$ci->db->where('id', $id);
			
	return	$get_col =  $ci->db->get()->row()->val;	

}

endif;

if ( ! function_exists('select_column_name_by_where')) :

 function select_column_name_by_where($col,$table,$where){

	        $ci =& get_instance();

            $ci->db->select($col);

		    $ci->db->from($table);

			$ci->db->where($where);

	return	$get_col =  $ci->db->get()->row()->$col;	

}

endif;
if ( ! function_exists('select_column_name_find_in_set_by_where')) :

 function select_column_name_find_in_set_by_where($val,$col,$table,$where){

	        $ci =& get_instance();

            $ci->db->select('FIND_IN_SET("'.$val.'", '.$col.' ) as val');

		    $ci->db->from($table);

			$ci->db->where($where);

	return	$get_col =  $ci->db->get()->row()->val;	

}
endif;


if ( ! function_exists('get_data_row')) :

function get_data_row($table,$where)

	{

$ci =& get_instance();

		$ci->db->from($table);



		$ci->db->where($where);



		$query = $ci->db->get();



		return $query->row();



	}

endif;




// if ( ! function_exists('hr_datetime')) :

// function hr_datetime($datetime){

	   

// 	   return date('d/m/Y g:i a', strtotime($datetime));

//   }

// endif;
// if ( ! function_exists('get_datetime_format')) :
// function get_datetime_format($datetime){
// 	   return date('d-m-Y h:i a', strtotime($datetime));

//   }
// endif;
// if ( ! function_exists('get_date_format')) :
// function get_date_format($datetime){
// 	   return date('d-m-Y', strtotime($datetime));
//   }
// endif;


if ( ! function_exists('mysql_date')) :

function mysql_date($start_date) {

if( empty($start_date)){

			$start_date = date('Y-m-d');

		}else{

			$date_format = explode('/', $start_date);

			$start_date = $date_format[2].'-'.$date_format[1].'-'.$date_format[0];  

	}

	return $start_date;

 }	

endif;


// function is_connected()
// {
//     $connected = @fsockopen("www.example.com", 80); 
//                                         //website, port  (try 80 or 443)
//     if ($connected){
//         $is_conn = true; //action when connected
//         fclose($connected);
//     }else{
//         $is_conn = false; //action in connection failure
//     }
//     return $is_conn;

// }


// function get_auto_generate_password($digits)
// {
// 	$num='';
// 	for($k=0;$k<$digits;$k++)
// 	{
//      $num.='9';
// 	}
//     $num=(int)$num;
// 	$password=str_pad(mt_rand(1,$num),$digits,'0',STR_PAD_LEFT);
// 	return $password;
// }


// if ( ! function_exists('get_date_format')) :
// 	function get_date_format($date){
//    return date(DATE_FORMAT ,strtotime($date));
// }
// 	endif;

	

// 	if ( ! function_exists('get_datetime_format')) :
// 	function get_datetime_format($datetime){
//     return date(DATE_FORMAT.' '.TIME_FORMAT ,strtotime($datetime));
// }
// 	endif;



// 	if ( ! function_exists('get_number_format')) :
// 	function get_number_format($number){
//   		return	number_format($number,3);
// 		}
// 	endif;



// if ( ! function_exists('get_substring')) :
// function get_first_substring($string , $num){

// $words = explode(" ", $string);
// $first = join(" ", array_slice($words, 0, $num));
// //$rest = join(" ", array_slice($words, 5));
// return $first;

	
// }
// endif;


// function is_in_array_associative_via_key_value($array, $key, $key_value){
//       $within_array = 'no';
//       foreach( $array as $k=>$v ){
//         if( is_array($v) ){
//             $within_array = is_in_array($v, $key, $key_value);
//             if( $within_array == 'yes' ){
//                 break;
//             }
//         } else {
//                 if( $v == $key_value && $k == $key ){
//                         $within_array = 'yes';
//                         break;
//                 }
//         }
//       }
//       return $within_array;
// }
// function is_in_array_via_key_value($array, $key , $key_value){
	
//       $within_array = 'no';
//       foreach( $array as $k  ){
//                  $k = (array)$k;
//                if( $k[$key] == $key_value){
//                        $within_array = 'yes';
//                        break;
//                }
        
//       }

//       return $within_array;
// }



?>

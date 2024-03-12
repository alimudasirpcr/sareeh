<?php defined('BASEPATH') or exit('No direct script access allowed');


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

$ci = &get_instance();

/*----------------------------------------------------------------------------------------------------

*                                      	CRUD OPERATIONS

-----------------------------------------------------------------------------------------------------*/



if (!function_exists('save_data')) :

	function save_data($table, $data)

	{

		$ci = &get_instance();

		$ci->db->insert($table, $data);

		return $ci->db->insert_id();
	}

endif;



if (!function_exists('save_bulk_data')) :

	function save_bulk_data($table, $data)

	{

		$ci = &get_instance();

		$ci->db->insert_batch($table, $data);

		return true;
	}

endif;



if (!function_exists('update_data')) :

	function update_data($table, $data, $id)

	{

		$ci = &get_instance();

		$ci->db->where('id', $id);

		$ci->db->update($table, $data);

		return true;
	}

endif;

if (!function_exists('update_data_by_where')) :

	function update_data_by_where($table, $data, $where)
	{

		$ci = &get_instance();

		$ci->db->where($where);

		$ci->db->update($table, $data);
	}
endif;



if (!function_exists('delete_data')) :

	function delete_data($table, $id)

	{
		$ci = &get_instance();

		$ci->db->where('id', $id);

		$ci->db->delete($table);
		return true;
	}

endif;



if (!function_exists('delete_data_by_where')) :

	function delete_data_by_where($table, $where)

	{
		$ci = &get_instance();

		$ci->db->where($where);

		$ci->db->delete($table);
	}

endif;



if (!function_exists('execute_query')) :

	function execute_query($sql_query)

	{

		# code...

		$ci = &get_instance();

		$ci->db->query($sql_query);

		return true;
	}

endif;



if (!function_exists('get_query_data')) :

	function get_query_data($sql_query, $res_type = 'obj')

	{

		# code...

		$ci = &get_instance();

		$data = $ci->db->query($sql_query);



		if ($data !== FALSE && $data->num_rows() > 0) {
			if ($res_type == 'obj') {
				return $data->result();
			} else {
				return $data->result_array();
			}
		} else {
			return false;
		}
	}

endif;





if (!function_exists('get_total')) :

	function get_total($index_colum, $table, $where = '')
	{

		if (!empty($where)) {

			$where_clause = " WHERE $where";
		} else {

			$where_clause = "";
		}

		$ci = &get_instance();

		$sql_query = "SELECT COUNT($index_colum) AS cnt FROM $table  $where_clause";

		$query = $ci->db->query($sql_query);

		$result = $query->row();

		return $result->cnt;
	}

endif;



if (!function_exists('get_sum')) :

	function get_sum($index_colum, $table, $where = '')
	{

		if (!empty($where)) {

			$where_clause = " WHERE $where";
		} else {

			$where_clause = "";
		}

		$ci = &get_instance();

		$sql_query = "SELECT SUM($index_colum) AS cnt FROM $table  $where_clause";

		$query = $ci->db->query($sql_query);

		$result = $query->row();

		return $result->cnt;
	}

endif;



if (!function_exists('get_average')) :

	function get_average($index_colum, $table, $where = '')
	{

		if (!empty($where)) {

			$where_clause = " WHERE $where";
		} else {

			$where_clause = "";
		}

		$ci = &get_instance();

		$sql_query = "SELECT AVG($index_colum) AS cnt FROM $table  $where_clause";

		$query = $ci->db->query($sql_query);

		$result = $query->row();

		return $result->cnt;
	}

endif;



if (!function_exists('select_data')) :

	function select_data($table, $where, $order = '')

	{

		$ci = &get_instance();

		$ci->db->select('*');

		$ci->db->from($table);

		$ci->db->where($where);

		if (!empty($order) && isset($order)) :

			$ci->db->order_by($order);

		endif;

		$query = $ci->db->get();

		return $query->result();
	}

endif;



if (!function_exists('select_columns')) :

	function select_columns($colulmns, $table, $where, $order = '')

	{

		$ci = &get_instance();

		$ci->db->select($colulmns);

		$ci->db->from($table);

		$ci->db->where($where);

		if (!empty($order) && isset($order)) :

			$ci->db->order_by($order);

		endif;

		$query = $ci->db->get();

		return $query->result();
	}

endif;



if (!function_exists('select_column_name')) :

	function select_column_name($col, $table, $id)
	{
		// $id=12121212;
		$ci = &get_instance();

		$ci->db->select($col);

		$ci->db->from($table);

		$ci->db->where('id', $id);
		$data = $ci->db->get();

		if ($data !== FALSE && $data->num_rows() > 0) {

			return	$get_col =  $data->row()->$col;
		} else {
			return false;
		}
	}

endif;


if (!function_exists('select_column_name_find_in_set')) :

	function select_column_name_find_in_set($val, $col, $table, $id)
	{

		$ci = &get_instance();

		$ci->db->select('FIND_IN_SET("' . $val . '", ' . $col . ' ) as val');

		$ci->db->from($table);

		$ci->db->where('id', $id);

		return	$get_col =  $ci->db->get()->row()->val;
	}

endif;

if (!function_exists('select_column_name_by_where')) :

	function select_column_name_by_where($col, $table, $where)
	{

		$ci = &get_instance();

		$ci->db->select($col);

		$ci->db->from($table);

		$ci->db->where($where);
		$data = $ci->db->get();

		if ($data !== FALSE && $data->num_rows() > 0) {

			return	  $data->row()->$col;
		} else {
			return false;
		}
		// return	$get_col =  $ci->db->get()->row()->$col;	

	}

endif;
if (!function_exists('select_column_name_find_in_set_by_where')) :

	function select_column_name_find_in_set_by_where($val, $col, $table, $where)
	{

		$ci = &get_instance();

		$ci->db->select('FIND_IN_SET("' . $val . '", ' . $col . ' ) as val');

		$ci->db->from($table);

		$ci->db->where($where);

		return	$get_col =  $ci->db->get()->row()->val;
	}
endif;


if (!function_exists('get_data_row')) :

	function get_data_row($table, $where)

	{

		$ci = &get_instance();

		$ci->db->from($table);



		$ci->db->where($where);



		$query = $ci->db->get();



		return $query->row();
	}

endif;


if (!function_exists('save_query')) :

	function save_query()

	{
		$ci = &get_instance();
		$ci->db->save_queries = true;
	}

endif;

if (!function_exists('pq')) :

	function pq()

	{
		$ci = &get_instance();
		echo $ci->db->last_query();
		exit();
	}

endif;

if (!function_exists('is_master_user')) :

	function is_master_user()

	{

		$CI = &get_instance();
		$id = select_column_name_by_where('id', 'phppos_employees', ['person_id' => $CI->session->userdata('person_id')]);

		return (getenv('MASTER_USER') != $id) ? false : true;
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


if (!function_exists('mysql_date')) :

	function mysql_date($start_date)
	{

		if (empty($start_date)) {

			$start_date = date('Y-m-d');
		} else {

			$date_format = explode('/', $start_date);

			$start_date = $date_format[2] . '-' . $date_format[1] . '-' . $date_format[0];
		}

		return $start_date;
	}

endif;


if (!function_exists('save_notification')) :

	function save_notification($data)
	{
		save_data('phppos_notifications', $data);
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





function isPrime($num)
{
	if ($num < 2) return false;
	for ($i = 2; $i <= sqrt($num); $i++) {
		if ($num % $i == 0) {
			return false;
		}
	}
	return true;
}

function isOdd($num)
{
	return $num % 2 == 1;
}

function calculateTableWidth($numChairs)
{
	$baseWidth = 150;
	$extraWidth = 0;

	if ($numChairs > 4) {


		for ($i = 5; $i <= $numChairs; $i++) {
			if (isOdd($i)) {

				$extraWidth +=  150;
			}
		}
	}

	return $baseWidth + $extraWidth;
}
function calculatesecondchairposition($numChairs)
{
	$baseWidth = 150;
	$extraWidth = 0;

	if ($numChairs > 4) {
		for ($i = 5; $i <= $numChairs; $i++) {
			if (isOdd($i)) {
				$extraWidth +=  146;
			}
		}
	}

	return $baseWidth + $extraWidth;
}


function module_access_check($module_id)
{


	$ci = &get_instance();
	$module_ids = $ci->session->userdata('module_ids');
	if ($module_ids == null) {
		redirect('no_access/' . $module_id);
	}
	if (!in_array($module_id, $module_ids)) {
		redirect('no_access/' . $module_id);
	}
}
function dd($array)
{
	echo "<pre>";
	print_r($array);
	exit();
}
function module_access_check_view($module_id)
{


	$ci = &get_instance();
	$module_ids = $ci->session->userdata('module_ids');
	if ($module_ids == null) {
		return false;
	}
	if (!in_array($module_id, $module_ids)) {
		return false;
	} else {
		return true;
	}
}

function check_allowed_module($array, $id)
{
	$recordFound = false;

	// Iterate through the array
	foreach ($array as $object) {
		// Check if the 'module_id' property of the object is 'customers'
		if ($object->module_id ==  $id) {
			$recordFound = true;
			break; // Exit the loop if the record is found
		}
	}

	return $recordFound;
}

function get_quick_access()
{
	$CI = &get_instance();
	$data = $CI->Employee->get_logged_in_employee_info()->quick_access;

	if ($data) {
		return json_decode($data);
	}
	return false;
}

function check_count($variable)
{
	if (is_array($variable) || $variable instanceof Countable) {
		$count = count($variable);
	} else {
		// Handle the non-countable case
		$count = 0;
	}
}

function log_db_update($table, $query)
{
	$backtrace = debug_backtrace();
	$caller = isset($backtrace[1]) ? $backtrace[1] : null;

	if ($caller) {
		$logMessage = "Table '{$table}' updated. File: {$caller['file']}, Line: {$caller['line']}, Query: {$query}";
		log_message('info', $logMessage);
	}
}
if (!function_exists('custom_anchor')) {
    function custom_anchor($uri = '', $title = '', $attributes = '') {
        if (!preg_match('/^#.*/', $uri)) {
            return anchor($uri, $title, $attributes);
        } else {
            // Directly handle on-page anchors
            $title = (string) $title;
            $site_url = is_array($uri) ? site_url($uri) : $uri;
            if ($title == '') {
                $title = $site_url;
            }

            if ($attributes != '') {
                $attributes = _stringify_attributes($attributes);
            }

            return '<a href="' . $site_url . '"' . $attributes . '>' . $title . '</a>';
        }
    }
}
function generate_action_template($permission, $icon, $bgColor, $url, $lang_key, $extra_classes = '', $target = '_self' , $is_full = false , $id='')
{
	if ($permission) {
?>
		<div class="d-flex flex-stack">
			<div class="symbol symbol-30px me-4">
				<div class="symbol-label fs-2 fw-semibold <?php echo $bgColor; ?> text-inverse-<?php echo $bgColor; ?>">
					<i class="<?php echo $icon; ?> text-light"></i>
				</div>
			</div>
			<div class="d-flex align-items-center flex-row-fluid flex-wrap">
				<div class="flex-grow-1 me-2">
					<?php echo custom_anchor(
						$url,
						lang($lang_key),
						array('target' => $target,'id' => $id, 'class' => 'text-gray-800 text-hover-primary fs-6 fw-bold ' . $extra_classes, 'title' => lang($lang_key))
					); ?>
				</div>
				<?php echo custom_anchor(
					$url,
					'<span class="svg-icon svg-icon-2">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
						<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor"></path>
					</svg>
				</span>',
					array('target' => $target, 'id' => $id, 'class' => 'btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px' . $extra_classes, 'title' => lang($lang_key))
				); ?>

			</div>
		</div>
		<div class="separator separator-dashed my-1"></div>
<?php
	}
}



?>
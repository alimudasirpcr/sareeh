<?php
function create_breadcrumb()
{
	$ci = &get_instance();
	$return = '<ol class="breadcrumb hidden-print text-gray-600 fw-bold fs-3 fw-semibold">';


	$dashboard_link = ' <li class="breadcrumb-item "><a  tabindex="-1"  class="breadcrumb-link text-hover-primary breadcrumb-link text-hover-primary" href="'.site_url('home').'">'.lang('dashboard').'</li></a> ';

	$return.=$dashboard_link;
	if ($ci->uri->segment(1) == 'home')
	{
		
		
		if ($ci->uri->segment(2) == 'work_order_dashboard') //Main page
		{
			
			$customers_home_link = ' <li class="breadcrumb-item "><a tabindex = "-1" class=" breadcrumb-link  text-hover-primary" href="'.site_url('home/work_order_dashboard').'">'.lang('work_order_dashboard').'</li></a>';
			$return.=$customers_home_link;
		}
		
		

	}
		
	if ($ci->uri->segment(1) == 'customers')
	{
		$params = $ci->session->userdata('customers_search_data') ? $ci->session->userdata('customers_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$customers_home_link =create_current_page_url(lang('module_deleted_customers'));
			}
			else
			{
				$customers_home_link =create_current_page_url(lang('module_customers'));
			}
		}
		else
		{
			
			$customers_home_link = ' <li class="breadcrumb-item "><a tabindex = "-1" class=" breadcrumb-link  text-hover-primary" href="'.site_url('customers').'">'.lang('module_customers').'</li></a>';
		}
		
		$return.=$customers_home_link;
		
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('customers_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('update_customer'));
			}
		}
		elseif($ci->uri->segment(2) == 'excel_import')
		{
			$return.=create_current_page_url(lang('customers_import_customers_from_excel'));
		}
		elseif($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}
		elseif($ci->uri->segment(2) == 'generate_barcode_labels')
		{
			$return.=create_current_page_url(lang('generate_barcodes'));
		}
		elseif($ci->uri->segment(2) == 'redeem_series')
		{
			$return.=create_current_page_url(lang('series'));
		}
  }
	elseif($ci->uri->segment(1) == 'items')
	{
		$params = $ci->session->userdata('items_search_data') ? $ci->session->userdata('items_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$items_home_link =create_current_page_url(lang('module_deleted_items'));
			}
			else
			{
				$items_home_link =create_current_page_url(lang('module_items'));
			}			
		}
		else
		{
			$items_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class=" breadcrumb-link  text-hover-primary" href="'.site_url('items').'">'.lang('module_items').'</li></a>';
		}
				
		$return.=$items_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('items_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('edit').' '.lang('item_info'));
			}
		}
		
		elseif($ci->uri->segment(2) == 'pricing')
		{
			$return.=create_current_page_url(lang('edit').' '.lang('pricing'));
		}
		elseif($ci->uri->segment(2) == 'variations')
		{
			$return.=create_current_page_url(lang('edit').' '.lang('items_variations'));
		}
		elseif($ci->uri->segment(2) == 'inventory')
		{
			$return.=create_current_page_url(lang('edit').' '.lang('inventory'));
		}
		elseif($ci->uri->segment(2) == 'location_settings')
		{
			$return.=create_current_page_url(lang('edit').' '.lang('items_location_settings'));
		}
		elseif($ci->uri->segment(2) == 'excel_import')
		{
			$return.=create_current_page_url(lang('excel_import'));
		}
		elseif($ci->uri->segment(2) == 'inventory_print_list')
		{
			$return.=create_current_page_url(lang('items_inventory_print_list'));
		}
		elseif($ci->uri->segment(2) == 'count')
		{
			$return.=create_current_page_url(lang('items_count_inventory'));
		}
		elseif($ci->uri->segment(2) == 'do_count')
		{
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('items/count').'">'.lang('items_count_inventory').'</li></a>';
			$return.=create_current_page_url(lang('items_do_count'));
		}
		elseif($ci->uri->segment(2) == 'excel_import_count')
		{
			$count_id = $ci->session->userdata('current_count_id');	
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url("items/count").'">'.lang('items_count_inventory').'</li></a>';
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url("items/do_count/$count_id").'">'.lang('items_do_count').'</li></a>';
			$return.=create_current_page_url(lang('excel_import'));
		}
		elseif($ci->uri->segment(2) == 'manage_attributes')
		{
			$return.=create_current_page_url(lang('items_manage_attributes'));
		}
		elseif($ci->uri->segment(2) == 'manage_modifiers' || $ci->uri->segment(2) == 'modifier')
		{
			$return.=create_current_page_url(lang('items_manage_modifiers'));
		}
		elseif($ci->uri->segment(2) == 'categories')
		{
			$return.=create_current_page_url(lang('items_manage_categories'));
		}
		elseif($ci->uri->segment(2) == 'manage_tags')
		{
			$return.=create_current_page_url(lang('items_manage_tags'));
		}
		elseif($ci->uri->segment(2) == 'manage_manufacturers')
		{
			$return.=create_current_page_url(lang('items_manage_manufacturers'));
		}
		elseif($ci->uri->segment(2) == 'price_rules')
		{
			$return.=create_current_page_url(lang('items_manage_price_rules'));
		}
		elseif($ci->uri->segment(2) == 'generate_barcode_labels' || $ci->uri->segment(2) == 'generate_barcodes' || $ci->uri->segment(2) == 'generate_barcodes_labels_from_recv' || $ci->uri->segment(2) =='generate_barcodes_from_recv')
		{
			$return.=create_current_page_url(lang('generate_barcodes'));
		}
		elseif($ci->uri->segment(2) == 'count_not_counted')
		{
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('items/count').'">'.lang('items_count_inventory').'</li></a>';
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('items/do_count/'.$ci->uri->segment(3)).'">'.lang('items_do_count').'</li></a>';
			$return.=create_current_page_url(lang('items_not_counted'));
		
		}
	}
	elseif($ci->uri->segment(1) == 'price_rules')
	{
		$params = $ci->session->userdata('price_rules_search_data') ? $ci->session->userdata('price_rules_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$price_rules_home_link = create_current_page_url(lang('module_deleted_price_rules'));
			}
			else
			{
				$price_rules_home_link = create_current_page_url(lang('module_price_rules'));
			}
		}
		else
		{
			$price_rules_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('price_rules').'">'.lang('module_price_rules').'</li></a>';
		}
		
		$return.=$price_rules_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('price_rules_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('price_rules_update'));
			}
		}
		
	}
	elseif($ci->uri->segment(1) == 'item_kits')
	{
		$params = $ci->session->userdata('item_kits_search_data') ? $ci->session->userdata('item_kits_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$item_kits_home_link = create_current_page_url(lang('module_deleted_item_kits'));
			}
			else
			{
				$item_kits_home_link = create_current_page_url(lang('module_item_kits'));
			}			
		}
		else
		{
			$item_kits_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('item_kits').'">'.lang('module_item_kits').'</li></a>';
		}
				
		$return.=$item_kits_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('item_kits_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('item_kits_update'));
			}
		}
		elseif($ci->uri->segment(2) == 'generate_barcode_labels' || $ci->uri->segment(2) == 'generate_barcodes')
		{
			$return.=create_current_page_url(lang('generate_barcodes'));
		}
		
	}
	elseif($ci->uri->segment(1) == 'suppliers')
	{
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$suppliers_home_link =create_current_page_url(lang('module_suppliers'));
		}
		else
		{
			$suppliers_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('suppliers').'">'.lang('module_suppliers').'</li></a>';
		}
				
		$return.=$suppliers_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('suppliers_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('update_customer'));
			}
		}
		elseif($ci->uri->segment(2) == 'excel_import')
		{
			$return.=create_current_page_url(lang('suppliers_import_suppliers_from_excel'));
		}
		elseif($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}
	}
	elseif($ci->uri->segment(1) == 'reports')
	{
		if ($ci->uri->segment(3) == NULL) //Main page
		{
			$reports_home_link =create_current_page_url(lang('module_reports'));
		}
		else
		{
			$reports_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('reports').'">'.lang('module_reports').'</li></a>';
		}
		
		$return.=$reports_home_link;
		
		if($ci->uri->segment(3) == 'graphical_summary_categories' || $ci->uri->segment(3) == 'summary_categories' || $ci->uri->segment(3) == 'summary_categories_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_categories_summary_report'));
		}
		elseif($ci->uri->segment(3) == 'sales_generator')
		{
			$return.=create_report_breadcrumb(lang('reports_sales_generator'));
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_customers' || $ci->uri->segment(3) == 'summary_customers')
		{
			$return.=create_report_breadcrumb(lang('reports_customers_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'summary_non_taxable_customers')
		{
			$return.=create_report_breadcrumb(lang('reports_non_taxable_customers'));
		}
		elseif($ci->uri->segment(3) == 'specific_customer')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_customers_report'));
		}		
		elseif($ci->uri->segment(3) == 'deleted_sales')
		{
			$return.=create_report_breadcrumb(lang('reports_deleted_sales_report'));				
		}		
		if($ci->uri->segment(3) == 'graphical_summary_discounts' || $ci->uri->segment(3) == 'summary_discounts')
		{
			$return.=create_report_breadcrumb(lang('reports_discounts_summary_report'));
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_employees' || $ci->uri->segment(3) == 'summary_employees')
		{
			$return.=create_report_breadcrumb(lang('reports_employees_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'specific_employee')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_employees_report'));
		}		
		elseif($ci->uri->segment(3) == 'summary_giftcards')
		{
			$return.=create_report_breadcrumb(lang('reports_giftcard_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'detailed_giftcards')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_giftcards_report'));
		}		
		elseif($ci->uri->segment(3) == 'inventory_low')
		{
			$return.=create_report_breadcrumb(lang('reports_low_inventory_report'));	
		}		
		elseif($ci->uri->segment(3) == 'inventory_summary')
		{
			$return.=create_report_breadcrumb(lang('reports_inventory_summary'));		
		}		
		elseif($ci->uri->segment(3) == 'inventory_at_past_date')
		{
			$return.=create_report_breadcrumb(lang('reports_inventory_at_past_date'));		
		}		
		elseif($ci->uri->segment(3) == 'summary_count_report')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_count_report'));		
		}		
		elseif($ci->uri->segment(3) == 'detailed_count_report')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_count_report'));		
		}
		elseif($ci->uri->segment(3) == 'expiring_inventory')
		{
			$return.=create_report_breadcrumb(lang('reports_expired_inventory_report'));		
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_item_kits' || $ci->uri->segment(3) == 'summary_item_kits')
		{
			$return.=create_report_breadcrumb(lang('reports_item_kits_summary_report'));	
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_items' || $ci->uri->segment(3) == 'summary_items')
		{
			$return.=create_report_breadcrumb(lang('reports_items_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'enhanced_summary_items')
		{
			$return.=create_report_breadcrumb(lang('reports_items_enhanced_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_payments' || $ci->uri->segment(3) == 'summary_payments')
		{
			$return.=create_report_breadcrumb(lang('reports_payments_summary_report'));
		}		
		elseif($ci->uri->segment(3) =='summary_payments_registers')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_payments_registers'));
		}
		elseif($ci->uri->segment(3) == 'summary_profit_and_loss')
		{
			$return.=create_report_breadcrumb(lang('reports_profit_and_loss'));
		}		
		elseif($ci->uri->segment(3) == 'detailed_profit_and_loss')
		{
			$return.=create_report_breadcrumb(lang('reports_profit_and_loss'));				
		}		
		elseif($ci->uri->segment(3) == 'detailed_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_receivings_report'));						
		}
		elseif($ci->uri->segment(3) == 'detailed_register_log')
		{
			$return.=create_report_breadcrumb(lang('reports_register_log_title'));						
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_sales' || $ci->uri->segment(3) == 'summary_sales')
		{
			$return.=create_report_breadcrumb(lang('reports_sales_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'detailed_sales')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_sales_report'));
		}		
		elseif($ci->uri->segment(3) == 'store_account_statements')
		{			
			$return.=create_report_breadcrumb(lang('reports_store_account_statements'));
		}		
		elseif($ci->uri->segment(3) == 'summary_store_accounts')
		{
			$return.=create_report_breadcrumb(lang('reports_store_account_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'specific_customer_store_account')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_store_accounts_report'));
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_suppliers' || $ci->uri->segment(3) == 'summary_suppliers')
		{
			$return.=create_report_breadcrumb(lang('reports_suppliers_summary_report'));
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_suppliers_receivings' || $ci->uri->segment(3) == 'summary_suppliers_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_suppliers_receivings_summary_report'));
		}		
		elseif($ci->uri->segment(3) == 'specific_supplier')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_suppliers_report'));	
		}
		elseif($ci->uri->segment(3) == 'specific_supplier_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_recevings_report'));	
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_taxes' || $ci->uri->segment(3) == 'summary_taxes')
		{
			$return.=create_report_breadcrumb(lang('reports_taxes_summary_report'));					
		}
		elseif($ci->uri->segment(3) == 'detailed_suspended_sales')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_suspended_sales_report'));					
		
		}
		elseif ($ci->uri->segment(3) == 'detailed_payments')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_payments_report'));	
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_commissions' || $ci->uri->segment(3) == 'summary_commissions')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_commission_report'));
		}
		elseif($ci->uri->segment(3) == 'detailed_commissions')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_commission_report'));
		}
		elseif($ci->uri->segment(3) == 'detailed_inventory')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_inventory_report'));
		}
		elseif($ci->uri->segment(3) == 'summary_timeclock')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_timeclock_report'));
		}
		elseif($ci->uri->segment(3) == 'detailed_timeclock')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_timeclock_report'));
		}
		elseif($ci->uri->segment(3) == 'summary_tiers')
		{
			$return.=create_report_breadcrumb(lang('reports_tiers_summary_report'));
		}
		elseif($ci->uri->segment(3) == 'closeout')
		{
			$return.=create_report_breadcrumb(lang('reports_closeout'));
		}
		elseif($ci->uri->segment(3) == 'summary_expenses')
		{
			$return.=create_report_breadcrumb(lang('reports_expenses_summary_report'));
		}
		elseif($ci->uri->segment(3) == 'detailed_expenses')
		{
			$return.=create_report_breadcrumb(lang('reports_expenses_detailed_report'));
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_tags' || $ci->uri->segment(3) == 'summary_tags')
		{
			$return.=create_report_breadcrumb(lang('reports_tags_summary_report'));
		}
		elseif($ci->uri->segment(2) == 'register_log_details')
		{
			$return.=create_report_breadcrumb(lang('reports_register_log_details_report'));
		}
		elseif($ci->uri->segment(3) == 'deleted_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_deleted_recv_reports'));
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_taxes_receivings' || $ci->uri->segment(3) == 'summary_taxes_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_taxes_receivings_report'));					
		}
		elseif($ci->uri->segment(3) == 'giftcard_audit')
		{
			$return.=create_report_breadcrumb(lang('reports_giftcards_audit_report'));					
		}
		elseif($ci->uri->segment(3) == 'summary_sales_time' || $ci->uri->segment(3) == 'graphical_summary_sales_time')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_sales_time_reports'));					
		}
		elseif($ci->uri->segment(3) == 'detailed_suspended_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_suspended_receivings_report'));					
		}
		elseif($ci->uri->segment(3) == 'store_account_outstanding')
		{
			$return.=create_report_breadcrumb(lang('reports_outstanding_sales'));								
		}
		elseif($ci->uri->segment(3) == 'supplier_store_account_statements')
		{
			$return.=create_report_breadcrumb(lang('reports_store_account_statements'));								
		}
		elseif($ci->uri->segment(3) == 'supplier_summary_store_accounts')
		{
			$return.=create_report_breadcrumb(lang('reports_store_account_summary_report'));								
		}
		elseif($ci->uri->segment(3) == 'supplier_specific_store_account')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_store_accounts_report'));								
		}
		elseif($ci->uri->segment(3) == 'supplier_store_account_activity')
		{
			$return.=create_report_breadcrumb(lang('reports_store_account_activity_report'));								
		}
		elseif($ci->uri->segment(3) == 'store_account_activity')
		{
			$return.=create_report_breadcrumb(lang('reports_store_account_activity_report'));								
		}
		elseif($ci->uri->segment(3) == 'supplier_store_account_outstanding')
		{
			$return.=create_report_breadcrumb(lang('reports_outstanding_receivings_report'));								
		}
		elseif($ci->uri->segment(3) == 'receivings_summary_payments')
		{
			$return.=create_report_breadcrumb(lang('reports_payments_summary_report'));								
		}
		elseif($ci->uri->segment(3) == 'receivings_detailed_payments')
		{
			$return.=create_report_breadcrumb(lang('reports_detailed_payments_report'));								
		}
		elseif($ci->uri->segment(3) == 'receivings_graphical_summary_payments')
		{
			$return.=create_report_breadcrumb(lang('reports_payments_summary_report'));								
		}
		elseif($ci->uri->segment(3) == 'summary_items_variance')
		{
			$return.=create_report_breadcrumb(lang('reports_price_variance_report'));								
		}
		elseif($ci->uri->segment(3) == 'summary_item_kits_variance')
		{
			$return.=create_report_breadcrumb(lang('reports_price_variance_report'));								
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_manufacturers')
		{
			$return.=create_report_breadcrumb(lang('reports_manufacturers_report'));								
		}		
		elseif($ci->uri->segment(3) == 'summary_manufacturers')
		{
			$return.=create_report_breadcrumb(lang('reports_manufacturers_report'));								
		}		
		elseif($ci->uri->segment(3) == 'summary_registers')
		{
			$return.=create_report_breadcrumb(lang('reports_registers'));								
		}		
		elseif($ci->uri->segment(3) == 'graphical_summary_registers')
		{
			$return.=create_report_breadcrumb(lang('reports_registers'));								
		}
		elseif($ci->uri->segment(3) == 'graphical_summary_items_receivings' || $ci->uri->segment(3) == 'summary_items_receivings')
		{
			$return.=create_report_breadcrumb(lang('reports_items_summary_report_recv'));
		}
		elseif($ci->uri->segment(3) == 'detailed_ecommerce_sales')
		{
			$return.=create_report_breadcrumb(lang('ecommerce'));
		}
		elseif($ci->uri->segment(3) == 'detailed_deliveries')
		{
			$return.=create_report_breadcrumb(lang('reports_deliveries'));
		}
		elseif($ci->uri->segment(3) == 'summary_price_rules')
		{
			$return.=create_report_breadcrumb(lang('reports_price_rules'));
		}
		elseif($ci->uri->segment(3) == 'new_customers')
		{
			$return.=create_report_breadcrumb(lang('reports_new_customers'));
		}
		elseif($ci->uri->segment(3) == 'transfers')
		{
			$return.=create_report_breadcrumb(lang('transfers'));
		}
		elseif($ci->uri->segment(3) == 'customers_series' || $ci->uri->segment(2) == 'view_series')
		{
			$return.=create_report_breadcrumb(lang('series'));			
		}
		elseif($ci->uri->segment(3) == 'summary_appointments' || $ci->uri->segment(3) == 'detailed_appointments')
		{
			$return.=create_report_breadcrumb(lang('reports_appointments'));
		}
		elseif($ci->uri->segment(3) == 'summary_sales_day_of_week')
		{
			$return.=create_report_breadcrumb(lang('reports_day_of_week_report'));
		}		
		elseif($ci->uri->segment(3) == 'detailed_last_4_cc')
		{
			$return.=create_report_breadcrumb(lang('reports_last_4_cc'));			
		}
		elseif($ci->uri->segment(3) == 'summary_journal')
		{
			$return.=create_report_breadcrumb(lang('reports_summary_journal'));
		}
		elseif($ci->uri->segment(3) == 'voided_transactions')
		{
			$return.=create_report_breadcrumb(lang('reports_voided_transactions'));
		}
        else if ($ci->uri->segment(3) == 'customer_invoices') {
            $return .= create_report_breadcrumb(lang('reports_customer_invoices'));
        }
        else if ($ci->uri->segment(3) == 'supplier_invoices') {
            $return .= create_report_breadcrumb(lang('reports_supplier_invoices'));
        }
		
	}
	
	elseif ($ci->uri->segment(1) == 'employees')
	{
		$params = $ci->session->userdata('employees_search_data') ? $ci->session->userdata('employees_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$employees_home_link =create_current_page_url(lang('module_deleted_employees'));
			}
			else
			{
				$employees_home_link =create_current_page_url(lang('module_employees'));
			}			
		}
		else
		{
			$employees_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('employees').'">'.lang('module_employees').'</li></a>';
		}
		
		$return.=$employees_home_link;
		
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('employees_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('employees_update'));
			}
		}
		elseif($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}
		
  }
	elseif ($ci->uri->segment(1) == 'giftcards')
	{
		$params = $ci->session->userdata('giftcards_search_data') ? $ci->session->userdata('giftcards_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$giftcards_home_link =create_current_page_url(lang('module_deleted_giftcards'));
			}
			else
			{
				$giftcards_home_link =create_current_page_url(lang('module_giftcards'));
			}
		}
		else
		{
			$giftcards_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('giftcards').'">'.lang('module_giftcards').'</li></a>';
		}
		
		
		$return.=$giftcards_home_link;
		
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('giftcards_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('giftcards_update'));
			}
		}
		
		if($ci->uri->segment(2) == 'excel_import')
		{
  			$return.=create_current_page_url(lang('excel_import'));
		}
		
		if($ci->uri->segment(2) == 'generate_barcode_labels' || $ci->uri->segment(2) == 'generate_barcodes')
		{
			$return.=create_current_page_url(lang('generate_barcodes'));
		}
		
  	}
	elseif($ci->uri->segment(1) == 'config')
	{

		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$config_home_link =create_current_page_url(lang('module_config'));
		}
		
		else if($ci->uri->segment(2) == 'cron_documentation')
		{
  			$config_home_link=create_current_page_url(lang('title_cron_documentation'));
		}
		else if($ci->uri->segment(2) == 'shopify')
		{
  			$config_home_link=create_current_page_url(lang('module_config')).create_current_page_url('Shopify');
		}
		
		else
		{
			$config_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('config').'">'.lang('module_config').'</li></a>';
		}
		
		$return.=$config_home_link;
		
		
		if($ci->uri->segment(2) == 'backup')
		{
  			$return.=create_current_page_url(lang('config_backup_overview'));
		}
	}
	elseif ($ci->uri->segment(1) == 'locations')
	{
		$params = $ci->session->userdata('locations_search_data') ? $ci->session->userdata('locations_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$locations_home_link = create_current_page_url(lang('module_deleted_locations'));
			}
			else
			{
				$locations_home_link = create_current_page_url(lang('module_locations'));
			}
		}
		else
		{
			$locations_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('locations').'">'.lang('module_locations').'</li></a>';
		}
		
		$return.=$locations_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('locations_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('locations_update'));
			}
		}
  }
	elseif ($ci->uri->segment(1) == 'sales')
	{
		if ($ci->uri->segment(2) == NULL || $ci->uri->segment(2) == 'index' || $ci->uri->segment(2) == 'unsuspend') //Main page
		{
			$sales_home_link = ' <li class="breadcrumb-item"><a class="current" tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('sales').'">'.lang('module_sales').'</li></a>';
			
			if ($ci->Register->count_all() > 1)
			{
				$register_name = $ci->Register->get_info($ci->Employee->get_logged_in_employee_current_register_id())->name;
				
				if ($register_name)
				{
					
					$default_register = $ci->Employee->getDefaultRegister($ci->Employee->get_logged_in_employee_info()->person_id,$ci->Employee->get_logged_in_employee_current_location_id());
					
					if ($default_register)
					{
						$sales_home_link.=' <li class="breadcrumb-item"><a tabindex = "-1" class="current" class="breadcrumb-link  text-hover-primary" href="'.site_url('sales/clear_register').'">'.$register_name.'</li></a>';
					}
					else
					{
						$sales_home_link.=' <li class="breadcrumb-item"><a tabindex = "-1" class="current" class="breadcrumb-link  text-hover-primary" href="'.site_url('sales/clear_register').'">'.$register_name.' ['.lang('sales_change_register').']</li></a>';
						
					}
				}	
			}
		}
		else
		{
			$sales_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('sales').'">'.lang('module_sales').'</li></a>';
		}
		
		$return.=$sales_home_link;
		if($ci->uri->segment(2) == 'suspended')
		{
			$return.=create_current_page_url(lang('sales_suspended_sales'));
		}

		if($ci->uri->segment(2) == 'work_orders')
		{
			$return.=create_current_page_url(lang('work_orders_work_orders'));
		}
		
		if($ci->uri->segment(2) == 'batch_sale')
		{
			$return.=create_current_page_url(lang('batch_sale'));
		}
		
		if($ci->uri->segment(2) == 'enter_tips')
		{
			$return.=create_current_page_url(lang('sales_enter_tips'));
		}
		
		
		if($ci->uri->segment(2) == 'register_add_subtract' && $ci->uri->segment(3) == 'add')
		{
			$return.=create_current_page_url(lang('sales_add_cash_to_register'));
		}

		if($ci->uri->segment(2) == 'register_add_subtract' && $ci->uri->segment(3) == 'subtract')
		{
			$return.=create_current_page_url(lang('remove_cash_from_register'));
		}
		
		if($ci->uri->segment(2) == 'closeregister')
		{
			$return.=create_current_page_url(lang('sales_close_register'));
		}
		
		if($ci->uri->segment(2) == 'new_giftcard')
		{
			$return.=create_current_page_url(lang('sales_new_giftcard'));
		}
		
		if($ci->uri->segment(2) == 'receipt' || $ci->uri->segment(2) == 'complete' || $ci->uri->segment(2) == 'declined')
		{
			$return.=create_current_page_url(lang('sales_receipt'));
		}
		
		if ($ci->Employee->has_module_action_permission('sales', 'add_remove_amounts_from_cash_drawer', $ci->Employee->get_logged_in_employee_info()->person_id)) {
			if ($ci->uri->segment(2) == 'open_drawer')
			{
				$return.=create_current_page_url(lang('pop_open_cash_drawer'));
			}
		}

		if($ci->uri->segment(2) == 'customer_display')
		{
			$return.=create_current_page_url(lang('sales_customer_facing_display'));
		}
		
		if($ci->uri->segment(2) == 'fulfillment')
		{
			$return.=create_current_page_url(lang('sales_fulfillment_sheet'));
		}
		
		if($ci->uri->segment(2) == 'edit')
		{
			$return.=create_current_page_url(lang('sales_edit_sale'));
		}

		if($ci->uri->segment(2) == 'delete')
		{
			$return.=create_current_page_url(lang('module_action_delete_sale'));
		}

		if($ci->uri->segment(2) == 'undelete')
		{
			$return.=create_current_page_url(lang('sales_undelete_entire_sale'));
		}
		
		if ($ci->uri->segment(2)=='start_cc_processing')
		{
			$return.=create_current_page_url(lang('sales_process_credit_card'));
		}
		
		if ($ci->uri->segment(2)=='start_cc_processing_trans_cloud')
		{
			$return.=create_current_page_url(lang('sales_process_credit_card'));
		}
			
		if ($ci->uri->segment(2)=='finish_cc_processing')
		{
			$return.=create_current_page_url(lang('sales_process_credit_card'));
		}
		elseif($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}

	}
	elseif ($ci->uri->segment(1) == 'receivings')
	{
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$receivings_home_link = ' <li class="breadcrumb-item"><a class="current" tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('receivings').'">'.lang('module_receivings').'</li></a>';
		}
		else
		{
			$receivings_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('receivings').'">'.lang('module_receivings').'</li></a>';
		}
		
		$return.=$receivings_home_link;
		if($ci->uri->segment(2) == 'suspended')
		{
			$return.=create_current_page_url(lang('suspended_receivings'));
		}
		
		if($ci->uri->segment(2) == 'batch_receiving')
		{
			$return.=create_current_page_url(lang('batch_receivings'));
		}
		
		if($ci->uri->segment(2) == 'receipt' || $ci->uri->segment(2) == 'complete')
		{
			$return.=create_current_page_url(lang('receivings_receipt'));
		}
		
		if($ci->uri->segment(2) == 'po')
		{
			$return.=create_current_page_url(lang('receivings_create_purchase_order'));
		}
		elseif($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}
	}
	elseif($ci->uri->segment(1) == 'expenses')
	{
		$params = $ci->session->userdata('expenses_search_data') ? $ci->session->userdata('expenses_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$expenses_home_link =create_current_page_url(lang('module_deleted_expenses'));
			}
			else
			{
				$expenses_home_link =create_current_page_url(lang('module_expenses'));
			}
		}
		else
		{
			$expenses_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('expenses').'">'.lang('module_expenses').'</li></a>';
		}
				
		$return.=$expenses_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('expenses_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('expenses_update'));
			}
		}
  }
  elseif($ci->uri->segment(1) == 'customer_subscriptions')
	{
	$params = $ci->session->userdata('customer_subscriptions_search_data') ? $ci->session->userdata('customer_subscriptions_search_data') : array('deleted' => 0);
	
	if ($ci->uri->segment(2) == NULL) //Main page
	{
		$customer_subscriptions_home_link =create_current_page_url(lang('module_customer_subscriptions'));
	}
	else
	{
		$customer_subscriptions_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('customer_subscriptions').'">'.lang('module_customer_subscriptions').'</li></a>';
	}
			
	$return.=$customer_subscriptions_home_link;
	
	if($ci->uri->segment(2) == 'view')
	{
		$return.=create_current_page_url(lang('customer_subscriptions_update'));
	}
  }
	elseif ($ci->uri->segment(1) == 'timeclocks')
	{
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$timeclock_home_link =create_current_page_url(lang('employees_timeclock'));
		}
		else
		{
			$timeclock_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('timeclocks').'">'.lang('employees_timeclock').'</li></a>';
		}
		
		$return.=$timeclock_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			$return.=create_current_page_url(lang('edit'));
		}
		
		if($ci->uri->segment(2) == 'punches')
		{
			$return.=create_current_page_url(lang('timeclocks_my_punches'));
		}
		
		if($ci->uri->segment(2) == 'request_time_off')
		{
			$return.=create_current_page_url(lang('timeclocks_request_time_off'));
		}
		
		
	}
	elseif($ci->uri->segment(1) == 'messages')
	{

		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$messages_home_link =create_current_page_url(lang('module_messages'));
		}
		else
		{
			$messages_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('messages').'">'.lang('module_messages').'</li></a>';
		}
		
		$return.=$messages_home_link;
		
		
		if($ci->uri->segment(2) == 'send_message')
		{
  			$return.=create_current_page_url(lang('employees_send_message'));
		}
		
		if($ci->uri->segment(2) == 'sent_messages')
		{
  			$return.=create_current_page_url(lang('messages_sent_messages'));
		}
		
	}
	elseif($ci->uri->segment(1) == 'deliveries')
	{
		$params = $ci->session->userdata('deliveries_orders_search_data') ? $ci->session->userdata('deliveries_orders_search_data') : array('deleted' => 0);
		$deliveries_home_link='';
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$deliveries_home_link =create_current_page_url(lang('module_deleted_deliveries_orders'));
			}
			else
			{
				$deliveries_home_link =create_current_page_url(lang('deliveries_orders'));
			}
		}
		$return.=$deliveries_home_link;
		if ($ci->uri->segment(2)=='view')
		{
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('deliveries').'">'.lang('deliveries_orders').'</li></a>';
			$return.=create_current_page_url(lang('edit'));
		}
		elseif($ci->uri->segment(2)=='manage_template')
		{
			$return.= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('deliveries').'">'.lang('deliveries_orders').'</li></a>';
			$return.=create_current_page_url(lang('deliveries_templates'));
		}	
	}
	elseif($ci->uri->segment(1) == 'appointments')
	{
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			$params = $ci->session->userdata('appointments_search_data') ? $ci->session->userdata('customers_search_data') : array('deleted' => 0);
			
			if(isset($params['deleted']) && $params['deleted'])
			{
				$appointments_home_link =create_current_page_url(lang('appointments_manage_deleted'));
			}
			else
			{
				$appointments_home_link =create_current_page_url(lang('module_appointments'));
			}
		}
		else
		{
			
			$appointments_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('appointments').'">'.lang('module_appointments').'</li></a>';
		}
		
		$return.=$appointments_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('appointments_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('appointments_update'));
			}
		}
		elseif($ci->uri->segment(2) == 'calendar')
		{
			$return.=create_current_page_url(lang('calendar'));
		}
		elseif($ci->uri->segment(2) == 'manage_appointment_types')
		{
			$return.=create_current_page_url(lang('items_manage_categories'));
		}
		
	}
	
	elseif ($ci->uri->segment(1) == 'permission_templates')
	{
		$params = $ci->session->userdata('permission_templates_search_data') ? $ci->session->userdata('permission_templates_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$employees_home_link =create_current_page_url(lang('module_deleted_employees'));
			}
			else
			{
				$employees_home_link =create_current_page_url(lang('permission_templates'));
			}			
		}
		else
		{
			$employees_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('permission_templates').'">'.lang('permission_templates').'</li></a>';
		}
		
		$return.=$employees_home_link;
		
		if($ci->uri->segment(2) == 'view')
		{
			if ($ci->uri->segment(3) == -1)
			{
  				$return.=create_current_page_url(lang('permissions_new'));
			}
			else
			{
  				$return.=create_current_page_url(lang('permission_templates_update'));
			}
		}
		
  	}
	elseif($ci->uri->segment(1) == 'work_orders')
	{
		$params = $ci->session->userdata('work_orders_search_data') ? $ci->session->userdata('work_orders_search_data') : array('deleted' => 0);
		
		if ($ci->uri->segment(2) == NULL) //Main page
		{
			if(isset($params['deleted']) && $params['deleted'])
			{
				$work_orders_home_link =create_current_page_url(lang('module_deleted_work_orders'));
			}
			else
			{
				$work_orders_home_link =create_current_page_url(lang('module_work_orders'));
			}
		}
		else
		{
			
			$work_orders_home_link = ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="'.site_url('work_orders').'">'.lang('module_work_orders').'</li></a>';
		}
		
		$return.=$work_orders_home_link;

		if($ci->uri->segment(2) == 'custom_fields')
		{
			$return.=create_current_page_url(lang('custom_field_config'));
		}
		else if($ci->uri->segment(2) == 'print_work_order')
		{
			$return.=create_current_page_url(lang('work_orders_print_work_order'));
		}
		else if($ci->uri->segment(2) == 'print_service_tag' || $ci->uri->segment(2) == 'raw_print_service_tag')
		{
			$return.=create_current_page_url(lang('work_orders_print_service_tag'));
		}
		else if ($ci->uri->segment(2)=='view')
		{
			$return.=create_current_page_url(lang('edit'));
		}
		
	}
    else if ($ci->uri->segment(1) == 'invoices') {
        $return .= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="' . site_url('invoices') . '">' . lang('module_invoices') . '</li></a>';
        
        if ($ci->uri->segment(3) == 'customer') {
            $return .= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="' . site_url('invoices/index/customer') . '">' . lang('customer') . '</li></a>';
        }
        
        if ($ci->uri->segment(3) == 'supplier') {
            $return .= ' <li class="breadcrumb-item"><a tabindex = "-1" class="breadcrumb-link  text-hover-primary" href="' . site_url('invoices/index/supplier') . '">' . lang('supplier') . '</li></a>';
        }
        
        
        if ($ci->uri->segment(2) == 'view') {
            $return .= create_current_page_url(lang('edit'));
        }
        
        if ($ci->uri->segment(2) == 'pay') {
            $return .= create_current_page_url(lang('pay'));
        }
        
        if ($ci->uri->segment(2) == 'show') {
            $return .= create_current_page_url(lang('view'));
        }
        
        
    }
  	return $return ."</ol>";
}

function create_report_breadcrumb($link_text)
{
	$url = parse_url(current_url());
	$url_without_query_string = sprintf('%s://%s%s', $url['scheme'], $url['host'], $url['path']);
	return ' <li class="breadcrumb-item"><a tabindex = "-1" class="current" class="breadcrumb-link  text-hover-primary" href="'.$url_without_query_string.'">'.$link_text.'</li></a>';
}
	

function create_current_page_url($link_text)
{
	return ' <li class="breadcrumb-item"><a tabindex = "-1" class="current" class="breadcrumb-link  text-hover-primary" href="'.current_url().'">'.$link_text.'</li></a>';
}
?>
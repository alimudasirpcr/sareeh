<?php
class Appconfig extends MY_Model 
{
	
	public function __construct() {
		$this->load->model('person');
		$this->load->model('employee');
		
	}

	function get_all_configs_array(){
		$batch_save_keys = [
			'disable_modules', 'company', 'qb_export_start_date', 'sale_prefix', 'website', 
			'terms', 'prices_include_tax', 'currency_symbol', 'language', 'date_format', 
			'time_format', 'print_after_sale', 'print_after_receiving', 'round_cash_on_sales', 
			'enable_pdf_receipts', 'automatically_email_receipt', 'automatically_show_comments_on_receipt', 
			'id_to_show_on_sale_interface', 'auto_focus_on_item_after_sale_and_receiving', 
			'barcode_price_include_tax', 'hide_signature', 'hide_customer_recent_sales', 
			'disable_confirmation_sale', 'confirm_error_adding_item', 'track_payment_types', 
			'number_of_items_per_page', 'additional_payment_types', 'user_configured_layaway_name', 
			'user_configured_estimate_name', 'hide_layaways_sales_in_reports', 
			'hide_store_account_payments_in_reports', 'change_sale_date_when_suspending', 
			'change_sale_date_when_completing_suspended_sale', 'show_receipt_after_suspending_sale', 
			'customers_store_accounts', 'calculate_average_cost_price_from_receivings', 
			'averaging_method', 'show_language_switcher', 'show_clock_on_header', 
			'disable_giftcard_detection', 'hide_available_giftcards', 'show_giftcards_even_if_0_balance', 
			'always_show_item_grid', 'hide_out_of_stock_grid', 'default_payment_type', 
			'return_policy', 'announcement_special', 'spreadsheet_format', 'legacy_detailed_report_export', 
			'hide_barcode_on_sales_and_recv_receipt', 'round_tier_prices_to_2_decimals', 
			'group_all_taxes_on_receipt', 'receipt_text_size', 'select_sales_person_during_sale', 
			'default_sales_person', 'require_customer_for_sale', 'commission_default_rate', 
			'hide_store_account_payments_from_report_totals', 'disable_sale_notifications', 
			'change_sale_date_for_new_sale', 'id_to_show_on_barcode', 'timeclock', 'timeclock_pto', 
			'number_of_recent_sales', 'hide_suspended_recv_in_reports', 'calculate_profit_for_giftcard_when', 
			'remove_customer_contact_info_from_receipt', 'speed_up_search_queries', 
			'redirect_to_sale_or_recv_screen_after_printing_receipt', 'enable_sounds', 'charge_tax_on_recv', 
			'use_saudi_tax_config', 'use_saudi_tax_test_config', 'report_sort_order', 
			'do_not_group_same_items', 'show_item_id_on_receipt', 'do_not_allow_out_of_stock_items_to_be_sold', 
			'number_of_items_in_grid', 'edit_item_price_if_zero_after_adding', 'override_receipt_title', 
			'automatically_print_duplicate_receipt_for_cc_transactions', 'default_type_for_grid', 
			'disable_quick_complete_sale', 'clean_input_after_add_item', 'fast_user_switching', 
			'require_employee_login_before_each_sale', 'reset_location_when_switching_employee', 
			'allow_employees_to_use_2fa', 'number_of_decimals', 'thousands_separator', 
			'decimal_point', 'enhanced_search_method', 'hide_store_account_balance_on_receipt', 
			'deleted_payment_types', 'commission_percent_type', 'highlight_low_inventory_items_in_items_module', 
			'enable_customer_loyalty_system', 'loyalty_option', 'number_of_sales_for_discount', 
			'discount_percent_earned', 'hide_sales_to_discount_on_receipt', 'point_value', 
			'spend_to_point_ratio', 'hide_price_on_barcodes', 'always_use_average_cost_method', 
			'test_mode', 'speedy_pos', 'require_customer_for_suspended_sale', 
			'default_new_items_to_service', 'prompt_for_ccv_swipe', 'disable_store_account_when_over_credit_limit', 
			'mailing_labels_type', 'phppos_session_expiration', 'do_not_allow_below_cost', 
			'store_account_statement_message', 'hide_points_on_receipt', 'enable_markup_calculator', 
			'enable_margin_calculator', 'enable_quick_edit', 'show_orig_price_if_marked_down_on_receipt', 
			'include_child_categories_when_searching_or_reporting', 'remove_commission_from_profit_in_reports', 
			'remove_points_from_profit', 'capture_sig_for_all_payments', 'suppliers_store_accounts', 
			'currency_symbol_location', 'hide_desc_on_receipt', 'hide_desc_emailed_receipts', 
			'default_tier_percent_type_for_excel_import', 
			'default_tier_percent_type_for_excel_import',
			'default_tier_fixed_type_for_excel_import',
			'override_tier_name',
			'loyalty_points_without_tax',
			'remove_customer_name_from_receipt',
			'enable_scale',
			'scale_format',
			'ecom_store_location',
			'woo_version',
			'woo_api_url',
			'ecommerce_platform',
			'scale_divide_by',
			'do_not_force_http',
			'logout_on_clock_out',
			'disable_test_mode',
			'enable_ebt_payments',
			'online_price_tier',
			'email_provider',
			'smtp_crypto',
			'protocol',
			'smtp_host',
			'smtp_user',
			'smtp_pass',
			'smtp_port',
			'email_charset',
			'newline',
			'crlf',
			'smtp_timeout',
			'ecommerce_cron_sync_operations',
			'force_https',
			'disable_price_rules_dialog',
			'prompt_to_use_points',
			'always_print_duplicate_receipt_all',
			'tax_class_id',
			'wide_printer_receipt_format',
			'default_reorder_level_when_creating_items',
			'remove_customer_company_from_receipt',
			'currency_code',
			'item_lookup_order',
			'number_of_decimals_for_quantity_on_receipt',
			'enable_wic',
			'store_opening_time',
			'store_closing_time',
			'limit_manual_price_adj',
			'always_minimize_menu',
			'emailed_receipt_subject',
			'do_not_tax_service_items_for_deliveries',
			'do_not_show_closing',
			'indicate_taxable_on_receipt',
			'indicate_non_taxable_on_receipt',
			'override_symbol_non_taxable',
			'paypal_me',
			'show_barcode_company_name',
			'sku_sync_field',
			'overwrite_existing_items_on_excel_import',
			'remove_employee_lastname_from_receipt',
			'remove_employee_from_receipt',
			'hide_name_on_barcodes',
			'new_items_are_ecommerce_by_default',
			'hide_description_on_sales_and_recv',
			'hide_item_descriptions_in_reports',
			'do_not_allow_item_with_variations_to_be_sold_without_selecting_variation',
			'verify_age_for_products',
			'default_age_to_verify',
			'remind_customer_facing_display',
			'disable_confirm_recv',
			'minimum_points_to_redeem',
			'default_days_to_expire_when_creating_items',
			'qb_sync_operations',
			'allow_scan_of_customer_into_item_field',
			'cash_alert_low',
			'cash_alert_high',
			'sort_receipt_column',
			'show_tax_per_item_on_receipt',
			'show_item_id_on_recv_receipt',
			'import_all_past_orders_for_woo_commerce',
			'hide_barcode_on_barcode_labels',
			'do_not_delete_saved_card_after_failure',
			'capture_internal_notes_during_sale',
			'hide_prices_on_fill_sheet',
			'show_total_discount_on_receipt',
			'default_credit_limit',
			'hide_expire_date_on_barcodes',
			'auto_capture_signature',
			'pdf_receipt_message',
			'hide_merchant_id_from_receipt',
			'hide_all_prices_on_recv',
			'do_not_delete_serial_number_when_selling',
			'new_customer_web_hook',
			'new_sale_web_hook',
			'new_receiving_web_hook',
			'strict_age_format_check',
			'flat_discounts_discount_tax',
			'show_item_kit_items_on_receipt',
			'amount_of_cash_to_be_left_in_drawer_at_closing',
			'hide_tier_on_receipt',
			'second_language',
			'disable_gift_cards_sold_from_loyalty',
			'track_shipping_cost_recv',
			'enable_points_for_giftcard_payments',
			'enable_tips',
			'require_supplier_for_recv',
			'default_payment_type_recv',
			'taxjar_api_key',
			'quick_variation_grid',
			'show_full_category_path',
			'do_not_upload_images_to_ecommerce',
			'woo_enable_html_desc',
			'max_discount_percent',
			'use_rtl_barcode_library',
			'scan_and_set_sales',
			'scan_and_set_recv',
			'default_new_customer_to_current_location',
			'week_start_day',
			'edit_sale_web_hook',
			'edit_recv_web_hook',
			'hide_expire_dashboard',
			'hide_images_in_grid',
			'taxes_summary_on_receipt',
			'override_symbol_taxable_summary',
			'override_symbol_non_taxable_summary',
			'taxes_summary_details_on_receipt',
			'collapse_sales_ui_by_default',
			'collapse_recv_ui_by_default',
			'enable_customer_quick_add',
			'uppercase_receipts',
			'edit_customer_web_hook',
			'show_selling_price_on_recv',
			'hide_email_on_receipts',
			'enable_supplier_quick_add',
			'tax_id',
			'disable_recv_number_on_barcode',
			'tax_jar_location',
			'disable_loyalty_by_default',
			'dark_mode',
			'ecommerce_only_sync_completed_orders',
			'damaged_reasons',
			'display_item_name_first_for_variation_name',
			'do_not_allow_sales_with_zero_value',
			'disable_sale_cloning',
			'disable_recv_cloning',
			'dont_recalculate_cost_price_when_unsuspending_estimates',
			'show_signature_on_receiving_receipt',
			'do_not_treat_service_items_as_virtual',
			'prompt_amount_for_cash_sale',
			'show_qr_code_for_sale',
			'hide_categories_sales_grid',
			'hide_tags_sales_grid',
			'hide_suppliers_sales_grid',
			'hide_favorites_sales_grid',
			'do_not_allow_items_to_go_out_of_stock_when_transfering',
			'show_tags_on_fulfillment_sheet',
			'automatically_sms_receipt',
			'items_per_search_suggestions',
			'shopify_shop',
			'offline_mode',
			'offline_mode_sync_period',
			'auto_sync_offline_sales',
			'show_total_on_fulfillment',
			'override_signature_text',
			'receipt_download_filename_prefix',
			'hide_categories_receivings_grid',
			'hide_tags_receivings_grid',
			'hide_suppliers_receivings_grid',
			'hide_favorites_receivings_grid',
			'delivery_color_based_on',
			'update_cost_price_on_transfer',
			'tip_preset_zero',
			'layaway_statement_message',
			'hide_supplier_in_item_search_result',
			'show_person_id_on_receipt',
			'import_ecommerce_orders_suspended',
			'show_images_on_receipt',
			'customized_receipt',
			'show_images_on_receipt_width_percent',
			'disabled_fixed_discounts',
			'always_put_last_added_item_on_top_of_cart',
			'hide_description_on_suspended_sales',
			'qr_code_format',
			'allow_drag_drop_sale',
			'allow_drag_drop_recv',
			'disable_signature_capture_on_terminal_for_phppos_credit_card_processing',
			'capture_internal_notes_during_receiving',
			'default_employee_for_deliveries',
			'disable_verification_for_qr_codes',
			'disable_variation_popup_in_receivings',
			'hide_location_name_on_receipt',
			'allow_reorder_sales_receipt',
			'allow_reorder_receiving_receipt',
			'disable_discount_by_percentage',
			'use_main_image_as_default_image_in_e_commerce',
			'disable_discounts_percentage_per_line_item',
			'create_invoices_for_customer_store_account_charges',
			'create_invoices_for_supplier_store_account_charges',
			'turn_on_review_requests',
			'send_sms_via_whatsapp',
			'additional_appointment_note',
			'number_of_decimals_displayed_on_sales_interface',
			'payvantage',
			'easy_item_clone_button',
			'customer_allow_partial_match',
			'enable_ig_integration',
			'ig_api_bearer_token',
			'enable_wgp_integration',
			'wgp_integration_pkey',
			'wgp_integration_userid',
			'work_order_notes_internal',
			'work_repair_item_taxable',
			'enable_p4_integration',
			'p4_api_bearer_token',
			'enable_quick_customers',
			'enable_quick_suppliers',
			'enable_quick_items',
			'enable_quick_expense',
			'hide_supplier_on_sales_interface',
			'require_to_add_serial_number_in_pos',
			'hide_supplier_on_recv_interface',
			'hide_supplier_from_item_popup',
			'sso_protocol',
			'only_allow_sso_logins',
			'saml_idp_entity_id',
			'saml_name_id_format',
			'saml_first_name_field',
			'saml_last_name_field',
			'saml_email_field',
			'saml_groups_field',
			'saml_locations_field',
			'saml_single_sign_on_service',
			'saml_single_logout_service',
			'saml_x509_cert',
			'default_location_transfer',
			'is_default_location_from_transfer',
			'default_location_from_transfer',
			'oidc_host',
			'oidc_client_id',
			'oidc_secret',
			'oidc_cert_url',
			'oidc_username_field',
			'oidc_groups_field',
			'oidc_locations_field',
			'oidc_additional_scopes',
			'add_ck_editor_to_item',
			'do_not_allow_edit_of_overall_subtotal',
			'work_order_device_locations',
			'automatically_email_invoice',
			'disable_default_value_for_tracking_number',
			'disable_supplier_selection_on_sales_interface',
			'only_allow_current_location_customers',
			'only_allow_current_location_employees',
			'hide_repair_items_in_sales_interface',
			'hide_repair_items_on_receipt',
			'update_base_cost_price_from_units',
			'enable_name_prefix',
			'create_work_order_for_customer',
			'default_tech_is_logged_employee',
			'override_employee_label_on_receipt',
			'remove_weight_from_receipt',
			'show_item_description_service_tag',
			'show_phone_number_service_tag',
			'change_work_order_status_from_sales',
			'work_order_status_on_complete',
			'create_work_order_is_checked_by_default_for_sale',
			'remove_tax_percent_on_receipt',
			'work_order_warranty_checked_product_price_zero',
			'show_custom_fields_service_tag_work_orders',
			'show_custom_fields_label_service_tag_work_orders',
			'show_estimated_repair_date_on_service_tag_work_orders',
			'change_to_recv_when_unsuspending_po',
			'dont_show_images_in_search_suggestions',
			'edit_work_order_web_hook',
			'new_work_order_web_hook',
			'edit_item_web_hook',
			'new_item_web_hook',
			'work_orders_show_condensed_receipt',
			'prompt_for_sale_id_on_return',
			'do_not_allow_sales_with_zero_value_line_items',
			'return_reasons',
			'require_receipt_for_return',
			'require_customer_for_return',
			'show_total_at_top_on_receipt',
			'ecommerce_realtime',
			'dont_lock_suspended_sales',
			'show_exchanged_totals_on_receipt',
			'show_prices_on_work_orders',
			'work_order_show_receipt_dropdown',
			'shopify_public', 'shopify_private'
		];

		$booleanFields = [
			'prices_include_tax', 'print_after_sale', 'print_after_receiving', 'round_cash_on_sales', 
			'enable_pdf_receipts', 'automatically_email_receipt', 'automatically_show_comments_on_receipt', 
			'barcode_price_include_tax', 'hide_signature', 'hide_customer_recent_sales', 'disable_confirmation_sale', 
			'confirm_error_adding_item', 'hide_layaways_sales_in_reports', 'hide_store_account_payments_in_reports', 
			'change_sale_date_when_suspending', 'change_sale_date_when_completing_suspended_sale', 'show_receipt_after_suspending_sale', 
			'customers_store_accounts', 'calculate_average_cost_price_from_receivings', 'show_language_switcher', 
			'show_clock_on_header', 'disable_giftcard_detection', 'hide_available_giftcards', 'show_giftcards_even_if_0_balance', 
			'always_show_item_grid', 'hide_out_of_stock_grid', 'require_customer_for_sale', 'hide_barcode_on_sales_and_recv_receipt', 
			'round_tier_prices_to_2_decimals', 'group_all_taxes_on_receipt', 'select_sales_person_during_sale', 
			'hide_suspended_recv_in_reports', 'remove_customer_contact_info_from_receipt', 'speed_up_search_queries', 
			'redirect_to_sale_or_recv_screen_after_printing_receipt', 'enable_sounds', 'charge_tax_on_recv', 
			'use_saudi_tax_config', 'use_saudi_tax_test_config', 'do_not_group_same_items', 'show_item_id_on_receipt', 
			'do_not_allow_out_of_stock_items_to_be_sold', 'edit_item_price_if_zero_after_adding', 'hide_out_of_stock_grid', 
			'automatically_print_duplicate_receipt_for_cc_transactions', 'disable_quick_complete_sale', 'require_employee_login_before_each_sale', 
			'reset_location_when_switching_employee', 'allow_employees_to_use_2fa', 'hide_store_account_balance_on_receipt', 
			'highlight_low_inventory_items_in_items_module', 'enable_customer_loyalty_system', 'hide_sales_to_discount_on_receipt', 
			'hide_price_on_barcodes', 'always_use_average_cost_method', 'test_mode', 'speedy_pos', 'require_customer_for_suspended_sale', 
			'default_new_items_to_service', 'prompt_for_ccv_swipe', 'disable_store_account_when_over_credit_limit', 
			'logout_on_clock_out', 'disable_test_mode', 'enable_ebt_payments', 'force_https', 'disable_price_rules_dialog', 
			'prompt_to_use_points', 'always_print_duplicate_receipt_all', 'wide_printer_receipt_format', 'remove_customer_company_from_receipt', 
			'do_not_allow_below_cost', 'hide_points_on_receipt', 'enable_markup_calculator', 'enable_margin_calculator', 
			'enable_quick_edit', 'show_orig_price_if_marked_down_on_receipt', 'include_child_categories_when_searching_or_reporting', 
			'remove_commission_from_profit_in_reports', 'remove_points_from_profit', 'capture_sig_for_all_payments', 
			'suppliers_store_accounts', 'hide_desc_on_receipt', 'hide_desc_emailed_receipts', 'loyalty_points_without_tax', 
			'remove_customer_name_from_receipt', 'enable_scale', 'do_not_force_http', 'enable_ebt_payments', 'ecommerce_only_sync_completed_orders', 
			'display_item_name_first_for_variation_name', 'do_not_allow_sales_with_zero_value', 'disable_sale_cloning', 
			'disable_recv_cloning', 'dont_recalculate_cost_price_when_unsuspending_estimates', 'show_signature_on_receiving_receipt', 
			'do_not_treat_service_items_as_virtual', 'prompt_amount_for_cash_sale', 'show_qr_code_for_sale', 'hide_categories_sales_grid', 
			'hide_tags_sales_grid', 'hide_suppliers_sales_grid', 'hide_favorites_sales_grid', 'do_not_allow_items_to_go_out_of_stock_when_transfering', 
			'show_tags_on_fulfillment_sheet', 'automatically_sms_receipt', 'offline_mode', 'auto_sync_offline_sales', 
			'show_total_on_fulfillment', 'remove_weight_from_receipt', 'change_work_order_status_from_sales', 
			'create_work_order_is_checked_by_default_for_sale', 'work_order_warranty_checked_product_price_zero', 
			'show_custom_fields_service_tag_work_orders', 'change_to_recv_when_unsuspending_po', 'dont_show_images_in_search_suggestions', 
			'work_orders_show_condensed_receipt', 'prompt_for_sale_id_on_return',
			'do_not_allow_sales_with_zero_value_line_items',
			'require_receipt_for_return',
			'require_customer_for_return',
			'show_total_at_top_on_receipt',
			'ecommerce_realtime',
			'dont_lock_suspended_sales',
			'show_exchanged_totals_on_receipt',
			'show_prices_on_work_orders',
			'work_order_show_receipt_dropdown',
			'prompt_to_use_points',
			'always_print_duplicate_receipt_all',
			'disable_loyalty_by_default',
			'dark_mode',
			'ecommerce_only_sync_completed_orders',
			'disable_sale_cloning',
			'disable_recv_cloning',
			'dont_recalculate_cost_price_when_unsuspending_estimates',
			'show_signature_on_receiving_receipt',
			'do_not_treat_service_items_as_virtual',
			'prompt_amount_for_cash_sale',
			'show_qr_code_for_sale',
			'hide_categories_sales_grid',
			'hide_tags_sales_grid',
			'hide_suppliers_sales_grid',
			'hide_favorites_sales_grid',
			'do_not_allow_items_to_go_out_of_stock_when_transfering',
			'show_tags_on_fulfillment_sheet',
			'automatically_sms_receipt',
			'offline_mode',
			'auto_sync_offline_sales',
			'show_total_on_fulfillment',
			'override_signature_text',
			'hide_categories_receivings_grid',
			'hide_tags_receivings_grid',
			'hide_suppliers_receivings_grid',
			'hide_favorites_receivings_grid',
			'delivery_color_based_on',
			'update_cost_price_on_transfer',
			'tip_preset_zero',
			'hide_supplier_in_item_search_result',
			'show_person_id_on_receipt',
			'import_ecommerce_orders_suspended',
			'show_images_on_receipt',
			'customized_receipt',
			'disabled_fixed_discounts',
			'always_put_last_added_item_on_top_of_cart',
			'hide_description_on_suspended_sales',
			'qr_code_format',
			'allow_drag_drop_sale',
			'allow_drag_drop_recv',
			'disable_signature_capture_on_terminal_for_phppos_credit_card_processing',
			'capture_internal_notes_during_receiving',
			'disable_verification_for_qr_codes',
			'disable_variation_popup_in_receivings',
			'hide_location_name_on_receipt',
			'allow_reorder_sales_receipt',
			'allow_reorder_receiving_receipt',
			'disable_discount_by_percentage',
			'use_main_image_as_default_image_in_e_commerce',
			'disable_discounts_percentage_per_line_item',
			'create_invoices_for_customer_store_account_charges',
			'create_invoices_for_supplier_store_account_charges',
			'turn_on_review_requests',
			'send_sms_via_whatsapp',
			'enable_wic',
			'do_not_allow_sales_with_zero_value',
			'remove_tax_percent_on_receipt',
			'work_order_warranty_checked_product_price_zero',
			'show_custom_fields_service_tag_work_orders',
			'show_custom_fields_label_service_tag_work_orders',
			'show_estimated_repair_date_on_service_tag_work_orders',
			'change_to_recv_when_unsuspending_po',
			'dont_show_images_in_search_suggestions',
			'work_orders_show_condensed_receipt',
		];

		$serializedFields = [
			'disable_modules',
			'track_payment_types',
			'item_lookup_order',
			'qb_sync_operations',
			'ecommerce_cron_sync_operations',
		];
		$notOnDemoHostFields = [
			'disable_modules',
			'email_provider',
			'smtp_crypto',
			'protocol',
			'smtp_host',
			'smtp_user',
			'smtp_pass',
			'smtp_port',
			'email_charset',
			'newline',
			'crlf',
			'smtp_timeout',
		];
		return [
			'batch_save_keys' => $batch_save_keys , 
			'booleanFields' => $booleanFields , 
			'serializedFields' => $serializedFields , 
			'notOnDemoHostFields' =>$notOnDemoHostFields
		];
	}
	function exists($key)
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);	
		$this->db->where('app_config.key',$key);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function get_all($location)
	{
	
		$location = 1;
		// if(isset($_SESSION['employee_current_location_id'])){
		// 	$location = $_SESSION['employee_current_location_id'];
		// }
		
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->order_by("key", "asc");
		// if($location!=1){
		// 	dd($this->db->get()->result_array());
		// }
		return $this->db->get();		
	}
	
	function get($key)
	{
		return $this->config->item($key);
	}
	
	function delete($key)
	{
		if ($key)
		{
			$this->db->where('key',$key);
			$this->db->delete('app_config');
		}
	}
	function save($key,$value , $location=false)
	{
		$config_data = array(
			'value'=>($value!=null)?$value:0,
			
		);
		if(!$location){
			$location=1;
			if($this->employee->get_logged_in_employee_current_location_id()){
				$location = $this->employee->get_logged_in_employee_current_location_id();
			}
		}
		

		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where('key', $key);
		 $data= $this->db->get();	
		 if ($data !== FALSE && $data->num_rows()>0) {
			
			$this->db->where('location_id', $location);
			$this->db->where('key', $key);
			return	$this->db->update('app_config', $config_data);
		 }else{
			$config_data = array(
				'key'=>$key,
				'value'=>($value!=null)?$value:0,
				'location_id' =>$location,
			);
			return $this->db->insert('app_config', $config_data);
		 }

		//return $this->db->replace('app_config', $config_data);
	}
	
	function get_key_directly_from_database($key)
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", $key);
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return NULL;	
	}
	function get_key_directly_from_database_via_location($key , $location)
	{
		
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", $key);
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return NULL;	
	}
	
	function get_raw_kill_ecommerce_cron()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "kill_ecommerce_cron");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}
	
	function get_raw_qb_cron_running()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "qb_cron_running");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}
	
	function get_raw_kill_qb_cron()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "kill_qb_cron");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}
	
	function get_raw_ecommerce_cron_running()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "ecommerce_cron_running");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}
	
	function ecommerce_has_run_recently()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "last_ecommerce_sync_date");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			$last_sync_date = strtotime($row['value']);
			$now = time();
			
			$minutes = round(abs($now - $last_sync_date) / 60);
			
			//If ran in last 5 hours consider that recent
			if ($minutes < (60*5))
			{
				return TRUE;
			}
		}
		
		return FALSE;	
		
		
	}	
	
	function get_raw_number_of_decimals()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "number_of_decimals");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 2;	
	}
	
	function get_raw_language_value()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "language");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return '';	
	}

	function get_raw_version_value()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "version");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return '';	
	}
		
	function get_force_https()
	{
		if ($this->db->table_exists('app_config'))
		{
			$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
			$this->db->from('app_config');
		$this->db->where('location_id', $location);
			$this->db->where("key", "force_https");
			$row = $this->db->get()->row_array();
			if (!empty($row))
			{
				return $row['value'];
			}
			return '';
		}
		
		return '';
	}
	
	function get_do_not_force_http()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
     $this->db->from('app_config');
		$this->db->where('location_id', $location);
     $this->db->where("key", "do_not_force_http");
     $row = $this->db->get()->row_array();
     if (!empty($row))
     {
			 return $row['value'];
     }
     return '';
	}
	
	function get_raw_phppos_session_expiration()
	{
		$location = 1;
		if(isset($_SESSION['employee_current_location_id'])){
			$location = $_SESSION['employee_current_location_id'];
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "phppos_session_expiration");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			if (is_numeric($row['value']))
			{
				return (int)$row['value'];
			}
			
		}
		return NULL;	
	}
	
	function batch_save($data)
	{
		if (isset($data['default_tax_1_name']))
		{
			//Check for duplicate taxes
			for($k = 1;$k<=5;$k++)
			{
				$current_tax = $data["default_tax_${k}_name"].$data["default_tax_${k}_rate"];
			
				for ($j = 1;$j<=5;$j++)
				{
					$check_tax = $data["default_tax_${j}_name"].$data["default_tax_${j}_rate"];
					if ($j!=$k && $current_tax != '' && $check_tax != '' && $current_tax != 0 && $check_tax != 0)
					{
						if ($current_tax == $check_tax)
						{
							return FALSE;
						}
					}
				}
			}
		}
		
		$success = true;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		foreach($data as $key=>$value)
		{
			if(!$this->save($key, $value))
			{
				$success=false;
				break;
			}
		}
		
		$this->db->trans_complete();	
	
		
		return $success;
		
	}
		
	function get_logo_image()
	{
		if ($this->config->item('company_logo'))
		{
			return secure_app_file_url($this->get('company_logo'));
		}
		return  base_url().$this->config->item('branding')['logo_path'];
	}
		
	function get_additional_payment_types()
	{
		$return = array();
		$payment_types = $this->get('additional_payment_types');
		
		if ($payment_types)
		{
			$return = array_map('trim', explode(',',$payment_types));
		}
		
		return $return;
	}
	
	function mark_mercury_activate($mercury_activate_seen = true)
	{
		$this->db->query('REPLACE INTO '.$this->db->dbprefix('app_config').' (`key`, `value`) VALUES ("mercury_activate_seen", "'.($mercury_activate_seen ? 1 : 0).'")');
	}
	
	function mark_reseller_message($reseller_activate_seen = true)
	{
		$this->db->query('REPLACE INTO '.$this->db->dbprefix('app_config').' (`key`, `value`) VALUES ("reseller_activate_seen", "'.($reseller_activate_seen ? 1 : 0).'")');
	}
		
	function set_all_locations_use_global_tax()
	{
		$this->load->model('Location');
		return $this->Location->set_all_locations_use_global_tax();
	}
	
	function all_locations_use_global_tax()
	{
		$this->load->model('Location');
		return $this->Location->all_locations_use_global_tax();
	}
	
	function get_primary_key_next_index($table)
	{
		$tables_to_col = array(
			'items' => 'item_id',
			'item_kits'=> 'item_kit_id',
			'sales' => 'sale_id',
			'receivings' => 'receiving_id',	
		);
		
		if(isset($tables_to_col[$table]))
		{
			$this->db->select("IFNULL(MAX(".$tables_to_col[$table]."),0)+1 as max_id", false);
			$this->db->from($table);
			$max_id = $this->db->get()->row()->max_id;
			
			return $max_id;
		}
		
		return false;
	}
	
	function change_auto_increment($table, $value)
	{	
		if(!is_numeric($value) || intval($value) < 1)
		{
			return false;
		}
		
		$max = intVal($this->get_primary_key_next_index($table));
			
		if(intval($value) < $max)
		{
			$value = $max +1;
		}
			
		$this->db->query('ALTER TABLE '. $this->db->dbprefix($table). ' AUTO_INCREMENT '. $value);
		
		return $value;
	}
	
	function get_exchange_rates()
	{
		$this->db->from('currency_exchange_rates');
		$this->db->order_by('id');
		return $this->db->get();
	}
		
	
	
	
	function save_exchange_rates($currency_exchange_rates_to, $currency_exchange_rates_symbol, $currency_exchange_rates_rate,$currency_exchange_rates_symbol_location,$currency_exchange_rates_number_of_decimals,$currency_exchange_rates_thousands_separator,$currency_exchange_rates_decimal_point)
	{
		$this->db->truncate('currency_exchange_rates');
		$currency_exchange_rates_to = $currency_exchange_rates_to ? $currency_exchange_rates_to : array();
		for($k = 0; $k< count($currency_exchange_rates_to); $k++)
		{
			$currency_exchange_rate_to = $currency_exchange_rates_to[$k];
			$currency_exchange_rate_symbol = $currency_exchange_rates_symbol[$k];
			$currency_exchange_rate = $currency_exchange_rates_rate[$k];			
			$currency_exchange_rate_symbol_location = $currency_exchange_rates_symbol_location[$k];
			$currency_exchange_rate_number_of_decimals = $currency_exchange_rates_number_of_decimals[$k];
			$currency_exchange_rate_thousands_separator = $currency_exchange_rates_thousands_separator[$k];
			$currency_exchange_rate_decimal_point = $currency_exchange_rates_decimal_point[$k];
				
			$this->db->insert('currency_exchange_rates', array(
				'currency_symbol' => $currency_exchange_rate_symbol,
				'currency_code_to' => $currency_exchange_rate_to,
				'exchange_rate' => $currency_exchange_rate,
				'currency_symbol_location' => $currency_exchange_rate_symbol_location,
				'number_of_decimals' => $currency_exchange_rate_number_of_decimals,
				'thousands_separator' => $currency_exchange_rate_thousands_separator,
				'decimal_point' => $currency_exchange_rate_decimal_point,
			));
		}
		
		return true;
	}
	
	public function get_api_keys()
	{
		$this->db->from('keys');
		$this->db->order_by('id');
		return $this->db->get()->result();
	}

	function get_qb_classes()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "qb_classes");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}

	function get_qb_journal_entry_records()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "qb_journal_entry_records");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}

	
	
  public function generate_key()
  {
    do
    {
        // Generate a random salt
        $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

        // If an error occurred, then fall back to the previous method
        if ($salt === FALSE)
        {
            $salt = hash('sha256', time() . mt_rand());
        }

        $new_key = substr($salt, 0, config_item('rest_key_length'));
    }
    while ($this->key_exists($new_key));

    return $new_key;
  }
	
  /* Private Data Methods */


  private function key_exists($key)
  {
      return $this->db
          ->where(config_item('rest_key_column'), $key)
          ->count_all_results(config_item('rest_keys_table')) > 0;
  }

  public function insert_key($key, $data)
  {
      $data[config_item('rest_key_column')] = sha1($key);
			$data['key_ending'] = substr($key,-7);
      $data['date_created'] = function_exists('now') ? now() : time();

      return $this->db
          ->set($data)
          ->insert(config_item('rest_keys_table'));
  }
	public function delete_api_key($api_key_id)
	{
  	$this->db->where('id', $api_key_id)->delete(config_item('rest_keys_table'));
	}
	
	public function get_barcoded_labels()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->order_by("key", "asc");
		$this->db->like('key','barcoded_labels_','after');
		return $this->db->get();		
	}
	
	function get_ecommerce_locations()
	{
		$return = array();
		
		$this->db->from('ecommerce_locations');
		$rows = $this->db->get()->result_array();
		
		foreach($rows as $row)
		{
			$return[$row['location_id']] = TRUE;
		}
		
		if (empty($return))
		{
			$return[1] = TRUE;			
		}
		
		return $return;
	}
	
	function save_ecommerce_locations($locations)
	{
		$this->db->truncate('ecommerce_locations');
		
		if (is_array($locations))
		{
			foreach($locations as $location_id)
			{
				$this->db->insert('ecommerce_locations',array('location_id' => $location_id));
			}
		}
		else
		{
			$this->db->insert('ecommerce_locations',array('location_id' => 1));
		}
	}
	function get_damaged_reasons_options()
	{
		$damaged_reason_options = array();
		$damaged_reason_options[''] = lang('none');
		$reasons = explode(',',$this->config->item('damaged_reasons'));
		
		if ($reasons[0] != '')
		{
			foreach($reasons as $reason)
			{
				$damaged_reason_options[$reason] = $reason;
			}
		}
		return $damaged_reason_options;
	}
	
	function get_secure_key()
	{
		if ($this->exists('phppos_secure_key'))
		{
			return $this->get('phppos_secure_key');
		}
		
		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$secure_key = bin2hex(openssl_random_pseudo_bytes(16));
		}
		else
		{
			$secure_key = md5(rand());
		}
		
		$this->save('phppos_secure_key',$secure_key);	
		return $secure_key;
	}

	function get_replaceable_keywords(){
		return array(
			"company_name"			=> "{{company_name}}",
			"company_website"		=> "{{company_website}}",
			"location_name"			=> "{{location_name}}",
			"location_address"		=> "{{location_address}}",
			"location_company"		=> "{{location_company}}",
			"location_website"		=> "{{location_website}}",
			"location_phone"		=> "{{location_phone}}",
			"location_fax"			=> "{{location_fax}}",
			"location_email"		=> "{{location_email}}",
			"person_first_name"		=> "{{person_first_name}}",
			"person_last_name"		=> "{{person_last_name}}",
			"person_full_name"		=> "{{person_full_name}}",
			"person_phone"			=> "{{person_phone}}",
			"person_email"			=> "{{person_email}}",
			"person_address_1"		=> "{{person_address_1}}",
			"person_address_2"		=> "{{person_address_2}}",
			"person_city"			=> "{{person_city}}",
			"person_state"			=> "{{person_state}}",
			"person_zip"			=> "{{person_zip}}",
			"person_country"		=> "{{person_country}}",
			"employee_first_name"	=> "{{employee_first_name}}",
			"employee_last_name"	=> "{{employee_last_name}}",
			"employee_full_name"	=> "{{employee_full_name}}",
			"employee_phone"		=> "{{employee_phone}}",
			"employee_email"		=> "{{employee_email}}",
			"employee_address_1"	=> "{{employee_address_1}}",
			"employee_address_2"	=> "{{employee_address_2}}",
			"employee_city"			=> "{{employee_city}}",
			"employee_state"		=> "{{employee_state}}",
			"employee_zip"			=> "{{employee_zip}}",
			"employee_country"		=> "{{employee_country}}",
		);
	}

	function replace_keywords_with_actual_word($text, $location_id=null, $person_id=null, $employee_id=null){
		extract($this->get_replaceable_keywords());

		$text = str_replace(
			array($company_name, $company_website), 
			array($this->config->item('company'), $this->config->item('website')), 
			$text
		);

		if($location_id){
			$location = $this->Location->get_info($location_id);
			$text = str_replace(
				array($location_name, $location_address, $location_company, $location_website, $location_phone, $location_fax, $location_email), 
				array($location->name, $location->address, $location->company, $location->website, $location->phone, $location->fax, $location->email), 
				$text
			);
		}

		if($person_id){
			$person = $this->Person->get_info($person_id);
			$text = str_replace(
				array($person_first_name, $person_last_name, $person_full_name, $person_phone, $person_email, $person_address_1, $person_address_2, $person_city, $person_state, $person_zip, $person_country), 
				array($person->first_name, $person->last_name, $person->full_name, $person->phone_number, $person->email, $person->address_1, $person->address_2, $person->city, $person->state, $person->zip, $person->country), 
				$text
			);
		}

		if($employee_id){
			$employee = $this->employee->get_info($employee_id);
			$text = str_replace(
				array($employee_first_name, $employee_last_name, $employee_full_name, $employee_phone, $employee_email, $employee_address_1, $employee_address_2, $employee_city, $employee_state, $employee_zip, $employee_country), 
				array($employee->first_name, $employee->last_name, $employee->full_name, $employee->phone_number, $employee->email, $employee->address_1, $employee->address_2, $employee->city, $employee->state, $employee->zip, $employee->country), 
				$text
			);
		}

		return $text;
	}
	
	function get_raw_zatca_cron_running()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "zatca_cron_running");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			return $row['value'];
		}
		return 0;	
	}

	function zatca_has_run_recently()
	{
		$location = 1;
		if($this->employee->get_logged_in_employee_current_location_id()){
			$location = $this->employee->get_logged_in_employee_current_location_id();
		}
		$this->db->from('app_config');
		$this->db->where('location_id', $location);
		$this->db->where("key", "last_zatca_sync_date");
		$row = $this->db->get()->row_array();
		if (!empty($row))
		{
			$last_sync_date = strtotime($row['value']);
			$now = time();
			
			$minutes = round(abs($now - $last_sync_date) / 60);
			
			//If ran in last 5 hours consider that recent
			if ($minutes < (60*5))
			{
				return TRUE;
			}
		}
		return FALSE;	
	}	

	function save_zatca_config($data){
		$is_exist = $this->exist_zatca_config($data['location_id']);

		if($is_exist){
			$this->db->where('location_id', $data['location_id']);
			$ret = $this->db->update('zatca_config',$data);
			return $ret;
		}else{
			if($this->db->insert('zatca_config',$data))
			{
				return true;
			}
			return false;
		}
	}

	function exist_zatca_config($location_id){
		$this->db->from('zatca_config');
		$this->db->where('location_id', $location_id);
		
		$query = $this->db->get();
		return ($query->num_rows()==1);
	}

	function get_zatca_config($location_id){
		$this->db->from('zatca_config');
		$this->db->where('location_id', $location_id);
		
		$query = $this->db->get();
		if($query && $query->num_rows() == 1)
			return $query->row_array();
		return null;
	}	

	function save_woo_api_keys($key, $secret) {
		$this->db->where('key', 'woo_api_key')->update('app_config', ['value' => $key]);
    	$result = $this->db->where('key', 'woo_api_secret')->update('app_config', ['value' => $secret]);

		return $result;
	}
}		

?>
<?php
	/**********
	 * Main installer settings
	 *
	 */	
	$config["app_name"]       = "Sareeh Installer";
	$config["app_url"]        = "https://myci3.app";
	$config["redirect_url_on_finish"] = 'auth/login';
	$config["php_min_version_str"] = '5.6+';
	$config["php_min_version_int"] = '50600';

	/**********
	 * config.php values
	 *
	 */	
	$config["time_reference"] = "local";

	/**********
	 * Frontend settings
	 *
	 */		
	$config["head_title"]     = "Sareeh Installer";
	$config["head_subtitle"]  = "INSTALLATION WIZARD";
	
	/**********
	 * Create admin user settings
	 *
	 */	
	$config["create_admin"]                = true;
	$config["create_admin_table"]          = 'users';
	$config["create_admin_ask_email"]      = true;
	$config["create_admin_email_field"]    = 'email';
	$config["create_admin_ask_password"]   = true;
	$config["create_admin_password_field"] = 'password';
	$config["create_admin_password_hash"]  = 'bcrypt';
	
	
	
	
	/**********
	 * l18m
	 *
	 */		
	$config["lang_head_title"]            = "Facility";
	$config["lang_wizard_step"]           = "Step";
	$config["lang_wizard_label_finish"]   = "Installer";
	$config["lang_wizard_label_next"]     = "Next";
	$config["lang_wizard_label_previous"] = "Previous";
	$config["lang_wizard_label_loading"]  = "Loading";

	$config["lang_wizard_step1_title"]       = "Requirements";
	$config["lang_wizard_step1_pre_info"]    = "Verify that you meet all the requirements before proceeding.";
	$config["lang_wizard_step1_post_error"]  = "Fix the errors to continue with the installation.";
	$config["lang_wizard_step1_thead1"]      = "Item";
	$config["lang_wizard_step1_thead2"]      = "Required";
	$config["lang_wizard_step1_thead3"]      = "Current";
	$config["lang_wizard_step1_tbody1_item"] = "Current";
	$config["lang_wizard_step1_tbody2_item"] = "Write configuration file";
	$config["lang_wizard_step1_tbody3_item"] = "Write BDD file";
	$config["lang_wizard_step1_tbody4_item"] = "Path to temporary files";
	$config["lang_wizard_step1_tbody5_item"] = "write temporary files";

	$config["lang_wizard_step2_title"]              = "Database configuration";
	$config["lang_wizard_step2_pre_info"]           = "Next you must enter the connection data with your database. If you don't know them, contact your hosting provider";
	$config["lang_wizard_step2_label_host"]         = "Database Host";
	$config["lang_wizard_step2_label_user"]         = "User";
	$config["lang_wizard_step2_label_pass"]         = "Password";
	$config["lang_wizard_step2_label_dbname"]       = "Database name";
	$config["lang_wizard_step2_placeholder_host"]   = "Host";
	$config["lang_wizard_step2_placeholder_user"]   = "Username database";
	$config["lang_wizard_step2_placeholder_pass"]   = "User password";
	$config["lang_wizard_step2_placeholder_dbname"] = "Database name";
	$config["lang_wizard_step2_req_host"]           = "Enter the MySQL server host";
	$config["lang_wizard_step2_req_user"]           = "Enter the MySQL user";
	$config["lang_wizard_step2_req_dbname"]         = "Enter the name of the MySQL database";
	
	$config["lang_modal_step2_testing_title"]     = "Testing connection";
	$config["lang_modal_step2_testing_body"]      = "Wait for  a minute";
	$config["lang_modal_step2_connect_title"]     = "Satisfactory Connection";
	$config["lang_modal_step2_connect_body"]      = "Continue...";
	$config["lang_modal_step2_connect_err_title"] = "Failed to connect";
	$config["lang_modal_step2_connect_err_body"]  = "Review the connection data to continue...";

	$config["lang_wizard_step3_title"]     = "site url";
	$config["lang_wizard_step3_pre_info"]  = "The base URL of the site";
	$config["lang_wizard_step3_post_info"] = "We detect the URL automatically. You probably don't need to change this value.";

	$config["lang_wizard_step4_title"]             = "Administator";
	$config["lang_wizard_step4_label_email"]       = "Email Administator";
	$config["lang_wizard_step4_label_pass"]        = "Password Administator";
	$config["lang_wizard_step4_placeholder_email"] = "Administrator Email";
	$config["lang_wizard_step4_placeholder_pass"]  = "Password for Administrator";
	$config["lang_wizard_step4_req_email"] = "Enter the administrator's email";
$config["lang_wizard_step4_req_pass"] = "Enter the administrator's password";

$config["lang_modal_submit_title"] = "Installing the application";
$config["lang_modal_submit_body"] = "Please wait a moment...";
$config["lang_modal_submit_finish_title"] = "Installation Completed";
$config["lang_modal_submit_finish_body"] = "The application is ready to use. You will now be redirected to the application. Thank you for your time.";
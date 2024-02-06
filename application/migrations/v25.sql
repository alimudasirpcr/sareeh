CREATE TABLE phppos_meters (
    meter_id INT AUTO_INCREMENT PRIMARY KEY,
    meter_number varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    description text COLLATE utf8_unicode_ci NOT NULL,
    customer_id INT,  
    address VARCHAR(255),
    installation_date DATE,
    meter_type VARCHAR(255),
    inactive int(1) NOT NULL DEFAULT 0,
    deleted int(1) NOT NULL DEFAULT 0,
    status ENUM('active', 'inactive', 'under_maintenance')
);

CREATE TABLE phppos_meterreading (
    reading_id INT AUTO_INCREMENT PRIMARY KEY,
    meter_id INT,
    customer_id INT,  
    reading_date DATE,
    reading_value DECIMAL(10, 2),
    employee_id INT,
    description text COLLATE utf8_unicode_ci NOT NULL,
    inactive int(1) NOT NULL DEFAULT 0,
    deleted int(1) NOT NULL DEFAULT 0,
    );

CREATE TABLE phppos_billings (
    bill_id INT AUTO_INCREMENT PRIMARY KEY,
    meter_id INT,
    customer_id INT, 
    billing_period_start DATE,
    billing_period_end DATE,
    previous_balance DECIMAL(10, 2) DEFAULT 0.00,
    current_charges DECIMAL(10, 2),
    taxes DECIMAL(10, 2),
    total_amount_due DECIMAL(10, 2),
    amount_due DECIMAL(10, 2),
    due_date DATE ,
     inactive int(1) NOT NULL DEFAULT 0,
    deleted int(1) NOT NULL DEFAULT 0,
);





CREATE TABLE phppos_OverdueCharges (
    overdue_id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT,
    customer_id INT, 
    payment_id INT,  -- To link the overdue charge with a specific payment
    overdue_date DATE,
    fine_amount DECIMAL(10, 2),
    inactive int(1) NOT NULL DEFAULT 0,
    deleted int(1) NOT NULL DEFAULT 0,
);


ALTER TABLE `phppos_modules_actions` ADD `id` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);
ALTER TABLE `phppos_modules` ADD `id` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES ('module_meters', 'meters', '33', '', 'meters');

INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'add_update', 'meters', 'module_action_add_update', '200'), (NULL, 'edit_meter_value', 'meters', 'module_edit_meter_value', '205'), (NULL, 'search', 'meters', 'module_action_search_meters', '220'), (NULL, 'delete', 'meters', 'module_action_delete', '210'), (NULL, 'excel_export', 'meters', 'common_excel_export', '225')



CREATE TABLE `phppos_meters_log` (
  `id` int(10) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `meter_id` int(11) NOT NULL,
  `transaction_amount` decimal(23,10) NOT NULL,
  `log_message` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `phppos_meterreading_log` (
  `id` int(10) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reading_id` int(11) NOT NULL,
  `transaction_amount` decimal(23,10) NOT NULL,
  `log_message` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES ('module_meterreadings', 'meterreadings', '33', '', 'meterreadings');

INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'add_update', 'meterreadings', 'module_action_add_update', '200'), (NULL, 'edit_meterreading_value', 'meterreadings', 'module_edit_meterreading_value', '205'), (NULL, 'search', 'meterreadings', 'module_action_search_meterreadings', '220'), (NULL, 'delete', 'meterreadings', 'module_action_delete', '210'), (NULL, 'excel_export', 'meterreadings', 'common_excel_export', '225'), (NULL, 'view_meterreadings', 'reports', 'view_meterreadings', '225')

ALTER TABLE `phppos_meterreading` ADD `rate` DOUBLE NOT NULL DEFAULT '1.0' AFTER `description`;
ALTER TABLE `phppos_meterreading` ADD `location_id` INT(11) NOT NULL DEFAULT '1' AFTER `rate`;
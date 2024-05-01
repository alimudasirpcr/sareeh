UPDATE `phppos_app_config` SET value="24.0" WHERE `key` = 'version';

CREATE TABLE `phppos_payments` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `session_id` VARCHAR(255) NOT NULL  ,
    `total_amount` VARCHAR(255) NOT NULL  ,
    `currency` VARCHAR(255) NOT NULL  ,
    `payment_status` VARCHAR(255) NOT NULL  ,
    `mode` VARCHAR(255) NOT NULL  ,
    `pay_json` LONGTEXT NOT NULL  ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `phppos_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `amount` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `duedate` date DEFAULT NULL ,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('client_id', '26');

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('thawani_api_key', 'rRQ26GcsZzoEhbrP2HZvLYDbn9C9et'), ('thawani_sec_key', 'HGvTMLDssJghr9tlN9gr4DVYt0qyBy');

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('thawani_is_sandbox', 'true');

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('erp_url', '<http://localhost/erp/>');

CREATE TABLE `phppos_tables` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `title` VARCHAR(255) NOT NULL , `ptop` VARCHAR(255) NOT NULL , `pleft` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `phppos_charis` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `table_id` INT(11) NOT NULL , `status` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `phppos_tables` ADD `rotate` VARCHAR(255) NOT NULL AFTER `pleft`;

ALTER TABLE `phppos_tables` ADD `no_of_chairs` INT(11) NOT NULL AFTER `rotate`;

CREATE TABLE `phppos_reserved` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `table_id` INT(11) NOT NULL , `date_from` DATETIME NOT NULL , `date_to` DATETIME NOT NULL , `status` ENUM('Reserved','Checked-in') NOT NULL DEFAULT 'Reserved' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `phppos_sales` ADD `is_order` TINYINT NULL DEFAULT '0' AFTER `override_tax_class_id`, ADD `order_status` VARCHAR(255) NULL DEFAULT 'New' AFTER `is_order`, ADD `table_id` INT(11) NULL DEFAULT '0' AFTER `order_status`;

ALTER TABLE `phppos_reserved` ADD `from_new_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`, ADD `to_new_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `from_new_time`, ADD `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `to_new_time`;

CREATE TABLE `phppos_receipts_template` (
`id` int(11) NOT NULL,
`title` varchar(255) NOT NULL,
`status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `phppos_receipts_template`
ADD PRIMARY KEY (`id`);
ALTER TABLE `phppos_receipts_template`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `phppos_receipts_template` ADD `positions` LONGTEXT NULL AFTER `status`;

ALTER TABLE `phppos_sales` ADD `delivery_type` ENUM('Dine In','Pickup','Home Delivery') NOT NULL DEFAULT 'Dine In' AFTER `table_id`;

CREATE TABLE `phppos_floor` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `image` VARCHAR(255) NOT NULL , `location` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `phppos_tables` ADD `floor_id` INT(11) NOT NULL DEFAULT '1' AFTER `no_of_chairs`;

ALTER TABLE `phppos_registers` ADD `categories` VARCHAR(256) NULL AFTER `enable_tips`;

ALTER TABLE `phppos_sales_items` ADD `is_prepared` TINYINT NOT NULL DEFAULT '0' AFTER `is_repair_item`;

ALTER TABLE `phppos_registers` ADD `receipt_type` INT NOT NULL DEFAULT '1' AFTER `categories`;


INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('license_key', '');

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('package', '1');

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('industry', 'Food');

CREATE TABLE `phppos_service_types` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(256) NOT NULL , `status` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('quick_access', '');

ALTER TABLE `phppos_items` ADD `warranty_days` INT(10) NOT NULL DEFAULT '0' AFTER `shopify_item_level_inventory_policy`;

ALTER TABLE `phppos_sales_items` ADD `warranty` INT(11) NOT NULL DEFAULT '0' AFTER `is_prepared`;

ALTER TABLE `phppos_sales_item_kits` ADD `warranty` INT(11) NOT NULL DEFAULT '0' AFTER `is_repair_item`;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('view_work_order', 'reports', 'reports_work_order', '255');

ALTER TABLE `phppos_sales` ADD `time_remaning` VARCHAR(255) NOT NULL AFTER `delivery_type`;

ALTER TABLE `phppos_sales` ADD `is_work_order` TINYINT NOT NULL DEFAULT '0' AFTER `time_remaning`;

ALTER TABLE `phppos_messages` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

ALTER TABLE `phppos_messages` ADD `receiver_id` INT(11) NOT NULL AFTER `sender_id`;

ALTER TABLE `phppos_messages` ADD `time` VARCHAR(256) NOT NULL AFTER `deleted`;

ALTER TABLE `phppos_employees` ADD `is_active` INT(11) NOT NULL DEFAULT '0' AFTER `secret_key_2fa`;

ALTER TABLE `phppos_employees` ADD `image` VARCHAR(256) NOT NULL AFTER `is_active`;

ALTER TABLE phppos_messages DROP FOREIGN KEY phppos_messages_ibfk_1;

ALTER TABLE `phppos_employees` ADD `quick_access` LONGTEXT NOT NULL AFTER `image`;

INSERT INTO `phppos_app_config` (`key`, `value`) VALUES ('default_location_transfer', '0');

ALTER TABLE `phppos_locations` ADD `business_type` VARCHAR(255) NOT NULL DEFAULT 'Retail' AFTER `company`;

CREATE TABLE `phppos_removed_items_log` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `item_id` INT(11) NOT NULL , `sales_id` INT(11) NOT NULL , `register_id` INT(11) NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES ('module_receipt\\r\\n', 'receipt', '222', '', 'receipt');

ALTER TABLE `phppos_sales_items` ADD `original_sale_id` INT(11) NULL AFTER `warranty`, ADD `original_sale_time` TIMESTAMP NULL DEFAULT NULL AFTER `original_sale_id`;

ALTER TABLE `phppos_app_config` ADD `location_id` INT(11) NOT NULL DEFAULT '1' AFTER `value`;

ALTER TABLE `phppos_app_config` DROP PRIMARY KEY;

ALTER TABLE `phppos_app_config` ADD `id` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

CREATE TABLE `phppos_notifications` (
`id` int(11) NOT NULL,
`module_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`status` tinyint(4) NOT NULL DEFAULT 0,
`location_id` int(11) NOT NULL,
`employee_id` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `phppos_notifications`
ADD PRIMARY KEY (`id`);

ALTER TABLE `phppos_notifications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `phppos_notifications` ADD `message` TEXT NOT NULL AFTER `created_at`;

ALTER TABLE `phppos_notifications` ADD `module` VARCHAR(256) NOT NULL AFTER `module_id`;

ALTER TABLE `phppos_notifications` CHANGE `module_id` `module_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `phppos_registers` ADD `enable_tips` INT(1) NOT NULL DEFAULT '1' AFTER `emv_pinpad_port`, ADD `categories` VARCHAR(255) NULL AFTER `enable_tips`, ADD `receipt_type` INT(11) NOT NULL AFTER `categories`;

ALTER TABLE `phppos_registers` ADD `hide_categories` TINYINT NOT NULL DEFAULT '0' AFTER `receipt_type`, ADD `hide_search_bar` TINYINT NOT NULL DEFAULT '0' AFTER `hide_categories`, ADD `hide_top_buttons` TINYINT NOT NULL DEFAULT '0' AFTER `hide_search_bar`, ADD `hide_top_item_details` TINYINT NOT NULL DEFAULT '0' AFTER `hide_top_buttons`, ADD `hide_top_category_navigation` TINYINT NOT NULL DEFAULT '0' AFTER `hide_top_item_details`;

ALTER TABLE `phppos_items_serial_numbers` ADD `warranty_start` VARCHAR(255) NULL DEFAULT NULL AFTER `serial_location_id`, ADD `warranty_end` VARCHAR(255) NULL DEFAULT NULL AFTER `warranty_start`;

ALTER TABLE `phppos_items_serial_numbers` ADD `is_sold` TINYINT NOT NULL DEFAULT '0' AFTER `warranty_end`, ADD `sold_warranty_start` VARCHAR(256) NULL DEFAULT NULL AFTER `is_sold`, ADD `sold_warranty_end` VARCHAR(256) NULL DEFAULT NULL AFTER `sold_warranty_start`;

ALTER TABLE `phppos_items_serial_numbers` ADD `replace_sale_date` TINYINT NOT NULL DEFAULT '0' AFTER `sold_warranty_end`;

 ALTER TABLE `phppos_register_log` CHANGE `shift_end` `shift_end` VARCHAR(255) NOT NULL DEFAULT '0000-00-00 00:00:00';

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit_suspended_recevings', 'sales', 'edit_suspended_recevings', '500');

CREATE TABLE `phppos_sn_log` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `action` VARCHAR(255) NOT NULL , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `sn_id` INT NOT NULL , `added_by` INT(11) NOT NULL , `Remarks` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `phppos_sales_items` ADD `assigned_repair_item` INT(11) NOT NULL DEFAULT '0' AFTER `original_sale_time`;

ALTER TABLE `phppos_sales_item_kits` ADD `assigned_repair_item` INT(11) NOT NULL DEFAULT '0' AFTER `warranty`;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_edit_sn_log_remarks', 'items', 'allow_edit_sn_log_remarks', '277');

INSERT INTO `phppos_app_config` (`id`, `key`, `value`, `location_id`) VALUES (NULL, 'require_to_add_serial_number_in_pos', '0', '1');

INSERT INTO `phppos_app_config` (`id`, `key`, `value`, `location_id`) VALUES (NULL, 'is_default_location_from_transfer', '0', '1');

INSERT INTO `phppos_app_config` (`id`, `key`, `value`, `location_id`) VALUES (NULL, 'default_location_from_transfer', '0', '1');

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit_variation', 'sales', 'edit_variation', '444');

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('show_cost_price', 'work_orders', 'show_cost_price', '333');

INSERT INTO `phppos_app_config` (`id`, `key`, `value`, `location_id`) VALUES (NULL, 'customized_receipt', '0', '1');


ALTER TABLE `phppos_messages` ADD `seen` TINYINT NOT NULL DEFAULT '0' AFTER `time`;



ALTER TABLE `phppos_notifications` ADD `location_from` INT(11) NOT NULL AFTER `location_id`;
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_from', 'receivings', 'allow_detach_from', '4444');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_to', 'receivings', 'allow_detach_to', '4445');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_from_edit', 'receivings', 'allow_detach_from_edit', '4446');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_to_edit', 'receivings', 'allow_detach_to_edit', '4447');


INSERT INTO `phppos_app_config` (`id`, `key`, `value`, `location_id`) VALUES (NULL, 'terms', 'terms and conditions', '1');
ALTER TABLE `phppos_locations` ADD `auto_reports_email_day` TEXT NOT NULL AFTER `auto_reports_day`;


ALTER TABLE `phppos_receipts_template` ADD `size` VARCHAR(255) NOT NULL DEFAULT 'A4' AFTER `positions`, ADD `width` DOUBLE NOT NULL DEFAULT '0' AFTER `size`, ADD `height` DOUBLE NOT NULL DEFAULT '0' AFTER `width`, ADD `default_wo` TINYINT NOT NULL DEFAULT '0' AFTER `height`, ADD `default_pos` TINYINT NOT NULL DEFAULT '0' AFTER `default_wo`, ADD `default_estimate` TINYINT NOT NULL DEFAULT '0' AFTER `default_pos`, ADD `background_image` VARCHAR(255) NOT NULL AFTER `default_estimate`, ADD `logo_image` VARCHAR(255) NOT NULL AFTER `background_image`, ADD `custom_text` LONGTEXT NOT NULL AFTER `logo_image`;

ALTER TABLE `phppos_receipts_template` CHANGE `background_image` `background_image` INT(11) NOT NULL DEFAULT '0', CHANGE `logo_image` `logo_image` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `phppos_sale_types` ADD `location` INT(11) NOT NULL DEFAULT '1' AFTER `remove_quantity`;

INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'list', 'sales', 'sales_list', ''), (NULL, 'list', 'receivings', 'receiving_list', '');
ALTER TABLE `phppos_meters_log` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `phppos_register_log` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `deleted`;
INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'edit_serail_no', 'sales', 'edit_serail_no', '555');
INSERT INTO `phppos_sale_types` (`id`, `name`, `sort`, `system_sale_type`, `remove_quantity`, `location`) VALUES (NULL, 'hold_cart', '1', '1', '1', '1');




INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'show_top_items_category', 'sales', 'show_top_items_category', '555');
INSERT INTO `phppos_modules_actions` (`id`, `action_id`, `module_id`, `action_name_key`, `sort`) VALUES (NULL, 'show_my_sareeh_category', 'sales', 'show_my_sareeh_category', '555');


ALTER TABLE `phppos_app_files` ADD `gallery` TINYINT NOT NULL DEFAULT '0' AFTER `expires`;

ALTER TABLE `phppos_receipts_template` ADD `template_group` VARCHAR(255) NOT NULL DEFAULT 'Recipts and Invoices' AFTER `status`;

CREATE TABLE `sareeh_sareeh`.`phppos_receipts_template_label` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `receipts_template_id` INT(11) NOT NULL , `label_name` VARCHAR(255) NOT NULL , `label_text` VARCHAR(255) NOT NULL , `is_general` TINYINT NOT NULL DEFAULT '1' , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;


ALTER TABLE `phppos_receipts_template` ADD `header_percentage` VARCHAR(255) NOT NULL DEFAULT '20%' AFTER `custom_text`, ADD `body_percentage` VARCHAR(255) NOT NULL DEFAULT '60%' AFTER `header_percentage`, ADD `footer_percentage` VARCHAR(255) NOT NULL DEFAULT '20%' AFTER `body_percentage`;

ALTER TABLE `phppos_receipts_template` ADD `first_page_items` INT(11) NOT NULL DEFAULT '1' AFTER `footer_percentage`, ADD `other_page_items` INT(11) NOT NULL DEFAULT '1' AFTER `first_page_items`;
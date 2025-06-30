





INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('can_change_report_date', 'reports', 'reports_can_change_report_date', 305);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'reports' and
action_id = 'can_change_report_date'
order by module_id, person_id;

ALTER TABLE phppos_items
  ADD COLUMN ecommerce_inventory_item_id varchar(255) DEFAULT NULL,
  ADD COLUMN weight_unit varchar(255) DEFAULT NULL,
  ADD COLUMN is_recurring int(1) DEFAULT 0,
  ADD COLUMN startup_cost decimal(23,10) DEFAULT 0.0000000000,
  ADD COLUMN prorated int(1) DEFAULT 0,
  ADD COLUMN `interval` varchar(255) DEFAULT NULL,
  ADD COLUMN weekday int(1) DEFAULT NULL,
  ADD COLUMN day_number int(10) DEFAULT NULL,
  ADD COLUMN month int(10) DEFAULT NULL,
  ADD COLUMN day varchar(255) DEFAULT NULL,
  ADD COLUMN shopify_item_level_inventory_policy varchar(255) DEFAULT NULL,
  ADD COLUMN warranty_days int(10) NOT NULL DEFAULT 0;
  
ALTER TABLE `phppos_items` ADD `is_bookable` TINYINT(4) NOT NULL DEFAULT '0' AFTER `loyalty_multiplier`;
ALTER TABLE `phppos_items` ADD `before_delay` INT(11) NOT NULL AFTER `is_bookable`;
ALTER TABLE `phppos_items` ADD `after_delay` INT(11) NOT NULL AFTER `before_delay`;
ALTER TABLE `phppos_items` ADD `item_status` INT(11) NOT NULL DEFAULT '0' AFTER `is_favorite`;





update  `phppos_items` set item_status= 1;



CREATE TABLE `phppos_workorder_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `notify_by_email` tinyint(1) DEFAULT 0,
  `notify_by_sms` tinyint(1) DEFAULT 0,
  `color` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






INSERT INTO `phppos_workorder_statuses` (`id`, `name`, `description`, `notify_by_email`, `notify_by_sms`, `color`, `sort_order`, `last_modified`) VALUES
(1, 'lang:work_orders_new', NULL, 0, 0, '#4594cc', 10, '2020-07-09 05:32:32'),
(2, 'lang:work_orders_in_progress', NULL, 0, 0, '#28a745', 20, '2020-07-09 05:32:47'),
(3, 'lang:work_orders_out_for_repair', NULL, 0, 0, '#f7ac08', 30, '2020-07-09 05:32:54'),
(4, 'lang:work_orders_waiting_on_customer', NULL, 0, 0, '#6a0dad', 40, '2020-07-09 05:33:01'),
(5, 'lang:work_orders_repaired', NULL, 0, 0, '#006400', 50, '2020-07-09 05:33:09'),
(6, 'Complete', '', 1, 0, '#831010', 60, '2023-12-19 11:28:37'),
(7, 'lang:work_orders_cancelled', NULL, 0, 0, '#fb5d5d', 70, '2020-07-09 05:33:34');


ALTER TABLE `phppos_workorder_statuses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phppos_workorder_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;



  CREATE TABLE `phppos_sales_work_orders` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sale_id` INT(10) NOT NULL,
	`status` INT(11) NULL DEFAULT '1',
	`employee_id` int(11) DEFAULT NULL,
	`estimated_repair_date` TIMESTAMP NULL DEFAULT NULL,
	`estimated_parts` DECIMAL(23,10) DEFAULT NULL,
	`estimated_labor` DECIMAL(23,10) DEFAULT NULL,
	`warranty` TINYINT(1) DEFAULT NULL,
	`custom_field_1_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_2_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_3_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_4_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_5_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_6_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_7_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_8_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_9_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field_10_value` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

   `comment` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `pre_auth_signature_file_id` int(11) DEFAULT NULL,
  `post_auth_signature_file_id` int(11) DEFAULT NULL,


	`deleted` INT(1) DEFAULT '0',
  
	  PRIMARY KEY (`id`),
	  KEY `custom_field_1_value` (`custom_field_1_value`),
	  KEY `custom_field_2_value` (`custom_field_2_value`),
	  KEY `custom_field_3_value` (`custom_field_3_value`),
	  KEY `custom_field_4_value` (`custom_field_4_value`),
	  KEY `custom_field_5_value` (`custom_field_5_value`),
	  KEY `custom_field_6_value` (`custom_field_6_value`),
	  KEY `custom_field_7_value` (`custom_field_7_value`),
	  KEY `custom_field_8_value` (`custom_field_8_value`),
	  KEY `custom_field_9_value` (`custom_field_9_value`),
	  KEY `custom_field_10_value` (`custom_field_10_value`),
	CONSTRAINT `phppos_sales_work_orders_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `phppos_sales` (`sale_id`),
	CONSTRAINT `phppos_sales_work_orders_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `phppos_employees` (`person_id`),
	CONSTRAINT `phppos_sales_work_orders_ibfk_3` FOREIGN KEY (`status`) REFERENCES `phppos_workorder_statuses` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;





  



ALTER TABLE `phppos_item_variations` ADD `ecommerce_inventory_item_id` VARCHAR(255) NULL AFTER `is_ecommerce`, ADD `supplier_id` INT(11) NULL AFTER `ecommerce_inventory_item_id`;

CREATE TABLE `phppos_location_ban_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_location_ban_items`
  ADD PRIMARY KEY (`id`);


  CREATE TABLE `phppos_item_kits_secondary_categories` (
  `id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_item_kits_secondary_categories`
  ADD PRIMARY KEY (`id`); 

  ALTER TABLE `phppos_item_kits_secondary_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


  ALTER TABLE `phppos_location_ban_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;




  ALTER TABLE `phppos_sales_items`
  ADD COLUMN `receipt_line_sort_order` INT(11) DEFAULT NULL,
  ADD COLUMN `supplier_id` INT(11) DEFAULT NULL,
  ADD COLUMN `approved_by` INT(10) DEFAULT NULL,
  ADD COLUMN `assigned_to` INT(10) DEFAULT NULL,
  ADD COLUMN `is_repair_item` INT(11) DEFAULT NULL,
  ADD COLUMN `is_prepared` TINYINT(4) DEFAULT NULL,
  ADD COLUMN `warranty` INT(11) DEFAULT NULL,
  ADD COLUMN `original_sale_id` INT(11) DEFAULT NULL,
  ADD COLUMN `original_sale_time` TIMESTAMP NULL DEFAULT NULL,
  ADD COLUMN `assigned_repair_item` INT(11) DEFAULT NULL;

ALTER TABLE `phppos_sales_item_kits`
  ADD COLUMN `receipt_line_sort_order` INT(11) DEFAULT NULL,
  ADD COLUMN `supplier_id` INT(11) DEFAULT NULL,
  ADD COLUMN `approved_by` INT(10) DEFAULT NULL,
  ADD COLUMN `assigned_to` INT(10) DEFAULT NULL,
  ADD COLUMN `is_repair_item` INT(11) DEFAULT 0,
  ADD COLUMN `warranty` INT(11) DEFAULT NULL,
  ADD COLUMN `assigned_repair_item` INT(11) DEFAULT NULL;



  CREATE TABLE `phppos_items_secondary_categories` (
  `id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `phppos_items_secondary_categories`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `phppos_items_secondary_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;





ALTER TABLE `phppos_registers` ADD `enable_tips` INT(1) NOT NULL DEFAULT '0' AFTER `emv_pinpad_port`, ADD `categories` VARCHAR(256) NULL AFTER `enable_tips`, ADD `receipt_type` INT(11) NOT NULL DEFAULT '1' AFTER `categories`, ADD `hide_categories` TINYINT(4) NOT NULL DEFAULT '0' AFTER `receipt_type`, ADD `hide_search_bar` TINYINT(4) NOT NULL DEFAULT '0' AFTER `hide_categories`, ADD `hide_top_buttons` TINYINT(4) NOT NULL DEFAULT '0' AFTER `hide_search_bar`, ADD `hide_top_item_details` TINYINT(4) NOT NULL DEFAULT '0' AFTER `hide_top_buttons`, ADD `hide_top_category_navigation` TINYINT(4) NOT NULL DEFAULT '0' AFTER `hide_top_item_details`;





ALTER TABLE `phppos_app_config` ADD `location_id` INT(11) NOT NULL DEFAULT '1' AFTER `value`;

ALTER TABLE `phppos_app_config` ADD `id` INT(11) NOT NULL FIRST;



ALTER TABLE phppos_app_config DROP PRIMARY KEY, MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (id);

INSERT INTO phppos_app_config (`key`, `value`, `location_id`)
SELECT c.`key`, c.`value`, l.location_id
FROM phppos_locations l
JOIN (
    SELECT `key`, `value`
    FROM phppos_app_config
    WHERE location_id = 1
) c
WHERE NOT EXISTS (
    SELECT 1
    FROM phppos_app_config x
    WHERE x.location_id = l.location_id
    LIMIT 1
)
AND l.location_id != 1


INSERT INTO phppos_sale_types (`name`, `sort`, `system_sale_type`, `remove_quantity`, `location`)
SELECT 
    s.name, 
    s.sort, 
    s.system_sale_type, 
    s.remove_quantity, 
    l.location_id
FROM phppos_locations l
JOIN phppos_sale_types s ON s.location = 1
WHERE NOT EXISTS (
    SELECT 1 
    FROM phppos_sale_types st 
    WHERE st.location = l.location_id
    LIMIT 1
)
AND l.location_id != 1;






 INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES
 ('list', 'sales', 'sales_list', 0),
 ('list', 'receivings', 'receiving_list', 0);

ALTER TABLE `phppos_sale_types` ADD `remove_quantity` INT(1) NOT NULL DEFAULT '0' AFTER `system_sale_type`;


ALTER TABLE `phppos_sale_types` ADD `location` INT(11) NOT NULL DEFAULT '1' AFTER `remove_quantity`;






CREATE TABLE `phppos_location_ban_item_kits` (
  `id` int(11) NOT NULL,
  `item_kit_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `phppos_location_ban_item_kits`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phppos_location_ban_item_kits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;





CREATE TABLE `phppos_items_secondary_suppliers` (
  `id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `cost_price` decimal(23,10) DEFAULT NULL,
  `unit_price` decimal(23,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



ALTER TABLE `phppos_items_secondary_suppliers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phppos_items_secondary_suppliers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;




CREATE TABLE `phppos_workorder_checkboxes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `group_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `phppos_workorder_checkboxes_states` (
  `checkbox_id` int(10) NOT NULL,
  `workorder_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;





CREATE TABLE `phppos_workorder_checkbox_groups` (
  `id` int(10) NOT NULL,
  `sort_order` int(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE `phppos_work_orders_email_templates` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_work_order_files` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_id` int(11) NOT NULL,
  `work_order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE `phppos_work_order_log` (
  `id` int(10) NOT NULL,
  `work_order_id` int(10) NOT NULL,
  `activity_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_id` int(10) NOT NULL,
  `activity_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `phppos_workorder_checkboxes`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `phppos_workorder_checkbox_groups`
  ADD PRIMARY KEY (`id`);


  ALTER TABLE `phppos_work_orders_email_templates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `phppos_work_order_files`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `phppos_work_order_log`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `phppos_workorder_checkboxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `phppos_workorder_checkbox_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `phppos_work_orders_email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `phppos_work_order_files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `phppos_work_order_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;






INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES
('module_work_orders', 'module_work_orders_desc', 71, 'ion-hammer', 'work_orders');

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) (SELECT 'work_orders', person_id FROM phppos_permissions WHERE module_id = 'sales');




INSERT INTO phppos_modules_actions (action_id, module_id, action_name_key, sort) VALUES ('see_all_items', 'items', 'common_see_all_items', 504);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'items' and
action_id = 'see_all_items'
order by module_id, person_id;

INSERT INTO phppos_modules_actions (action_id, module_id, action_name_key, sort) VALUES ('see_all_item_kits', 'item_kits', 'common_see_all_item_kits', 505);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'item_kits' and
action_id = 'see_all_item_kits'
order by module_id, person_id;





INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit', 'work_orders', 'work_orders_edit', 240);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'work_orders' and
action_id = 'edit'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('delete', 'work_orders', 'work_orders_delete', 241);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'work_orders' and
action_id = 'delete'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('search', 'work_orders', 'work_orders_search', 242);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'work_orders' and
action_id = 'search'
order by module_id, person_id;


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('manage_statuses', 'work_orders', 'work_orders_manage_statuses', 243);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'work_orders' and
action_id = 'manage_statuses'
order by module_id, person_id;





INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('complete_sale', 'sales', 'sales_complete_sale', 184);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'sales' and
action_id = 'complete_sale'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('complete_transfer', 'receivings', 'receivings_complete_transfer', 184);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'receivings' and
action_id = 'complete_transfer'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('send_transfer', 'receivings', 'receivings_send_transfer', 185);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'receivings' and
action_id = 'send_transfer'
order by module_id, person_id;


-- can_change_sale_date_permission --
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('change_sale_date', 'sales', 'sales_change_sale_date', 184);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'sales' and
action_id = 'change_sale_date'
order by module_id, person_id;
-- manage_delivery_statuses_permission --
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('manage_statuses', 'deliveries', 'deliveries_manage_statuses', 251);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'deliveries' and
action_id = 'manage_statuses'
order by module_id, person_id;

-- can_lookup_last_receipt_permission --
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('can_lookup_last_receipt', 'sales', 'sales_can_lookup_last_receipt', 503);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'sales' and
action_id = 'can_lookup_last_receipt'
order by module_id, person_id;

-- permission_for_delete_suspended_receivings --
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`)     VALUES ('delete_suspended_receiving', 'receivings', 'module_action_delete_suspended_receiving', 181);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
FROM phppos_permissions
INNER JOIN phppos_modules_actions ON phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'receivings' AND
action_id = 'delete_suspended_receiving'
ORDER BY module_id, person_id;


INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'sales' and
action_id = 'view_edit_transaction_history'
order by module_id, person_id;

-- suspended_sales_permission_for_viewing --

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('view_suspended_receipt', 'sales', 'sales_view_suspended_receipt', 503);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'sales' and
action_id = 'view_suspended_receipt'
order by module_id, person_id;


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('view_suspended_receipt', 'receivings', 'receivings_view_suspended_receipt', 503);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'receivings' and
action_id = 'view_suspended_receipt'
order by module_id, person_id;



INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES
('module_invoices', 'module_invoices_desc', 102, 'ti-receipt', 'invoices');

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) (SELECT 'invoices', person_id FROM phppos_permissions WHERE module_id = 'sales');

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('add', 'invoices', 'invoices_add', 240);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'invoices' and
action_id = 'add'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit', 'invoices', 'invoices_edit', 245);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'invoices' and
action_id = 'edit'
order by module_id, person_id;


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('delete', 'invoices', 'invoices_delete', 250);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'invoices' and
action_id = 'delete'
order by module_id, person_id;

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('search', 'invoices', 'invoices_search', 255);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'invoices' and
action_id = 'search'
order by module_id, person_id;


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('view_invoices_reports', 'reports', 'reports_invoices_reports', 265);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'reports' and
action_id = 'view_invoices_reports'
order by module_id, person_id;


INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) 
VALUES ('export_to_sidekick', 'customers', 'customers_export_to_sidekick', 46);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'customers' and
action_id = 'export_to_sidekick'
order by module_id, person_id;



-- permission_to_see_item_quantity --
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('see_item_quantity', 'items', 'items_see_item_quantity', 64);
INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'items' and
action_id = 'see_item_quantity'
order by module_id, person_id;



INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('view_work_order', 'reports', 'reports_work_order', '255');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit_suspended_recevings', 'sales', 'edit_suspended_recevings', '500');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_edit_sn_log_remarks', 'items', 'allow_edit_sn_log_remarks', '277');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('edit_variation', 'sales', 'edit_variation', '444');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('show_cost_price', 'work_orders', 'show_cost_price', '333');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_from', 'receivings', 'allow_detach_from', '4444');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_to', 'receivings', 'allow_detach_to', '4445');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_from_edit', 'receivings', 'allow_detach_from_edit', '4446');
INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('allow_detach_to_edit', 'receivings', 'allow_detach_to_edit', '4447');














ALTER TABLE `phppos_items_serial_numbers` ADD `variation_id` INT(11) NULL AFTER `cost_price`;
ALTER TABLE `phppos_items_serial_numbers` ADD `serial_location_id` INT(11) NOT NULL DEFAULT '0' AFTER `variation_id`;


ALTER TABLE `phppos_items_serial_numbers` ADD `warranty_start` VARCHAR(255)  NULL AFTER `serial_location_id`;
ALTER TABLE `phppos_items_serial_numbers` ADD `warranty_end` VARCHAR(255)  NULL AFTER `warranty_start`;
ALTER TABLE `phppos_items_serial_numbers` ADD `is_sold` TINYINT(4) NOT NULL DEFAULT '0' AFTER `warranty_end`;
ALTER TABLE `phppos_items_serial_numbers` ADD `sold_warranty_start` VARCHAR(256)  NULL AFTER `is_sold`;
ALTER TABLE `phppos_items_serial_numbers` ADD `sold_warranty_end` VARCHAR(256) NULL DEFAULT NULL AFTER `sold_warranty_start`;
ALTER TABLE `phppos_items_serial_numbers` ADD `replace_sale_date` TINYINT(4) NOT NULL DEFAULT '0' AFTER `sold_warranty_end`;


 
CREATE TABLE `phppos_rentals` (
  `rental_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `sale_id` int(11) NOT NULL DEFAULT 0,
  `return_date` varchar(255) NOT NULL,
  PRIMARY KEY (`rental_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `phppos_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `erp_invoice_id` int(11) NOT NULL, -- Links to ERP Invoice ID manually
  `total_amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `mode` varchar(255) DEFAULT NULL,
  `pay_json` longtext DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `phppos_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
 `erp_invoice_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `amount` decimal(10,2) NOT NULL,
  `hash` longtext NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `recurring` int(11) DEFAULT NULL,
  `last_sync` datetime DEFAULT NULL,
  `sync_status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



ALTER TABLE `phppos_invoice` ADD `invoice_json` LONGTEXT NOT NULL AFTER `sync_status`;




  ALTER TABLE `phppos_location_items` ADD `is_inventory` TINYINT NOT NULL DEFAULT '1' AFTER `replenish_level`;



  ALTER TABLE `phppos_location_item_variations` ADD `is_inventory` TINYINT NOT NULL DEFAULT '1' AFTER `cost_price`;


CREATE TABLE `phppos_sync_log` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `last_run` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `phppos_sync_log` (`id`, `last_run`) VALUES (1, '2000-01-01 00:00:00');


INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES ('module_rentals', 'module_rentals_desc', '101', 'icon ti-credit-card', 'rentals');

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('add_update', 'rentals', 'module_action_add_update', '0'), ('deleted', 'rentals', 'module_action_delete', '0'), ('search', 'rentals', 'module_action_search_rentals', '0');

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) VALUES ('rentals', '1');

INSERT INTO `phppos_permissions_actions` (`module_id`, `person_id`, `action_id`) VALUES ('rentals', '1', 'add_update'), ('rentals', '1', 'deleted'), ('rentals', '1', 'search');






ALTER TABLE `phppos_employees` ADD `override_price_adjustments` INT(1) NOT NULL DEFAULT '0' AFTER `template_id`;
ALTER TABLE `phppos_employees` ADD `allowed_ip_address` TEXT NULL DEFAULT NULL AFTER `override_price_adjustments`;
ALTER TABLE `phppos_employees` ADD `secret_key_2fa` VARCHAR(255) NULL DEFAULT NULL AFTER `allowed_ip_address`;
ALTER TABLE `phppos_employees` ADD `is_active` INT(11) NOT NULL AFTER `secret_key_2fa`, ADD `image` VARCHAR(256) NOT NULL AFTER `is_active`, ADD `quick_access` LONGTEXT NOT NULL AFTER `image`;





ALTER TABLE `phppos_locations` ADD `business_type` VARCHAR(255) NOT NULL DEFAULT 'Retail' AFTER `company`;

ALTER TABLE `phppos_locations` ADD `auto_reports_day` VARCHAR(255) NOT NULL DEFAULT 'previous_day';
ALTER TABLE `phppos_locations` ADD `auto_reports_email_day` TEXT NOT NULL AFTER `auto_reports_day`;
ALTER TABLE `phppos_locations` ADD `twilio_sid` VARCHAR(255) NULL AFTER `default_mailchimp_lists`;
ALTER TABLE `phppos_locations` ADD `twilio_token` VARCHAR(255) NULL AFTER `twilio_sid`;
ALTER TABLE `phppos_locations` ADD `twilio_sms_from` VARCHAR(255) NULL AFTER `twilio_token`;
ALTER TABLE `phppos_locations` ADD `auto_reports_email` VARCHAR(255) NOT NULL AFTER `twilio_sms_from`;
ALTER TABLE `phppos_locations` ADD `auto_reports_email_time` TIME NULL AFTER `auto_reports_email`;








ALTER TABLE `phppos_locations` ADD `disable_confirmation_option_for_emv_credit_card` TINYINT(1) NOT NULL DEFAULT '0' AFTER `auto_reports_email_day`;
ALTER TABLE `phppos_locations` ADD `blockchyp_api_key` VARCHAR(255) NULL AFTER `disable_confirmation_option_for_emv_credit_card`;
ALTER TABLE `phppos_locations` ADD `blockchyp_bearer_token` VARCHAR(255) NULL AFTER `blockchyp_api_key`;
ALTER TABLE `phppos_locations` ADD `blockchyp_signing_key` VARCHAR(255) NULL AFTER `blockchyp_bearer_token`;
ALTER TABLE `phppos_locations` ADD `blockchyp_test_mode` VARCHAR(255) NULL AFTER `blockchyp_signing_key`;
ALTER TABLE `phppos_locations` ADD `sidekick_api_key` TEXT NULL AFTER `blockchyp_test_mode`;
ALTER TABLE `phppos_locations` ADD `sidekick_auto_review` TINYINT(1) NOT NULL DEFAULT '0' AFTER `sidekick_api_key`;
ALTER TABLE `phppos_locations` ADD `coreclear_merchant_id` VARCHAR(255) NULL AFTER `sidekick_auto_review`;
ALTER TABLE `phppos_locations` ADD `additional_appointment_note` TEXT NULL AFTER `coreclear_merchant_id`;
ALTER TABLE `phppos_locations` ADD `send_sms_via_whatsapp` TINYINT(1) NOT NULL DEFAULT '0' AFTER `additional_appointment_note`;
ALTER TABLE `phppos_locations` ADD `blockchyp_terms_and_conditions` TEXT NULL AFTER `send_sms_via_whatsapp`;
ALTER TABLE `phppos_locations` ADD `blockchyp_work_order_pre_auth` TEXT NULL AFTER `blockchyp_terms_and_conditions`;
ALTER TABLE `phppos_locations` ADD `blockchyp_work_order_post_auth` TEXT NULL AFTER `blockchyp_work_order_pre_auth`;
ALTER TABLE `phppos_locations` ADD `blockchyp_prompt_for_loyalty` TINYINT(1) NOT NULL DEFAULT '0' AFTER `blockchyp_work_order_post_auth`;
ALTER TABLE `phppos_locations` ADD `blockchyp_prompt_for_name` TINYINT(1) NOT NULL DEFAULT '0' AFTER `blockchyp_prompt_for_loyalty`;
ALTER TABLE `phppos_locations` ADD `blockchyp_prompt_for_email` TINYINT(1) NOT NULL DEFAULT '0' AFTER `blockchyp_prompt_for_name`;
ALTER TABLE `phppos_locations` ADD `blockchyp_prompt_for_phone_number` TINYINT(1) NOT NULL DEFAULT '0' AFTER `blockchyp_prompt_for_email`;
ALTER TABLE `phppos_locations` ADD `blockchyp_ask_for_missing_info` TINYINT(1) NOT NULL DEFAULT '0' AFTER `blockchyp_prompt_for_phone_number`;
ALTER TABLE `phppos_locations` ADD `square_access_token` TEXT NULL AFTER `blockchyp_ask_for_missing_info`;
ALTER TABLE `phppos_locations` ADD `square_refresh_token` TEXT NULL AFTER `square_access_token`;
ALTER TABLE `phppos_locations` ADD `square_access_token_expire` TEXT NULL AFTER `square_refresh_token`;
ALTER TABLE `phppos_locations` ADD `square_merchant_id` TEXT NULL AFTER `square_access_token_expire`;
ALTER TABLE `phppos_locations` ADD `coreclear_mx_merchant_id` VARCHAR(255) NULL AFTER `square_merchant_id`;
ALTER TABLE `phppos_locations` ADD `coreclear_user` VARCHAR(255) NULL AFTER `coreclear_mx_merchant_id`;
ALTER TABLE `phppos_locations` ADD `coreclear_password` VARCHAR(255) NULL AFTER `coreclear_user`;
ALTER TABLE `phppos_locations` ADD `coreclear_consumer_key` TEXT NULL AFTER `coreclear_password`;
ALTER TABLE `phppos_locations` ADD `coreclear_secret_key` TEXT NULL AFTER `coreclear_consumer_key`;
ALTER TABLE `phppos_locations` ADD `coreclear_authorization_key` TEXT NULL AFTER `coreclear_secret_key`;
ALTER TABLE `phppos_locations` ADD `coreclear_sandbox` TINYINT(1) NOT NULL DEFAULT '0' AFTER `coreclear_authorization_key`;
ALTER TABLE `phppos_locations` ADD `coreclear_allow_cards_on_file` TINYINT(1) NOT NULL DEFAULT '0' AFTER `coreclear_sandbox`;
ALTER TABLE `phppos_locations` ADD `coreclear_authorization_key_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `coreclear_allow_cards_on_file`;
ALTER TABLE `phppos_locations` ADD `tax_cap` DECIMAL(23,10) NULL AFTER `coreclear_authorization_key_created`;





ALTER TABLE phppos_sales ADD general_total_tax DECIMAL(23,10) NOT NULL DEFAULT '0.0000000000';


ALTER TABLE `phppos_sales` ADD `return_reason` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ;
ALTER TABLE phppos_sales ADD sale_json LONGTEXT NULL AFTER return_reason;


ALTER TABLE `phppos_sales` ADD `non_taxable` DECIMAL(23, 10) NOT NULL DEFAULT 0.0000000000 AFTER `total_quantity_received`;
ALTER TABLE `phppos_sales` ADD `customer_subscription_id` INT(11) NULL AFTER `non_taxable`;
ALTER TABLE `phppos_sales` ADD `override_tax_class_id` INT(11) NULL AFTER `customer_subscription_id`;
ALTER TABLE `phppos_sales` ADD `is_order` TINYINT(4) NOT NULL DEFAULT '0' ;
ALTER TABLE `phppos_sales` ADD `order_status` VARCHAR(255) NOT NULL DEFAULT 'New' AFTER `is_order`;


ALTER TABLE `phppos_sales` ADD `table_id` INT(11) NOT NULL DEFAULT '0' AFTER `order_status`;
ALTER TABLE `phppos_sales` ADD `delivery_type` ENUM('Dine In','Pickup','Home Delivery') NOT NULL DEFAULT 'Dine In' AFTER `table_id`;
ALTER TABLE `phppos_sales` ADD `time_remaning` VARCHAR(256) NOT NULL AFTER `delivery_type`;
ALTER TABLE `phppos_sales` ADD `is_work_order` TINYINT(4) NOT NULL DEFAULT '0' AFTER `time_remaning`;

ALTER TABLE `phppos_sales` CHANGE `time_remaning` `time_remaning` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;




ALTER TABLE `phppos_sales` ADD `ref_sale_id` INT(11) NULL DEFAULT NULL AFTER `return_sale_id`;
ALTER TABLE `phppos_sales` ADD `ref_sale_desc` TEXT NULL DEFAULT NULL AFTER `ref_sale_id`;
ALTER TABLE `phppos_sales_deliveries` ADD `duration` INT(11) NULL AFTER `deleted`;
ALTER TABLE `phppos_sales_deliveries` ADD `location_id` INT(11) NULL AFTER `duration`;
ALTER TABLE `phppos_sales_deliveries` ADD `delivery_type` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `location_id`;
ALTER TABLE `phppos_sales_deliveries` ADD `category_id` INT(11) NULL AFTER `delivery_type`;
ALTER TABLE `phppos_sales_deliveries` ADD `contact_preference` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `category_id`;
ALTER TABLE `phppos_sales_deliveries` CHANGE `status` `status` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;






CREATE TABLE `phppos_billing` (
  `bill_id` int(11) NOT NULL,
  `meter_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `billing_period_start` date DEFAULT NULL,
  `billing_period_end` date DEFAULT NULL,
  `previous_balance` decimal(10,2) DEFAULT 0.00,
  `current_charges` decimal(10,2) DEFAULT NULL,
  `taxes` decimal(10,2) DEFAULT NULL,
  `total_amount_due` decimal(10,2) DEFAULT NULL,
  `amount_due` decimal(10,2) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_meterreading` (
  `reading_id` int(11) NOT NULL,
  `meter_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `reading_date` datetime DEFAULT current_timestamp(),
  `reading_value` decimal(10,2) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `location_id` int(11) NOT NULL DEFAULT 1,
  `inactive` int(1) NOT NULL DEFAULT 0,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `paid` varchar(255) NOT NULL DEFAULT 'pending',
  `extra_money` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_meterreading_log` (
  `id` int(10) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reading_id` int(11) NOT NULL,
  `transaction_amount` decimal(23,10) NOT NULL,
  `log_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_meters` (
  `meter_id` int(11) NOT NULL,
  `meter_number` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `meter_type` varchar(255) DEFAULT NULL,
  `inactive` int(1) NOT NULL DEFAULT 0,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','under_maintenance') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_meters_log` (
  `id` int(10) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `meter_id` int(11) NOT NULL,
  `transaction_amount` decimal(23,10) NOT NULL,
  `log_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_notifications` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL DEFAULT 0,
  `module` varchar(256) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL,
  `location_from` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_overduecharges` (
  `overdue_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `overdue_date` date DEFAULT NULL,
  `fine_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `phppos_receipts_template` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `template_group` varchar(255) NOT NULL DEFAULT 'Recipts and Invoices',
  `positions` longtext DEFAULT '[{"id":"company_name","newleft":"299.75px","newtop":"-23.5px","newwidth":"0px","newheight":"0px"},{"id":"custom_text","newleft":"82.546875px","newtop":"2084.5px","newwidth":"0px","newheight":"0px"},{"id":"location_name","newleft":"43.75px","newtop":"-12.5px","newwidth":"0px","newheight":"0px"},{"id":"location_address","newleft":"44.546875px","newtop":"13.5px","newwidth":"0px","newheight":"0px"},{"id":"location_phone","newleft":"40.140625px","newtop":"44.5px","newwidth":"0px","newheight":"0px"},{"id":"datetime","newleft":"39.9375px","newtop":"122px","newwidth":"0px","newheight":"0px"},{"id":"saleid","newleft":"300.546875px","newtop":"2px","newwidth":"0px","newheight":"0px"},{"id":"register_name","newleft":"314.546875px","newtop":"238px","newwidth":"0px","newheight":"0px"},{"id":"employee_name","newleft":"319.546875px","newtop":"213.5px","newwidth":"0px","newheight":"0px"},{"id":"customer_name","newleft":"24.140625px","newtop":"208.5px","newwidth":"0px","newheight":"0px"},{"id":"customer_address","newleft":"552.34375px","newtop":"207.5px","newwidth":"0px","newheight":"0px"},{"id":"customer_phone","newleft":"266.9375px","newtop":"28px","newwidth":"0px","newheight":"0px"},{"id":"customer_email","newleft":"39.546875px","newtop":"89px","newwidth":"0px","newheight":"0px"},{"id":"subtotal","newleft":"511.9375px","newtop":"625.5px","newwidth":"0px","newheight":"0px"},{"id":"total","newleft":"545.546875px","newtop":"519px","newwidth":"0px","newheight":"0px"},{"id":"weight","newleft":"491.9375px","newtop":"666px","newwidth":"0px","newheight":"0px"},{"id":"no_of_items","newleft":"504.734375px","newtop":"692px","newwidth":"0px","newheight":"0px"},{"id":"points","newleft":"537.546875px","newtop":"577px","newwidth":"0px","newheight":"0px"},{"id":"amount_due","newleft":"498.34375px","newtop":"549.46875px","newwidth":"0px","newheight":"0px"},{"id":"barcode","newleft":"212.546875px","newtop":"1385.25px","newwidth":"0px","newheight":"0px"},{"id":"border_line","newleft":"0.75px","newtop":"313.1875px","newwidth":"0px","newheight":"0px"},{"id":"border_line2","newleft":"-1.25px","newtop":"200.28125px","newwidth":"0px","newheight":"0px"},{"id":"exchange_name","newleft":"406.140625px","newtop":"769.5px","newwidth":"0px","newheight":"0px"},{"id":"tax_amount","newleft":"463.140625px","newtop":"717px","newwidth":"0px","newheight":"0px"},{"id":"comment_on_receipt","newleft":"154.9375px","newtop":"1567.5px","newwidth":"0px","newheight":"0px"},{"id":"item_returned","newleft":"476.9375px","newtop":"599.5px","newwidth":"0px","newheight":"0px"},{"id":"signature","newleft":"486.734375px","newtop":"1476.5px","newwidth":"0px","newheight":"0px"},{"id":"logo","newleft":"526.34375px","newtop":"71.5px","newwidth":"90.5","newheight":"24"},{"id":"items_list","newleft":"12.75px","newtop":"341.75px","newwidth":"729.5","newheight":"122"}]',
  `checks` longtext NOT NULL DEFAULT '[]',
  `size` varchar(255) NOT NULL DEFAULT 'A4',
  `width` double NOT NULL DEFAULT 0,
  `height` double NOT NULL DEFAULT 0,
  `default_wo` tinyint(4) NOT NULL DEFAULT 0,
  `default_pos` tinyint(4) NOT NULL DEFAULT 0,
  `default_public` tinyint(4) NOT NULL DEFAULT 0,
  `default_estimate` tinyint(4) NOT NULL DEFAULT 0,
  `background_image` int(11) NOT NULL DEFAULT 0,
  `logo_image` int(11) NOT NULL DEFAULT 0,
  `custom_text` longtext NOT NULL,
  `header_percentage` varchar(255) NOT NULL DEFAULT '20%',
  `body_percentage` varchar(255) NOT NULL DEFAULT '60%',
  `footer_percentage` varchar(255) NOT NULL DEFAULT '20%',
  `first_page_items` int(11) NOT NULL DEFAULT 1,
  `other_page_items` int(11) NOT NULL DEFAULT 1,
  `table_image_position` varchar(255) NOT NULL DEFAULT 'just-content-start',
  `table_image_size` int(255) NOT NULL DEFAULT 50,
  `table_element_order` text NOT NULL DEFAULT '[{&quot;id&quot;:&quot;checkbox_item_name&quot;,&quot;order&quot;:1},{&quot;id&quot;:&quot;checkbox_item_price&quot;,&quot;order&quot;:2},{&quot;id&quot;:&quot;checkbox_item_quantity&quot;,&quot;order&quot;:3},{&quot;id&quot;:&quot;checkbox_item_total&quot;,&quot;order&quot;:4}]',
  `tbl_all_borders` tinyint(4) NOT NULL DEFAULT 0,
  `tbl_horzontal_borders` tinyint(4) NOT NULL DEFAULT 0,
  `tbl_vertical_borders` tinyint(4) NOT NULL DEFAULT 0,
  `tbl_header_bg` tinyint(4) NOT NULL DEFAULT 0,
  `number_of_page` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `phppos_receipts_template_label` (
  `id` int(11) NOT NULL,
  `receipts_template_id` int(11) NOT NULL,
  `label_name` varchar(255) NOT NULL,
  `label_text` varchar(255) NOT NULL,
  `exect_value` varchar(255) NOT NULL,
  `is_general` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_removed_items_log` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_reserved` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `status` enum('Reserved','Checked-in') NOT NULL DEFAULT 'Reserved',
  `from_new_time` datetime NOT NULL DEFAULT current_timestamp(),
  `to_new_time` datetime NOT NULL DEFAULT current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `phppos_service_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `phppos_sn_log` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sn_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `Remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `phppos_tables` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ptop` varchar(255) NOT NULL,
  `pleft` varchar(255) NOT NULL,
  `rotate` varchar(255) NOT NULL,
  `no_of_chairs` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `xx_cities` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;






CREATE TABLE `phppos_charis` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `phppos_credit_card_transactions_unconfirmed` (
  `id` int(11) NOT NULL,
  `time_of_charge` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id_of_charge` int(11) DEFAULT NULL,
  `transaction_charge_id` varchar(255) NOT NULL,
  `amount` decimal(23,10) DEFAULT NULL,
  `cart_data` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_customers_zatca` (
  `customer_id` int(10) NOT NULL,
  `buyer_party_postal_street_name` varchar(100) NOT NULL,
  `buyer_party_postal_building_number` varchar(100) NOT NULL,
  `buyer_party_postal_code` varchar(100) NOT NULL,
  `buyer_party_postal_city` varchar(100) NOT NULL,
  `buyer_party_postal_district` varchar(100) NOT NULL,
  `buyer_party_postal_plot_id` varchar(100) NOT NULL,
  `buyer_party_postal_country` varchar(10) NOT NULL,
  `buyer_id` varchar(100) NOT NULL,
  `buyer_scheme_id` varchar(10) NOT NULL,
  `buyer_tax_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_customer_invoices` (
  `invoice_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_po` varchar(255) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `total` decimal(23,10) DEFAULT NULL,
  `balance` decimal(23,10) DEFAULT NULL,
  `last_paid` date DEFAULT NULL,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_customer_invoices` CHANGE `invoice_id` `invoice_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`invoice_id`);

CREATE TABLE `phppos_customer_invoice_details` (
  `invoice_details_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `line_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total` decimal(23,10) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(11,0) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_customer_invoice_payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_type` varchar(255) NOT NULL,
  `payment_amount` decimal(23,10) NOT NULL,
  `auth_code` varchar(255) DEFAULT '',
  `ref_no` varchar(255) DEFAULT '',
  `cc_token` varchar(255) DEFAULT '',
  `acq_ref_data` varchar(255) DEFAULT '',
  `process_data` varchar(255) DEFAULT '',
  `entry_method` varchar(255) DEFAULT '',
  `aid` varchar(255) DEFAULT '',
  `tvr` varchar(255) DEFAULT '',
  `iad` varchar(255) DEFAULT '',
  `tsi` varchar(255) DEFAULT '',
  `arc` varchar(255) DEFAULT '',
  `cvm` varchar(255) DEFAULT '',
  `tran_type` varchar(255) DEFAULT '',
  `application_label` varchar(255) DEFAULT '',
  `truncated_card` varchar(255) DEFAULT '',
  `card_issuer` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_customer_subscriptions` (
  `id` int(10) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `location_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `variation_id` int(10) DEFAULT NULL,
  `startup_cost` decimal(23,10) DEFAULT 0.0000000000,
  `recurring_charge_amount` decimal(23,10) DEFAULT 0.0000000000,
  `customer_id` int(10) NOT NULL,
  `status` varchar(255) NOT NULL,
  `interval` varchar(255) DEFAULT NULL,
  `weekday` int(1) DEFAULT NULL,
  `day_number` int(10) DEFAULT NULL,
  `month` int(10) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `next_payment_date` date DEFAULT NULL,
  `next_retry_date` date DEFAULT NULL,
  `retries_attempted` int(10) DEFAULT 0,
  `card_on_file_token` varchar(255) DEFAULT NULL,
  `card_on_file_masked` varchar(255) DEFAULT NULL,
  `card_on_file_expiration_date` date DEFAULT NULL,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_customer_subscriptions` CHANGE `id` `id` INT(10) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_delivery_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_delivery_categories` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


CREATE TABLE `phppos_delivery_email_templates` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_delivery_email_templates` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_delivery_files` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `phppos_delivery_files` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


CREATE TABLE `phppos_delivery_items` (
  `delivery_items_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_variation_id` int(11) DEFAULT NULL,
  `quantity` decimal(23,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `phppos_delivery_items` CHANGE `delivery_items_id` `delivery_items_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`delivery_items_id`);


CREATE TABLE `phppos_delivery_item_kits` (
  `delivery_item_kits_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `item_kit_id` int(11) DEFAULT NULL,
  `quantity` decimal(23,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_delivery_item_kits` CHANGE `delivery_item_kits_id` `delivery_item_kits_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`delivery_item_kits_id`);

CREATE TABLE `phppos_delivery_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `color` text DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notify_by_email` int(1) DEFAULT 0,
  `notify_by_sms` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_delivery_statuses` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_expenses_categories` (
  `id` int(11) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` int(1) NOT NULL DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `phppos_expenses_categories` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


CREATE TABLE `phppos_expenses_files` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `expense_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_expenses_files` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_floor` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `phppos_floor` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_industries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `phppos_industries` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_open_suspended_sales` (
  `sale_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  `expires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_processing_return_logs` (
  `id` int(11) NOT NULL,
  `return_time` timestamp NULL DEFAULT current_timestamp(),
  `employee_id` int(10) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `orig_voided_processor_transaction_id` varchar(255) NOT NULL,
  `voided_processor_transaction_id` varchar(255) NOT NULL,
  `amount` decimal(23,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_sales_items_notes` (
note_id int(11) NOT NULL AUTO_INCREMENT,
note_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
sale_id int(10) NOT NULL,
item_id int(10) NOT NULL,
line int(10) NOT NULL DEFAULT '0',
item_variation_id int(10) DEFAULT NULL,
note varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
detailed_notes text COLLATE utf8_unicode_ci,
internal tinyint(10) DEFAULT NULL,
employee_id int(10) NOT NULL,
images text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
PRIMARY KEY (note_id),
KEY phppos_sales_items_notes_ibfk_1 (sale_id),
KEY phppos_sales_items_notes_ibfk_2 (item_id),
KEY phppos_sales_items_notes_ibfk_3 (employee_id),
CONSTRAINT phppos_sales_items_notes_ibfk_1 FOREIGN KEY (sale_id) REFERENCES phppos_sales (sale_id),
CONSTRAINT phppos_sales_items_notes_ibfk_2 FOREIGN KEY (item_id) REFERENCES phppos_items (item_id),
CONSTRAINT phppos_sales_items_notes_ibfk_3 FOREIGN KEY (employee_id) REFERENCES phppos_employees (person_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_supplier_invoices` (
  `invoice_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier_po` varchar(255) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `total` decimal(23,10) DEFAULT NULL,
  `balance` decimal(23,10) DEFAULT NULL,
  `last_paid` date DEFAULT NULL,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_supplier_invoices` CHANGE `invoice_id` `invoice_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`invoice_id`);

CREATE TABLE `phppos_supplier_invoice_details` (
  `invoice_details_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
   `sale_id` int(11) NOT NULL,
  `line_id` int(11) DEFAULT NULL,
  `receiving_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total` decimal(23,10) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(11,0) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_supplier_invoice_details` CHANGE `invoice_details_id` `invoice_details_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`invoice_details_id`);

CREATE TABLE `phppos_supplier_invoice_payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_type` varchar(255) NOT NULL,
  `payment_amount` decimal(23,10) NOT NULL,
  `auth_code` varchar(255) DEFAULT '',
  `ref_no` varchar(255) DEFAULT '',
  `cc_token` varchar(255) DEFAULT '',
  `acq_ref_data` varchar(255) DEFAULT '',
  `process_data` varchar(255) DEFAULT '',
  `entry_method` varchar(255) DEFAULT '',
  `aid` varchar(255) DEFAULT '',
  `tvr` varchar(255) DEFAULT '',
  `iad` varchar(255) DEFAULT '',
  `tsi` varchar(255) DEFAULT '',
  `arc` varchar(255) DEFAULT '',
  `cvm` varchar(255) DEFAULT '',
  `tran_type` varchar(255) DEFAULT '',
  `application_label` varchar(255) DEFAULT '',
  `truncated_card` varchar(255) DEFAULT '',
  `card_issuer` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_terms` (
  `term_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `days_due` int(11) DEFAULT 30,
  `deleted` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_terms` CHANGE `term_id` `term_id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`term_id`);

CREATE TABLE `phppos_zatca_config` (
  `location_id` int(10) NOT NULL,
  `csr_common_name` text NOT NULL,
  `csr_serial_number` text NOT NULL,
  `csr_organization_identifier` text NOT NULL,
  `csr_organization_unit_name` text NOT NULL,
  `csr_organization_name` text NOT NULL,
  `csr_country_name` text NOT NULL,
  `csr_invoice_type` text NOT NULL,
  `csr_location_address` text NOT NULL,
  `csr_industry_business_category` text NOT NULL,
  `seller_party_postal_street_name` varchar(100) NOT NULL,
  `seller_party_postal_building_number` varchar(100) NOT NULL,
  `seller_party_postal_code` varchar(100) NOT NULL,
  `seller_party_postal_city` varchar(100) NOT NULL,
  `seller_party_postal_district` varchar(100) NOT NULL,
  `seller_party_postal_plot_id` varchar(100) NOT NULL,
  `seller_party_postal_country` varchar(10) NOT NULL,
  `seller_id` varchar(100) NOT NULL,
  `seller_scheme_id` varchar(10) NOT NULL,
  `seller_tax_id` varchar(100) NOT NULL,
  `csr` text NOT NULL,
  `csr_private_key` text NOT NULL,
  `private_key` text NOT NULL,
  `cert` text NOT NULL,
  `compliance_csid` text NOT NULL,
  `production_csid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_zatca_invoices` (
  `invoice_id` int(10) NOT NULL,
  `location_id` int(11) NOT NULL,
  `sale_id` int(10) NOT NULL,
  `PIH` text NOT NULL,
  `hash` text NOT NULL,
  `qr_code` text NOT NULL,
  `invoice_data` text NOT NULL,
  `invoice_type_code` varchar(20) NOT NULL,
  `invoice_subtype` varchar(20) NOT NULL,
  `invoice_xml` text NOT NULL,
  `invoice_xml_sign` text DEFAULT NULL,
  `validate` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_request` text NOT NULL,
  `clearance_response` text NOT NULL,
  `reporting_response` text NOT NULL,
  `reported` tinyint(4) NOT NULL,
  `check_compliance` tinyint(4) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `phppos_location_ban_tags` (
  `id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_location_ban_tags` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


CREATE TABLE `phppos_people_name_prefixes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `phppos_people_name_prefixes` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `phppos_price_rules_tiers_exclude` (
  `price_rule_id` int(10) NOT NULL,
  `tier_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




UPDATE `phppos_migrations` 
SET `version` = '20240905145977';





ALTER TABLE `phppos_app_files` ADD `gallery` TINYINT(4) NOT NULL DEFAULT '0' AFTER `expires`;
ALTER TABLE `phppos_customers` ADD `always_sms_receipt` INT(1) NOT NULL DEFAULT '0' AFTER `auto_email_receipt`;
ALTER TABLE `phppos_customers` ADD `default_term_id` INT(11) NULL DEFAULT NULL AFTER `always_sms_receipt`;

ALTER TABLE `phppos_damaged_items_log` ADD `damaged_reason_comment` VARCHAR(255) NULL DEFAULT NULL AFTER `damaged_reason`;
ALTER TABLE `phppos_expenses` ADD `expense_image_id` INT(11) NULL DEFAULT NULL AFTER `expense_payment_type`;
ALTER TABLE `phppos_items_quantity_units` ADD `default_for_sale` INT(1) NULL DEFAULT '0' AFTER `quantity_unit_item_number`;
ALTER TABLE `phppos_items_quantity_units` ADD `default_for_recv` INT(1) NOT NULL DEFAULT '0' AFTER `default_for_sale`;





ALTER TABLE `phppos_messages` ADD `receiver_id` INT(11) NOT NULL AFTER `sender_id`;
ALTER TABLE `phppos_messages` ADD `time` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `deleted`;
ALTER TABLE `phppos_messages` ADD `seen` TINYINT(4) NOT NULL DEFAULT '0' AFTER `time`;

ALTER TABLE `phppos_people` ADD `title` VARCHAR(255) NULL DEFAULT NULL AFTER `last_modified`;

ALTER TABLE `phppos_price_rules` ADD `days_of_week` VARCHAR(255) NULL DEFAULT NULL AFTER `disable_loyalty_for_rule`;
ALTER TABLE `phppos_receivings` ADD `exchange_rate` DECIMAL(23, 10) NOT NULL DEFAULT 1.0000000000 AFTER `receiving_time`;

ALTER TABLE `phppos_receivings` ADD `exchange_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_rate`;

ALTER TABLE `phppos_receivings` ADD `exchange_currency_symbol` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_name`;
ALTER TABLE `phppos_receivings` ADD `exchange_currency_symbol_location` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_currency_symbol`;
ALTER TABLE `phppos_receivings` ADD `exchange_number_of_decimals` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_currency_symbol_location`;
ALTER TABLE `phppos_receivings` ADD `exchange_thousands_separator` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_number_of_decimals`;
ALTER TABLE `phppos_receivings` ADD `exchange_decimal_point` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `exchange_thousands_separator`;
ALTER TABLE `phppos_receivings_items` ADD `supplier_id` INT(11) NULL DEFAULT NULL AFTER `items_quantity_units_id`;
ALTER TABLE `phppos_receivings_items` ADD `receipt_line_sort_order` INT(11) NULL DEFAULT NULL AFTER `supplier_id`;

ALTER TABLE `phppos_suppliers` ADD `internal_notes` TEXT NULL DEFAULT NULL AFTER `custom_field_10_value`;
ALTER TABLE `phppos_suppliers` ADD `default_term_id` INT(11) NULL DEFAULT NULL AFTER `internal_notes`;





ALTER TABLE `phppos_sales_deliveries` DROP INDEX `phppos_sales_deliveries_ibfk_1`;




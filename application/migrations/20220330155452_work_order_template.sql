-- work_order_template --
CREATE TABLE `phppos_work_orders_email_templates`(
	`id` int(11) NOT NULL  auto_increment , 
	`status_id` int(11) NOT NULL  , 
	`content` longtext COLLATE utf8_unicode_ci NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
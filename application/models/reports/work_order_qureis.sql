SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id ,  swo.status



// all time all location all status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name)   FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 GROUP by sales.employee_id



// this MONTH all location all status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id 

// this MONTH all location complete status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and swo.status= 6 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id 


// this MONTH all location new status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and swo.status= 1 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id 


// this MONTH all location inprogress status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and swo.status= 2 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id 


// this MONTH all location repaired status worker orders per employee_id

SELECT count(sales.sale_id) as total , CONCAT(pep.first_name ," ", pep.last_name) , swo.status  FROM `phppos_sales` as sales left join phppos_employees as emp on emp.id=sales.employee_id left join phppos_people as pep on pep.person_id = emp.person_id LEFT JOIN phppos_sales_work_orders as swo on swo.sale_id = sales.sale_id WHERE sales.is_work_order=1 and swo.status= 5 and  MONTH(sales.sale_time) = MONTH(CURDATE()) AND YEAR(sales.sale_time) = YEAR(CURDATE()) GROUP by sales.employee_id 
CREATE TABLE phppos_MeterData (
    meter_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,  -- Assuming you have a Customers table
    address VARCHAR(255),
    installation_date DATE,
    meter_type VARCHAR(255),
    status ENUM('active', 'inactive', 'under_maintenance')
);

CREATE TABLE phppos_MeterReadings (
    reading_id INT AUTO_INCREMENT PRIMARY KEY,
    meter_id INT,
    reading_date DATE,
    reading_value DECIMAL(10, 2),
    employee_id INT,
    comments TEXT
    );

CREATE TABLE phppos_Billing (
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
    due_date DATE 
);





CREATE TABLE phppos_OverdueCharges (
    overdue_id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id INT,
    customer_id INT, 
    payment_id INT,  -- To link the overdue charge with a specific payment
    overdue_date DATE,
    fine_amount DECIMAL(10, 2)
);
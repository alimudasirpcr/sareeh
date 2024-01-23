<?php

class ElectricityBillingModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Function to get data based on meter ID
    public function getDataByMeterId($meterId) {
        $meterData = $this->db->get_where('MeterData', array('meter_id' => $meterId))->row_array();

        $readings = $this->db->get_where('MeterReadings', array('meter_id' => $meterId))->result_array();

        $billing = $this->db->get_where('Billing', array('meter_id' => $meterId))->result_array();

        return [
            'meterData' => $meterData,
            'readings' => $readings,
            'billing' => $billing
        ];
    }

    // Function to get data based on customer ID
    public function getDataByCustomerId($customerId) {
        $meters = $this->db->get_where('MeterData', array('customer_id' => $customerId))->result_array();

        // Assuming customer_id is also a field in the Billing table
        $billing = $this->db->get_where('Billing', array('customer_id' => $customerId))->result_array();

        // Assuming customer_id is also a field in the OverdueCharges table
        $overdueCharges = $this->db->get_where('OverdueCharges', array('customer_id' => $customerId))->result_array();

        return [
            'meters' => $meters,
            'billing' => $billing,
            'overdueCharges' => $overdueCharges
        ];
    }

    // Function to get data based on employee ID
    public function getDataByEmployeeId($employeeId) {
        $readings = $this->db->get_where('MeterReadings', array('employee_id' => $employeeId))->result_array();

        return [
            'readings' => $readings
        ];
    }
}

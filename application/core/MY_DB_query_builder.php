<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_DB_query_builder extends CI_DB_query_builder {

    public function update($table = '', $set = NULL, $where = NULL, $limit = NULL) {
        log_message('debug', 'Custom update method called.');
        // Call the parent update method
        $result = parent::update($table, $set, $where, $limit);

        // Log the update
        log_db_update($table, $this->last_query());

        return $result;
    }
}
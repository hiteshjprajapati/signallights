<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignalLights_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_last_record() {
        $this->db->select('*');
        $this->db->from('signal_settings');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save_settings($data) {
        return $this->db->insert('signal_settings', $data);
    }
}

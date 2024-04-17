<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignalLights extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('SignalLights_model');
    }

    public function index() {
        $data['last_record'] = $this->SignalLights_model->get_last_record();
        $this->load->view('signal_lights', $data);
    }

    public function save_settings() {
		$data = array(
			'seqa' => $this->input->post('seqa'),
			'seqb' => $this->input->post('seqb'),
			'seqc' => $this->input->post('seqc'),
			'seqd' => $this->input->post('seqd'),
			'green_interval' => $this->input->post('greenInterval'),
			'yellow_interval' => $this->input->post('yellowInterval')
		);
        $result = $this->SignalLights_model->save_settings($data);
        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to save settings.'));
        }
    }
}

<?php

require(APPPATH.'libraries/REST_Controller.php');
// require_once(APPPATH.'helpers/carAttributesObject.php');

class Car extends REST_Controller
{
    private $carAttributes;
	
	public function __construct()
	{	
		parent::__construct();
		$this->load->database();
	}
	
	public function model_post() {
		$c = $this->post('carmodel');
		if (!is_numeric($c) || (is_numeric($c) && intval($c) > 5)) {
			$this->response(array('status' => 'invalid submission '), 400);
		}
		$fbid = $this->session->userdata('fbid');


		$data = array(
			'car' => $c,
            'car_mods' => '111111'
		);
		$this->load->model('User');
		
		if (!$this->User->isPhaseOne($fbid) && (intval($c) > 2)) {
			//not phase1 and choosing phase1 car model. phase1 cars are 3-5
			$this->response(array('status' => 'not phase1 user'), 400);
		}else{
			$this->db->where('fbid', $fbid);
			$this->db->update('users', $data);
			$this->response(array('status' => 'success','car_mods' => '111111'), 200);
		}
	}
	
	public function customize_post() {
		$m = $this->post('mods');
		//check for valid entries
		
		if(!is_numeric($m) || strlen($m) != 6) {
			$this->response(array('status' => 'invalid submission'), 400);
		}
		
		$mods = str_split($m);
		$fbid = $this->session->userdata('fbid');
		$data = array(
			'car_mods' => $m
		);
		$this->db->where('fbid', $fbid);
		$this->db->update('users', $data); 
		
		$this->response(array('status' => 'success'), 200);
	}



}
?>
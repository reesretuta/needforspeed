<?php

require(APPPATH.'libraries/REST_Controller.php');

class Landing extends REST_Controller
{
	
	public function __construct()
	{	
		parent::__construct();
		if ($this->input->post('access_token') == false) {
			$this->response(array('error' => 'No access token'), 400);
		}
	}
	
	public function adduser_post(){
		
		if ($this->input->post('access_token') == false || $this->input->post('opt_communication') == false || $this->input->post('email') == false || $this->input->post('dob') == false)
			$this->response(array('error' => 'No opt-in, dob or email provided'), 400);
		try {
			$this->facebook->setAccessToken($this->input->post('access_token'));
			$this->facebook->setAppSecret(SECRET);
			$user_detail = $this->facebook->api('/me');
		} catch (Exception $e) {
			$this->response(array('error' => $e), 400);
		}
		$user_detail['oldenough'] = 'yes';
		$user_detail['opt_communication'] = $this->input->post('opt_communication');
		$user_detail['sweeps_one'] = $this->input->post('sweeps_one');
		$user_detail['terms'] = $this->input->post('terms');
		$user_detail['email'] = $this->input->post('email');
		$user_detail['dob'] = $this->input->post('dob');
		$user_detail['agree_sweeps'] = $this->input->post('agree_sweeps');
		$user_detail['agree_weekly'] = $this->input->post('agree_weekly');
		$user_detail['referer'] = $this->session->userdata('referer');
		$this->load->model('User');
		if ($this->User->addUser($user_detail)) {
			$this->response(array('status' => 'success'), 200);
		}else{
			// $this->response(array('error' => 'User already added'), 400); //todo
			
			
			// $this->updateuser_post($this->input->post('access_token'), $user_detail);
			
			$user_detail['agree_sweeps'] = $this->input->post('agree_sweeps');
			$user_detail['agree_weekly'] = $this->input->post('agree_weekly');

			$updateresult = $this->User->updateUser($user_detail);
			if ($updateresult != false) {
				$this->response(
				array(
					'status' => 'success',
					'phase' => $updateresult
				), 200);
			}else{
				$this->response(array('error' => 'no users updated'), 400); //todo
			}
			
		}
	}
	
	public function updateuser_post(){
		try {
			$this->facebook->setAccessToken($this->input->post('access_token'));
			$this->facebook->setAppSecret(SECRET);
			$user_detail = $this->facebook->api('/me');
		} catch (Exception $e) {
			$this->response(array('error' => $e), 400);
		}
		
		// $user_detail['id'] already add from FB call
		$user_detail['agree_sweeps'] = $this->input->post('agree_sweeps');
		$user_detail['agree_weekly'] = $this->input->post('agree_weekly');
		
		
		$this->load->model('User');
		$updateresult = $this->User->updateUser($user_detail);
		if ($updateresult != false) {
			$this->response(
			array(
				'status' => 'success',
				'phase' => $updateresult
			), 200);
		}else{
			$this->response(array('error' => 'no users updated'), 400); //todo
		}
	}
	
	
	public function lookupuser_post(){
		try {
			$this->facebook->setAccessToken($this->input->post('access_token'));
			$this->facebook->setAppSecret(SECRET);
			$user_detail = $this->facebook->api('/me');
		} catch (Exception $e) {
			$this->response(array('error' => $e), 400);
		}
		$this->load->model('User');
		$response = $this->User->lookupUser($user_detail['id']);
		$this->response(array('user' => $response), 200);
	}
	
	
	
}
?>
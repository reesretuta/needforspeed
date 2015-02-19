<?php

require(APPPATH.'libraries/REST_Controller.php');


class Nfs extends REST_Controller
{
	
	public function __construct()
	{	
		parent::__construct();
	}
	
	public function initnextweek_post() {
		$this->load->database();
		
		if ($this->post('week') != false) {
			$week = $this->post('week');

			$data = array(
				'active' => 'no'
			);
			$this->db->update('weeks', $data);
			
			$data = array(
				'active' => 'yes'
			);
			$this->db->where('week', $week);
			$this->db->update('weeks', $data);
			return false;
		}
		$result = $this->db->query('select week from weeks where active = "yes"')->result_array();
		$nextweek = $result[0]['week'] + 1;

		$data = array(
			'active' => 'no'
		);
		$this->db->update('weeks', $data);
		
		$data = array(
			'active' => 'yes'
		);
		$this->db->where('week', $nextweek);
		$this->db->update('weeks', $data);

	}

    public function leaderboard_post() {
        if($this->post('week') != false)
            $week = $this->post('week');
        else
            $week = null;

        $this->load->model('Record');
        $leaderboard = $this->Record->getLeaderBoard($week);
        $this->response(array('leaderboard' => $leaderboard), 200);
    }
	

	public function user_get(){
		$fbid = $this->get('fbid');
		$this->load->database();
		$result = $this->db->query('select id from users where fbid = ? limit 1',array($fbid))->result_array();
		if (count($result) > 0) {
			$this->response(array('error' => 'user already added'), 400);
		}else{
			$this->response(array('message' => 'user can be added'), 200);
		}
	}
	
	public function adduser_post(){
		try {
			$this->facebook->setAccessToken($this->session->userdata('access_token'));
			$this->facebook->setAppSecret(SECRET);
			$user_detail = $this->facebook->api('/me');
		} catch (Exception $e) {
			error_log(print_r('adduser_error',true),0);
			$this->response(array('error' => $e), 400);
		}
		$user_detail['age'] = $this->post('age'); //check if user is old enough. if not. cookie/memcache
		$user_detail['opt_communication'] = $this->post('opt_mail');
		$user_detail['sweeptakes_one'] = $this->post('sweeptakes_one');
		$user_detail['terms'] = $this->post('terms');
		$user_detail['referer'] = $this->session->userdata('referer');
		$user_detail['email'] = $this->post('email');
		$this->load->model('User');
		if ($this->User->addUser($user_detail)) {
			$this->response(array('status' => 'user added'), 200);
		}else{
			$this->response(array('status' => 'user already added'), 400);			
		}
	}
	
	
	
}
?>
<?php

require(APPPATH.'libraries/REST_Controller.php');

class Activity extends REST_Controller
{
	
	public $table = 'activity_quizzes';
	
	public function __construct()
	{	
		parent::__construct();
	}
		
	public function texttrivia_post(){
		$aid = $this->post('aid');
		$a1 = $this->post('a1');
		$a2 = $this->post('a2');
		$a3 = $this->post('a3');
		if ($aid == false || $a1 == false || $a2 == false || $a3 == false) {
			$this->response(array('error' => 'missing answer'), 400);
		}
		$this->load->Model('Record');
		$r = $this->Record->submitTextTrivia($aid,$a1,$a2,$a3);
		$this->response($r, 200);
	}
	
	public function phototrivia_post(){
		$aid = $this->post('aid');
		$a = $this->post('a'); //answer
		if ($aid == false || $a == false) {
			$this->response(array('error' => 'missing answer'), 400);
		}
		$this->load->Model('Record');
		$r = $this->Record->submitPhotoTrivia($aid, $a); //second param: fbid
		
		$this->response($r, 200);
	}

		
	public function youtube_post(){
		$aid = $this->post('aid');
		$shareplatform = $this->post('platform');
		if (($aid != false && $shareplatform != false) && ($shareplatform == 'twitter' || $shareplatform == 'facebook' || $shareplatform == 'tumblr')) {
			$this->load->Model('Record');
			$r = $this->Record->submitYoutubeShare($aid, $shareplatform);
			$this->response($r, 200);
		}else{
			$this->response(array('error' => 'invalid platform'), 400);
		}
	}
	
	public function pictureshare_post(){
		$aid = $this->post('aid');
		$shareplatform = $this->post('platform');
		if (($aid != false && $shareplatform != false) && ($shareplatform == 'twitter' || $shareplatform == 'facebook' || $shareplatform == 'tumblr')) {
			$this->load->Model('Record');
			$r = $this->Record->submitPictureShare($aid, $shareplatform);
			$this->response($r, 200);
		}else{
			$this->response(array('error' => 'invalid platform'), 400);
		}
	}
	
	public function linkout_post(){
		$aid = $this->post('aid'); //if sharing is required use pictureshare
		// $shareplatform = $this->post('platform');
		if ($aid != false) {
			$this->load->Model('Record');
			$r = $this->Record->submitLinkout($aid);
			$this->response($r, 200);
		}else{
			$this->response(array('error' => 'invalid platform'), 400);
		}
	}
	
	//function combining all three follow activity_types of fb, twitter, tumblr	
	public function follow_post(){
		$aid = $this->post('aid');
		$activity_type = $this->post('activity_type');
		if ($aid != false || ($activity_type == 'fblike' || $activity_type == 'twitter' || $activity_type == 'tumblr')) {
			$this->load->Model('Record');
			$r = $this->Record->submitFollow($aid,$activity_type); //second param: fbid
			$this->response($r, 200);
		}else{
			$this->response(array('error' => 'missing activity'), 400);
		}
	}
	
	
	public function checkin_post(){
		$physical = $this->post('physical');
		$aid      = $this->post('aid');
		$username = $this->post('username');
		$platform = $this->post('platform');
		
		if (($physical == 'yes') && $username != false && ($platform == 'twitter' || $platform == 'instagram')) {
			$this->load->Model('Record');
			$r = $this->Record->submitCheckin($aid,'yes',$platform, $username);
			$this->response($r, 200);
		}
		
		if ($physical == 'no' && ($platform == 'twitter' || $platform == 'facebook' || $platform == 'tumblr')) {
			$this->load->Model('Record');
			$r = $this->Record->submitCheckin($aid, 'no', $platform);
			$this->response($r, 200);
		}
		
		$this->response(array('error' => 'invalid params passed'), 400);

	}
	
	public function speedbump_post(){
		$aid = $this->post('aid');
		$a = $this->post('a'); //answer
		if ($aid == false || $a == false) {
			$this->response(array('error' => 'missing answer'), 400);
		}
		$this->load->Model('Record');
		$r = $this->Record->submitSpeedbump($aid, $a); //second param: fbid
		$this->response($r, 200);
	}
	

	
	
	public function history_get(){
		$this->load->model('Record');
		$history = $this->Record->getRecentActivity();
		$this->response(array('history' => $history), 200);
	}
	
	
}
?>
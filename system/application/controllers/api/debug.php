<?php

require(APPPATH.'libraries/REST_Controller.php');


class Debug extends REST_Controller
{
	
	public function __construct()
	{	
		parent::__construct();
	}

	
	public function clearcache_post(){
		$this->load->database();
		$this->db->cache_delete_all();
	}
	
	public function setFBID_post($fbid){
		if (ENVIRONMENT == 'production') die('disallowed');
		
		$newdata = array(
			'fbid' => $fbid
		);
		$this->session->set_userdata($newdata);
	}
	
	public function getFBID_get(){
		if (ENVIRONMENT == 'production') die('disallowed');
		$this->response(array('access_token' => $this->session->userdata('fbid')), 200);
	}
	
	public function clearuser_get($fbid){
		if (ENVIRONMENT == 'production') die('disallowed');
		$this->load->database();
		$this->db->delete('records', array('fbid' => $fbid));
		$this->db->delete('leaderboard', array('fbid' => $fbid));
	}
	
	public function removeuser_get($fbid){
		if (ENVIRONMENT == 'production') die('disallowed');
		$this->load->database();
		$this->db->delete('users', array('fbid' => $fbid));
	}
	
	// public function recruithotfix_get(){
	// 
	// 	$this->load->database();
	// 	$this->load->model('Record');
	// 	$fbid = $this->get('fbid');
	// 	
	// 	//"select * from users where fbid > 100000000000000 and referer is not null and referer != 0 and signup_date < '2014-02-09 23:59:59' and referer = '".$fbid."'"
	// 	$result = $this->db->query("select * from users where fbid > 100000000000000 and referer is not null and referer != 0 and signup_date < '2014-02-09 23:59:59'")->result_array();
	// 	//BEN '507051277'
	// 	$this->db->trans_start();
	// 	foreach ($result as $key => $value) {
	// 		$r = $this->Record->submitRecruitFix($value['fbid'], $value['referer']); //$recruit_fbid, $referer_fbid
	// 	}
	// 	$this->db->trans_complete();
	// 	if ($this->db->trans_status() === FALSE)
	// 	{
	// 		echo "<pre>";
	// 		print_r('error');
	// 		echo "</pre>";
	// 	    // generate an error... or use the log_message() function to log your error
	// 	}
	// 	
	// 	
	// }
	
	public function recruithotfixtwo_get(){
	// 100007099590008 john
	// 2529208 rees
	// 100001331479597 Mladen Bulajic. week2 = 57500, needs to be: week2 = 72500
	// 
	// select * from users 
	// left join records on (users.fbid = records.aid)
	// where users.referer != 0 and records.id is null and referer = 100001331479597
	
		//issue: recruit activity ID was not included in weeks_activity.
		//steps to fix:
		//import PROD DB to local/laptop DB
		//include activity back into weeks_activity on staging
		//run this script
		//import DB back to prod
		$this->load->database();
		$this->load->model('Record');
		$fbid = $this->get('fbid');
		
		$result = $this->db->query("select users.* from users 
left join records on (users.fbid = records.aid)
where users.referer != 0 and records.id is null")->result_array();

		$this->db->trans_start();
		foreach ($result as $key => $value) {
			$r = $this->Record->submitRecruitFix($value['fbid'], $value['referer']); //$recruit_fbid, $referer_fbid
			
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			echo "<pre>";
			print_r('error');
			echo "</pre>";
		    // generate an error... or use the log_message() function to log your error
		}
		
		
	}
	
}
?>
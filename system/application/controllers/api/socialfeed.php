<?php

require(APPPATH.'libraries/REST_Controller.php');


class Socialfeed extends REST_Controller
{
	
	public function __construct()
	{	
		parent::__construct();
	}
	
	
	public function instagram_get() {
		$this->load->database();
		$result = $this->db->query('select response from feeds where feed = "instagram"')->result_array();
        $data = $result[0]['response'];
        $data = json_decode($data);
		$this->response(array('instagram' => $data), 200);
	}
	
	public function twitter_get() {
		$this->load->database();
		$result = $this->db->query('select response from feeds where feed = "twitter"')->result_array();
		$tweet = json_decode($result[0]['response']);
		$this->response(array('tweets' => $tweet), 200);
	}
	
	public function composite_get() {

		$this->load->database();
		$twitterResult = $this->db->query('select response from feeds where feed = "twitter"')->result_array();
		$instagramResult = $this->db->query('select response from feeds where feed = "instagram"')->result_array();
		$twitterData = json_decode($twitterResult[0]['response']);
		$instagramData = json_decode($instagramResult[0]['response']);
		$this->response(array('tweets' => $twitterData, 'instagram' => $instagramData), 200);
    }
	
	
}
?>
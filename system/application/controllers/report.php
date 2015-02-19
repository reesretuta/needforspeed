<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
class Report extends CI_controller {
	
	
	public function __construct(){
		parent::__construct();
	}
	
	public function pass($pass = null){

		if ($pass == '15Q183gu0466At421') {
			$this->load->database();
			$result = $this->db->query("select count(fbid) as total from users where phase = 1")->result_array();
			echo "<pre>Phase 1:";
			print_r($result[0]['total']);
			echo "</pre>";
			
			$result = $this->db->query("select count(fbid) as total from users where phase is null")->result_array();
			echo "<pre>Phase 2:";
			print_r($result[0]['total']);
			echo "</pre>";
			
			$result = $this->db->query("select count(fbid) as total from users")->result_array();
			echo "<pre>Total:";
			print_r($result[0]['total']);
			echo "</pre>";
		}else{
			die('incorrect pass');
		}
	}
	
	
	
}
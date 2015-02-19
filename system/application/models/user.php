<?php
class User extends CI_Model {

	public $table = 'users';

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function addUser($user_detail){
		//check if user already exists, if not, write
		$result = $this->db->query('select fbid from users where fbid=? limit 1',$user_detail['id']);
		if ($result->num_rows() > 0)
		{
			//$fbid = $result->result_array();
			//return $fbid = $fbid[0]['fbid'];
			return false;
		}else{
			//store user
			$data = array(
				'fbid'      => $user_detail['id'],
				'firstname' => $user_detail['first_name'],
				'lastname'  => $user_detail['last_name'],
				'email'   => $user_detail['email'],
				'dob'   => $user_detail['dob'],
				'referer'   => $user_detail['referer'],
				'agree_sweeps'   => $user_detail['agree_sweeps'],
				'agree_weekly'   => $user_detail['agree_weekly'],
				'signup_date' => date('Y-m-d H:i:s')
			);
			$this->db->insert($this->table, $data);
			
			if (!empty($user_detail['referer'])) {
				error_log(print_r('NOT EMPTY!',true),0);
				$this->load->model('Record');
				$this->Record->submitRecruit($user_detail['id'], $user_detail['referer']);
			}else{
				error_log(print_r('EMPTY!',true),0);
			}
			
			return true;
		}
	}
	
	function addEntry($fbid){
		$data = array(
			'extra_entry_sweeps_one' => 1
		);
		$this->db->where('fbid', $fbid);
		$this->db->update($this->table, $data); 
	}
	
	function getCrewInfo($fbid){
		$crew = $this->db->query('select fbid, firstname, lastname from users where referer=?',$fbid)->result_array();
		return $crew;
	}
	
	function getUserInfo($fbid){
		$user = $this->db->query('select fbid, firstname, lastname, email, car, car_mods, phase, signup_date from users where fbid=?',$fbid)->result_array();

		if (count($user)>0) {
			// $phase2 = strtotime('2014-01-31 00:00:00');
			// strtotime($user[0]['signup_date']) < $phase2
			//change null to 2
			$user[0]['phase'] = ($user[0]['phase'] == 1 ? 1 : 2);
			
			$this->load->model('Record');
			$leaderboard = $this->Record->getLeaderBoard();
			
			if (isset($leaderboard['rank'])) {
				$user[0]['rank'] = $leaderboard['rank'];
                if (isset($leaderboard['total_weekpoints'])) {
                    $user[0]['total_weekpoints'] = $leaderboard['total_weekpoints'];
                }
				$user[0]['total_count'] = $leaderboard['total_count'];
				$user[0]['points_total'] = $leaderboard['points_total']; //check this works!!!!!!!!!!
			}else{
				$user[0]['rank'] = 0;
				$user[0]['total_weekpoints'] = 0;
				$user[0]['total_count'] = $leaderboard['total_count'];
				$user[0]['points_total'] = 0;//check this works!!!!!!!!!!
			}
			$user[0]['week'] = $leaderboard['week'];
			
			return $user[0];
		}else{
			header('Location: /');
			exit();
			// die('user authorized app but removed from local DB (or claims to be returning but is actually new), remove app from Facebook.com');
		}
	}
	
	function updateUser($user_detail){
		
		$user_detail['agree_sweeps'] = ($user_detail['agree_sweeps'] == 'yes' ? 'yes' : 'no');
		$user_detail['agree_weekly'] = ($user_detail['agree_weekly'] == 'yes' ? 'yes' : 'no');
		$data = array(
			'fbid'      => $user_detail['id'],
			'agree_sweeps' => $user_detail['agree_sweeps'],
			'agree_weekly' => $user_detail['agree_weekly']
		);
		
		$this->db->where('fbid', $user_detail['id']);
		$result = $this->db->update($this->table, $data);
		if ($result) {
			$user = $this->db->query('select phase from users where fbid=?',$user_detail['id'])->result_array();
			
			return ($user[0]['phase'] == null? 2:1); //if null phase2
		}else{
			return false;
		}

	}
	
	function lookupUser($fbid){
		$user = $this->db->query('select firstname, lastname, agree_sweeps, agree_weekly, phase from users where fbid=?',$fbid)->result_array();
		if (count($user) == 1) {
			$user[0]['phase'] = ($user[0]['phase'] == null? 2:1); //if null phase2
			return $user[0];
		}else{
			return false;
		}
	}
	
	
	function isPhaseOne($fbid){
		$user = $this->db->query('select fbid, firstname, lastname, email, signup_date from users where fbid=?',$fbid)->result_array();
		if (count($user)>0) {
			$phase2 = strtotime('2014-02-02');
			if (strtotime($user[0]['signup_date']) < $phase2) {
				return true;
			}else{
				return false;
			}
		}
	}
	
	
	
	
	
	
}
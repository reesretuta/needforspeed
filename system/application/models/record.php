<?php
class Record extends CI_Model {

	public $table = 'records';

    function __construct()
    {
		parent::__construct();
		$this->load->database();
    }
	//to-do... check against trivia ONLY if it is active in the weekly_activity table.... do this.
	function submitTextTrivia($aid,$a1,$a2,$a3){
		$data = array(
		   'activity_type' => 'texttrivia',
		   'aid' => $aid,
		   'answer' => $a1.','.$a2.','.$a3
		);
		
		//correct count added below
		return $this->updateRecords($data);
	}
	
	function submitPhotoTrivia($aid, $a){
		$data = array(
			'activity_type' => 'phototrivia',
			'aid' => $aid,
			'answer' => $a,
		);
		return $this->updateRecords($data);
	}
	
	function submitYoutubeShare($aid,$shareplatform){
		$data = array(
			'activity_type' => 'youtube',
			'aid' => $aid,
			'platform' => $shareplatform
		);
		return $this->updateRecords($data);
	}
	
	function submitPictureShare($aid,$shareplatform){
		$data = array(
			'activity_type' => 'picture',
			'aid' => $aid,
			'platform' => $shareplatform
		);
		return $this->updateRecords($data);
	}
	
	function submitLinkout($aid){
		$data = array(
			'activity_type' => 'link',
			'aid' => $aid
		);
		return $this->updateRecords($data);
	}
	
	function submitFollow($aid,$activity_type){
		$data = array(
			'activity_type' => $activity_type,
			'aid' => $aid
		);
		return $this->updateRecords($data);
	}

	function submitSpeedbump($aid,$a){
		$data = array(
			'activity_type' => 'speedbump',
			'aid' => $aid,
			'answer' => $a
		);
		return $this->updateRecords($data);
	}
	
	function submitRecruit($recruit_fbid, $referer_fbid){
		$data = array(
			'activity_type' => 'recruit',
			'aid' => 1, //exception to allow recruiting over entire campaign
			'recruit_fbid' => $recruit_fbid,
			'referer_fbid' => $referer_fbid
		);
		return $this->updateRecords($data);
	}
	
	function submitRecruitFix($recruit_fbid, $referer_fbid){
		$data = array(
			'activity_type' => 'recruit',
			'aid' => 1, //exception to allow recruiting over entire campaign
			'recruit_fbid' => $recruit_fbid,
			'referer_fbid' => $referer_fbid
		);
		return $this->updateRecords($data, true);
	}
	
	function submitCheckin($aid, $physical = 'yes', $platform, $username = ''){
		$hash = $this->db->query('select checkinhash from activity_checkins, weeks, weeks_activity where weeks.week = weeks_activity.week and weeks.active = "yes" limit 1')->result_array();
		$hash = $hash[0]['checkinhash'];
		if ($physical == 'yes') {
			//check DB if exists allocate points
			$verified = false;
			if ($platform == 'twitter') {
				
				$this->load->library('twitteroauth');
				$consumer = "L9DdhsaH4qEbiqjONrklpw";
				$consumer_secret = "yvmsrMPBVac13mDYs8UFTSqmOiEcGEvQKUC2E8cZG0";
				$access_token = "23135183-zlYk53bzFDWXw1JKsSReXMdSuqzJY7cEg3wNRVMQ4";
				$access_token_secret = "N9jYqXg0VFYeQdDJp08FI67GNlZG9SkTPpl7TbVNdZP1q";
				
				$connection = $this->twitteroauth->create($consumer, $consumer_secret, $access_token, $access_token_secret);

				$content = $connection->get('account/verify_credentials');
				$data = array(
					'q' => '#'.$hash.'&from:'.$username,
				);
				$result = $connection->get('search/tweets', $data);

				if (count($result->statuses) > 0) $verified = true;

			}
			

			if ($platform == 'instagram') {
				
				$this->db->select('igusername');
				$this->db->where('hash', $hash);
				$this->db->where('igusername', $username);
				$result = $this->db->get('instagram_posts')->result_array();
				if (count($result) > 0) $verified = true;
			}

			if ($verified == true) {
				$data = array(
					'activity_type' => 'checkin',
					'aid' => $aid,
					'physical' => 'yes',
					'platform' => $platform
				);
				return $this->updateRecords($data);
			}else{
				return array('post_verified' => false);
			}
			
		}else{
			//VIRTUAL CHECKIN
			$data = array(
				'activity_type' => 'checkin',
				'aid' => $aid,
				'physical' => 'no',
				'platform' => $platform
			);
			return $this->updateRecords($data);
		}

	}
	
	private function updateRecords($data, $hotfix = false){
		//before writting do one last check that the activity being recorded is actually active against the week_activity table and is the right week. will write to whatever week is active. ie. user submits fblike points for week2 when there are no fblikes for week2
		$fbid = $this->session->userdata('fbid');
		$data['fbid'] = $this->session->userdata('fbid');
		
		// do not prevent people bypassing the speedbump... they only hurt themselves
		// if ($this->session->userdata('speedbump_active') && $this->session->userdata('speedbump_answered') != true) {
		// 	return 'user has not answered speed bump';
		// }
		
		$result = $this->db->query('
			select weeks.week from weeks 
			left join weeks_activity on (weeks_activity.week = weeks.week)
			where active="yes" and activity_type = ? and activityid = ?',
			array($data["activity_type"], $data["aid"])
				)->result_array();
		

			if ($hotfix == true) {
				$result[0]['week'] = 2;
			}
		if (count($result) == 0) {
			error_log(print_r('user is trying to post answers to an activity that does not exist this active week',true),0);
			return false; //user is trying to post answers to an activity that does not exist this active week
		}
		
		
		if ($data['activity_type'] == 'recruit') {
			$fbid         = $data['referer_fbid'];
			$data['aid']  = $data['recruit_fbid'];
			$data['fbid'] = $data['referer_fbid'];
			unset($data['referer_fbid']);
			unset($data['recruit_fbid']);
		}
		//add texttrivia correct count before inserting into DB
		if ($data['activity_type'] == 'texttrivia') {
			$this->db->select('answer');
			$this->db->where('id', $data['aid']);
			$texttrivia = $this->db->get('activity_texttrivia')->result_array();
			$correct_count = 0;
			$answer = explode(',',$texttrivia[0]['answer']);
			$useranswer = explode(',',$data['answer']);
			if ($answer[0] == $useranswer[0]) {
				$correct_count++;
			}
			if ($answer[1] == $useranswer[1]) {
				$correct_count++;
			}
			if ($answer[2] == $useranswer[2]) {
				$correct_count++;
			}
			$data['correct_count'] = $correct_count;
		}
		
		if ($data['activity_type'] == 'phototrivia') {
			$this->db->select('answer, img_large');
			$this->db->where('id', $data['aid']);
			$phototrivia = $this->db->get('activity_phototrivia')->result_array();
			if ($data['answer'] == $phototrivia[0]['answer']) {
				$data['correct'] = 'yes';
			}else{
				$data['correct'] = 'no';
			}
			
		}
		
		if ($data['activity_type'] == 'speedbump') {
			$this->db->select('speedbump_answer, correct_response, incorrect_response');
			$this->db->where('id', $data['aid']);
			$speedbump = $this->db->get('activity_speedbumps')->result_array();
			if ($data['answer'] == $speedbump[0]['speedbump_answer']) {
				$data['correct'] = 'yes';
			}else{
				$data['correct'] = 'no';
			}
		}
		

		$data['submit_time'] = date("Y-m-d H:i:s");
		$data['week'] = $result[0]['week'];
		if ($hotfix == true) {
			$data['submit_time'] = $hotfix['recruittime'];
			$data['week'] = 2;
		}
		$this->db->insert('records',$data); //WRITE TO RECORDS TABLE
		
		if ($this->db->affected_rows() == 0) {
			error_log(print_r('USER ALREADY COMPELTED ACTIVITY. NO POINTS TO GIVE. NO UPDATING LEADERBOARD',true),0);
			return false;  //USER ALREADY COMPELTED ACTIVITY. NO POINTS TO GIVE. NO UPDATING LEADERBOARD
		}
		if ($hotfix == true) {
			$this->updateLeaderboard($fbid,$result[0]['week'],$data['submit_time'], true); //WRITE TO LEADERBOARD
		}else{
			$this->updateLeaderboard($fbid,$result[0]['week'],$data['submit_time']); //WRITE TO LEADERBOARD
		}
		
		
		//successful submit below
		//modify general response for text/photo trivia. many variables defined above
		$response = true; //SUCCESS
		switch ($data['activity_type']) {
			case 'texttrivia':
			$response = array(
				'answer' => $answer, //defined above
				'correct_count' => $correct_count,
				'earned' => $correct_count * 2000
			);
			break;
			case 'phototrivia':
			$response = array(
				'answer' => $phototrivia[0]['answer'],
				'img_large' => $phototrivia[0]['img_large'] //check this works!!!!!!!!!!!!
			);
			break;
			case 'speedbump':
			$response = array(
				'answer' => $speedbump[0]['speedbump_answer'],
				'correct' => $data['correct'],
				'correct_response' => $speedbump[0]['correct_response'],
				'incorrect_response' => $speedbump[0]['incorrect_response']
			);
			break;
		}
		return $response;
	}
	
	
	private function updateLeaderboard($fbid,$week,$submit_time, $hotfix = false){
		//for leaderboard summery
		$result = $this->db->query("select records.id, records.activity_type, correct, records.correct_count, pointvalue, week from records left join points on (points.activity_type = records.activity_type) where records.fbid = ?",array($fbid))->result_array();
		$totalpoints = 0;
		$weekpoints = 0;
		
		//grab all activity and calculate new totals
		foreach ($result as $key => $value) {
			if ($value['activity_type'] == 'texttrivia') {
				$pts = $value['correct_count'] * 2000;
				$result[$key]['pointvalue'] = $pts;
			}
			if ($value['activity_type'] == 'phototrivia' && $value['correct'] != 'yes') {
				$result[$key]['pointvalue'] = 0;
			}
			
			if ($value['activity_type'] == 'speedbump' && $value['correct'] != 'yes') {
				$result[$key]['pointvalue'] = 0;
			}
			
			$totalpoints = $totalpoints + $result[$key]['pointvalue'];
			
			if ($value['week'] == $week) {
				//count this active weeks points
				$weekpoints = $weekpoints + $result[$key]['pointvalue'];
			}
		}
		$thisweekcolumn = 'week'.$week;
		$thisstarttimecolumn = 'start_time'.$week;
		$thisupdatetimecolumn = 'last_update'.$week;
		$data = array(
			'fbid' => $fbid,
			$thisweekcolumn => $weekpoints,
			'points_total' => $totalpoints,
			$thisstarttimecolumn => $submit_time,
			$thisupdatetimecolumn => $submit_time
		);

		if ($hotfix == true) {
			$qry = $this->db->insert_string('leaderboard',$data) . ' ON DUPLICATE KEY UPDATE '.$thisweekcolumn.' = '.$weekpoints.', points_total = '.$totalpoints;
		}else{
			$userstartexists = false;
			foreach ($result as $key => $value) {
				if ($value['week'] == $week) {
					//user SHOULD already have a START TIME for this week
					$userstartexists = true;
				}
			}
			if ($userstartexists) {
				$qry = $this->db->insert_string('leaderboard',$data) . ' ON DUPLICATE KEY UPDATE '.$thisweekcolumn.' = '.$weekpoints.', points_total = '.$totalpoints.', '.$thisupdatetimecolumn.' = "' .$submit_time . '"';
			}else{
				$qry = $this->db->insert_string('leaderboard',$data) . ' ON DUPLICATE KEY UPDATE '.$thisweekcolumn.' = '.$weekpoints.', points_total = '.$totalpoints.', '.$thisstarttimecolumn.' = "'.$submit_time.'",'.$thisupdatetimecolumn.' = "' .$submit_time . '"';
			}
		}

		$this->db->query($qry);
		$this->db->cache_delete('api', 'nfs');
		// $this->db->cache_delete_all();
	}
	
	function getLeaderBoard($week = null) {

        $result = $this->db->query('select week from weeks where active = "yes" limit 1')->result_array();

		if ($week == null || intval($week) > intval($result[0]['week'])) {
			$week = $result[0]['week'];
		}

		$fbid = $this->session->userdata('fbid'); //'2529208'; 
		$leaderboard = array();

		// $result = $this->db->query("SELECT fbid, week".$week." as weekpoints, points_total, timestampdiff(MINUTE,leaderboard.start_time".$week.", leaderboard.last_update".$week.") as duration_week from leaderboard order by weekpoints desc, duration_week asc")->result_array();
		// $this->db->cache_on();
		$result = $this->db->query("SELECT leaderboard.fbid, week".$week." as weekpoints, points_total, timestampdiff(MINUTE,leaderboard.start_time".$week.", leaderboard.last_update".$week.") as duration_week, firstname, lastname from leaderboard, users where leaderboard.fbid = users.fbid order by weekpoints desc, duration_week asc")->result_array();
		// $this->db->cache_off();
		//IMPORTANT: ALTERNATE APPROACH, SORT AND ADD WEEKLY AND TOTAL DURATION KEY IN PHP BY LOOPING THROUGH RESULT, INSTEAD OF CALCULATING DURATION IN SQL. WOULD NEED TO LOOP THROUGH RESULT SET
		// SELECT leaderboard.fbid, week4 as weekpoints, points_total, firstname, lastname, email from leaderboard, users where leaderboard.fbid = users.fbid order by weekpoints desc limit 15
		$usercount = count($result);

		
		//REORDER RESULT SET FOR WEEKLY PARSING
		// foreach ($result as $key => $row) {
		// 	$week_points[$key] = $row['weekpoints'];
		// 	$duration[$key] = $row['duration_week'];
		// }
		// array_multisort($week_points, SORT_DESC, $duration, SORT_ASC, $result);
		
		//needed in order to use array_slice();
		for ($i=0; $i < count($result); $i++) {
			$result[$i]['rank'] = $i+1;
		}
		$leaderboard['week'] = $week;
		$leaderboard['total_count'] = count($result);
		$leaderboard['all'] = $result;
		//result is now back to being sorted by week
		for ($i=0; $i < count($result); $i++) { 
			if ($result[$i]['fbid'] == $fbid) {
				$leaderboard['rank'] = $i + 1; //add rank to response. regardless.
				$leaderboard['total_weekpoints'] = $result[$i]['weekpoints'];
				$leaderboard['points_total'] = $result[$i]['points_total']; //check this works!!!!!!!!!!
				if ($i < 6) {
					$leaderboard['personal'] = array_slice($result,0,5);
					break;
				}
				if (($usercount - $i) < 6) {
					$leaderboard['personal'] = array_slice($result, -5); //rank will be included
					break;
				}
				$leaderboard['personal'] = array_slice($result, $i - 2, 5); //rank will be included
				break;
			}
		}
		
		$leaderboard['week_total'] = array_slice($result, 0, 5);

		return $leaderboard;
		// $this->db->cache_on();
		// $result = $this->db->query("SELECT @rownum:=@rownum+1 `rank`, p.fbid, week1 FROM leaderboard p, (SELECT @rownum:=0) as r ORDER BY week1 DESC")->result_array();
		// SELECT fbid, week1, points_total, time_to_sec(timestampdiff(MINUTE, leaderboard.last_update1, leaderboard.start_time1)) as duration from leaderboard
		//SELECT fbid, week1, points_total, timestampdiff(HOUR,leaderboard.last_update1, leaderboard.start_time1) as duration from leaderboard
		// SELECT @rownum:=@rownum+1 `rank`, p.fbid, dob_month
		// FROM users as p, (SELECT @rownum:=0) as r
		// ORDER BY dob_month asc, fbid desc		
		
	}
	
	function getRecentActivity(){
		$fbid = $this->session->userdata('fbid'); //'2529208';
		$recentactivity = $this->db->query('select records.activity_type, correct, correct_count, week, submit_time, pointvalue from records, points where fbid = ? and points.`activity_type` = records.`activity_type` order by week desc, submit_time desc',$fbid)->result_array();
		$fblikecount = 0;
		if (count($recentactivity) > 0) {
			$history = array();
			for ($i=1; $i < 7; $i++) { //6 weeks
				
				$aweekactivities = array();
				foreach ($recentactivity as $key => $value) {
					if ($i == $value['week']) {
						
						if ($value['activity_type'] == 'texttrivia') {
							$value['pointvalue'] = $value['correct_count'] * 2000;
						}
						if ($value['activity_type'] == 'phototrivia' && $value['correct'] == 'no') {
							$value['pointvalue'] = 0;
						}
						
						if ($value['activity_type'] == 'speedbump' && $value['correct'] == 'no') {
							$value['pointvalue'] = 0;
						}
						
						if ($value['activity_type'] == 'tumblr' && $value['week'] == 4) {
								$value['activity_type'] = 'instagram';
						}

						$aweekactivities[] = $value;
					}
				}
				$history[] = array(
					'week' => $i,
					'activities' => $aweekactivities
				);
			}
		}else{
			$history = false;
		}
		error_log(print_r($history,true),0);
		return $history;
	}
		
}
<?php
class Activity extends CI_Model {


    function __construct()
    {
		parent::__construct();
		$this->load->database();
    }
	
	function getAll(){
		// $this->db->cache_on();
		$result = $this->db->query(
		"select weeks.week, weeks_activity.activity_type, linkout_url, pointvalue, activityid, `youtubeid`, fbshare, twittershare, tumblrshare, twitter_share, fb_share, tumblr_share, share_url, 
		`twitteraccount`, `tumblraccount`, q1, a1, q2, a2, q3, a3, photo, img_small, question, a,b,c,d, fburl, checkinhash, speedbump_question, yes_answer, no_answer,
		activity_speedbumps.tout_src as speedbump_tout,
		checkin_share_fb, checkin_share_twitter, checkin_share_tumblr, checkin_share_img,
		fb.tout_src as fblikes_tout, fb.tout_src_large as fblikes_img_large,
		activity_youtubes.tout_src as youtubes_tout, activity_youtubes.title as youtubes_title,
		tw.tout_src as twitters_tout, tw.tout_src_large as twitters_img_large,
		tb.tout_src as tumblrs_tout, tb.tout_src_large as tumblrs_img_large,
		activity_texttrivia.tout_src as texttrivia_tout, 
		activity_pictures.tout_src as pictures_tout, activity_pictures.title as pictures_title,
		activity_phototrivia.tout_src as phototrivia_tout,
		activity_checkins.tout_src as checkins_tout, activity_checkins.title as checkins_title,
		activity_links.tout_src as links_tout
		from weeks_activity
		JOIN weeks
		LEFT JOIN activity_links ON (weeks_activity.activityid = activity_links.id and weeks_activity.activity_type = 'link')
		LEFT JOIN activity_fblikes as fb ON (weeks_activity.activityid = fb.id and weeks_activity.activity_type = 'fblike')
		LEFT JOIN activity_youtubes ON (weeks_activity.activityid = activity_youtubes.id and weeks_activity.activity_type = 'youtube')
		LEFT JOIN activity_twitters as tw ON (weeks_activity.activityid = tw.id and weeks_activity.activity_type = 'twitter')
		LEFT JOIN activity_tumblrs as tb ON (weeks_activity.activityid = tb.id and weeks_activity.activity_type = 'tumblr')
		LEFT JOIN activity_texttrivia ON (weeks_activity.activityid = activity_texttrivia.id and weeks_activity.activity_type = 'texttrivia')
		LEFT JOIN activity_pictures ON (weeks_activity.activityid = activity_pictures.id and weeks_activity.activity_type = 'picture')
		LEFT JOIN activity_phototrivia ON (weeks_activity.activityid = activity_phototrivia.id and weeks_activity.activity_type = 'phototrivia')
		LEFT JOIN activity_checkins ON (weeks_activity.activityid = activity_checkins.id and weeks_activity.activity_type = 'checkin')
		LEFT JOIN activity_speedbumps ON (weeks_activity.activityid = activity_speedbumps.id and weeks_activity.activity_type = 'speedbump')
		LEFT JOIN points ON (weeks_activity.activity_type = points.activity_type)
		where weeks_activity.`week` = weeks.week and weeks.active = 'yes' order by weeks_activity.id")->result_array();
		// $this->db->cache_off();
		$week = $result[0]['week'];
		//remove all empty values and also remove speedbump if today is mon,tues
		
		if (date('N') < 3) { // date('N') < 4// WED IS 3
			$removespeedbump = true;
			// $this->session->set_userdata('speedbump_active', false);
		}else{
			$removespeedbump = false;
			// $this->session->set_userdata('speedbump_active', true);
		}
		
		foreach ($result as $key => $value) {
			foreach ($value as $k => $v) {
				if (empty($v)) {
					unset($result[$key][$k]); //also remove empty and unrelated touts
				}
				if (strpos($k,'_tout') > 0 && !empty($v)) {
					$result[$key]['tout'] = $v;
				}
				if (strpos($k,'_title') > 0 && !empty($v)) {
					$result[$key]['title'] = $v;
				}
				if ($result[$key]['activity_type'] == 'speedbump' && $removespeedbump) {
					unset($result[$key]); break;
				}
			}
		}
				
		//organize texttrivia
		foreach ($result as $key => $value) {
			if ($value['activity_type'] == 'texttrivia') {
				$questions = array();
				for ($i=0; $i < 3; $i++) { 
					$questions[$i]['question'] = $value['q'.strval($i+1)];
					$a = $value['a'.strval($i+1)];
					$a = explode(';',$a);
					$questions[$i]['answers'] = array($a[0],$a[1],$a[2],$a[3]);
				}
				unset($result[$key]['a1']);
				unset($result[$key]['a2']);
				unset($result[$key]['a3']);
				unset($result[$key]['q1']);
				unset($result[$key]['q2']);
				unset($result[$key]['q3']);
				$result[$key]['questions'] = $questions;
			}
		}
		
		$fbid = $this->session->userdata('fbid');
		$userrecord = $this->db->query("select activity_type, aid, correct_count, correct from records where fbid = ? and week = ?", array($fbid,$week))->result_array();
		// error_log(print_r($userrecord,true),0);die();
		//loop through activities and gauge against user completed activities from $userrecord
		foreach ($result as $key => $value) {
			
			if (count($userrecord) == 0) {
				$result[$key]['completed'] = false; continue;
			}

			foreach ($userrecord as $k => $v) {
				//avoid another DB call.  piggy back off above loop to check if usercompleted speedbump. if not, set session
				if ($result[$key]['activity_type'] == 'speedbump' && $v['activity_type'] == 'speedbump') {
					$result[$key]['speedbump_completed'] = true;
				}
				
				if ($value['activityid'] == $v['aid'] && $value['activity_type'] == $v['activity_type']) {
					if ($userrecord[$k]['activity_type'] == 'texttrivia') {
						$result[$key]['pointvalue'] = $userrecord[$k]['correct_count'] * 2000;
					}
					if ($userrecord[$k]['activity_type'] == 'phototrivia' && $userrecord[$k]['correct'] == 'no') {
						$result[$key]['pointvalue'] = 0;
					}
					$result[$key]['completed'] = true;
				}else{
					// $result[$key]['completed'] = false; //as it loops through will undo the previous completed true above
				}
			}
		}
	
		
		
		return $result;
	}
		
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instagram extends CI_Controller {

	
	
	public function index()
	{
		$this->input->post();
	}
	
	
	public function receiveAccessToken(){
		
		// https://api.instagram.com/oauth/authorize/?client_id=c2ffc370eaa64c77979c7705d0bc5b3d&redirect_uri=http://staging2.racetodeleon.com/instagram/receiveAccessToken&response_type=code
		// 79a66318d18345acb28ca9f8789fa7a7
		
		// curl -X DELETE 'https://api.instagram.com/v1/subscriptions?client_secret=CLIENT-SECRET&id=1&client_id=CLIENT-ID'
		
		// curl -F 'client_id=c2ffc370eaa64c77979c7705d0bc5b3d' \
// 		    -F 'client_secret=c74e824ad78940a69dd7e279e17a5cdd' \
// 		    -F 'grant_type=authorization_code' \
// 		    -F 'redirect_uri=http://staging2.racetodeleon.com/instagram/receiveAccessToken' \
// 		    -F 'code=79a66318d18345acb28ca9f8789fa7a7' \https://api.instagram.com/oauth/access_token

		// access token
		// 21579807.c2ffc37.5eca6df4d4344c60a776927d91c3f119
		
		$searchtag = "https://api.instagram.com/v1/tags/nofilter/media/recent?client_id=c2ffc370eaa64c77979c7705d0bc5b3d&access_token=21579807.c2ffc37.5eca6df4d4344c60a776927d91c3f119&count=20";
		$response = json_decode(file_get_contents($searchtag));
		// $this->load->database();
		// $this->db->query()
	}
	
	public function receiveNOFILTER(){

		$c = $this->input->get();
		if ($c != false && isset($c['hub_challenge'])) {
			echo $c['hub_challenge'];
			die();
		}

		$postdata = json_decode(file_get_contents("php://input"));
		//[{"changed_aspect": "media", "object": "tag", "object_id": "nfsmovie", "time": 1391546318, "subscription_id": 4096744, "data": {}}]
		error_log(print_r('$postdata',true),0);
		error_log(print_r($postdata,true),0);
		switch ($postdata[0]->object_id) {
			case 'nfsmovie':
				$tag = 'nfsmovie';
				break;
				
			default:
				# code...
				break;
		}
		
		//check IG for post:
		$searchtag = "https://api.instagram.com/v1/tags/".$tag."/media/recent?client_id=c2ffc370eaa64c77979c7705d0bc5b3d&access_token=21579807.c2ffc37.5eca6df4d4344c60a776927d91c3f119&count=20";
		error_log(print_r('$searchtag',true),0);
		error_log(print_r($searchtag,true),0);
		$response = json_decode(file_get_contents($searchtag));
		$allusers = array();
		foreach ($response->data as $key => $value) {
			$user = array(
				'hash' => $tag,
				'igusername' => $value->user->username
			);
			$allusers[] = $user;
		}
		$this->load->database();
		$sql = "INSERT IGNORE INTO instagram_posts (hash, igusername) values ";
		foreach ($allusers as $data_item) {
			$sql .= '("'.$data_item['hash'].'", "'.$data_item['igusername'].'"), ';
		}
		echo "<pre>";
		print_r($sql);
		echo "</pre>";
		$sql = substr($sql, 0, -2); //remove ", " from end of query
		$this->db->query($sql);
		
		
		//create a POST request 
// curl -F 'client_id=c2ffc370eaa64c77979c7705d0bc5b3d' \
//      -F 'client_secret=c74e824ad78940a69dd7e279e17a5cdd' \
//      -F 'object=tag' \
//      -F 'aspect=media' \
// 	 -F 'object_id=nfsmovie' \
//      -F 'verify_token=myVerifyToken' \
//      -F 'callback_url=https://staging2.racetodeleon.com/instagram/receiveNOFILTER' \
//      https://api.instagram.com/v1/subscriptions/

//CHECK THE ENDPOINT WORKED
// https://api.instagram.com/v1/subscriptions?client_secret=c74e824ad78940a69dd7e279e17a5cdd&client_id=c2ffc370eaa64c77979c7705d0bc5b3d
		
		
//CREATE POST REQUEST USING PRODUCTION INSTAGRAM APP
// curl -F 'client_id=8446ec02951a4256b93f1a51257da22b' \
//      -F 'client_secret=f8d97273353545968ea05a33e5a43f9b' \
//      -F 'object=tag' \
//      -F 'aspect=media' \
// 	 -F 'object_id=nfsmovie' \
//      -F 'verify_token=myVerifyToken' \
//      -F 'callback_url=https://www.racetodeleon.com/instagram/receiveNOFILTER' \
//      https://api.instagram.com/v1/subscriptions/
// 		
// // https://api.instagram.com/v1/subscriptions?client_secret=f8d97273353545968ea05a33e5a43f9b&client_id=8446ec02951a4256b93f1a51257da22b
		
		
		
		
		
		
		
		

		
		// DELETE ENDPOING
		// curl -X DELETE 'https://api.instagram.com/v1/subscriptions?client_secret=c74e824ad78940a69dd7e279e17a5cdd&object=all&client_id=c2ffc370eaa64c77979c7705d0bc5b3d'
	}
	
	
}
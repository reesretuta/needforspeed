<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	function __construct()
   {
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
       // $this->facebook = new Facebook(array('appId' => APPID, 'secret' => SECRET));
       date_default_timezone_set('America/Los_Angeles');
	   //http://stackoverflow.com/questions/8548893/facebook-php-sdk-issue-with-session-start
	   //undo on staging: chmod 777 /var/lib/php/session
   }
	
	
	public function instagram(){
		
		//get instagram access token (http://dmolsen.com/2013/04/05/generating-access-tokens-for-instagram/):
		//https://api.instagram.com/oauth/authorize/?client_id=[clientID]&redirect_uri=[redirectURI]&response_type=code
		//https://api.instagram.com/oauth/authorize/?client_id=7d8f8b4382df4a75b2827293df1899a3&redirect_uri=http://needforspeed.local&response_type=code
		// CLIENT ID=	7d8f8b4382df4a75b2827293df1899a3
		// CLIENT SECRET= e1d63a449bfe4ac5afe4b7e9f9bb5ee9
		//get your code: e62d4d337096477aa33d2c57d8ebbae6
		//access token: 21579807.7d8f8b4.bb1bd21e0d4a45d39f05d6dd60b11c33
		
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		// 	CURLOPT_RETURNTRANSFER => 1,
		// 	CURLOPT_URL => 'https://api.instagram.com/v1/tags/needforspeed/media/recent?access_token=23953320.6260cdf.c3138a01bd0941f28fcbd4f2ac9d682b',
		// 	CURLOPT_USERAGENT => 'NFS Instgram Feed'
		// ));
		//above is fetching #disney. need to change to #NFSBROOKLYN
		// CURLOPT_URL => 'https://api.instagram.com/v1/users/284634734/media/recent?access_token=23953320.6260cdf.c3138a01bd0941f28fcbd4f2ac9d682b',


		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://api.instagram.com/v1/tags/nfsmovie/media/recent?access_token=21579807.7d8f8b4.bb1bd21e0d4a45d39f05d6dd60b11c33',
			CURLOPT_USERAGENT => 'NFS Instgram Feed'
		));
		
		$resp = curl_exec($curl);
		curl_close($curl);
		$resp = json_decode($resp);
		$instagramfeed = array();

		foreach ($resp->data as $key => $value) {
			//$value->user->username == 'nocciolina09' && 
			if ($value->type == 'image') {
				$instagramfeed[] = $value;
			}
		}
		if (count($instagramfeed) > 0) {
			$this->load->database();
			$data = array('response' => json_encode($instagramfeed));
			$this->db->where('feed', 'instagram');
			$this->db->update('feeds', $data); 
		}

	}
	
	public function twitter(){
		
		// $twitteruser                  = "reesretuta";
		// $hash						= 'awesome';
		// $numtweets                    = 30;
		// $config['consumer_key']       = "hv37ARIXczunxak6gwEGQ";
		// $config['consumer_secret']    = "SYIkkEhgY5kkFcyhuD9QO3zktH5Qrm5FAIlkD9Phk";
		// $config['oauth_token']        = "16383543-I4PIRfR2PUi2nhrHG3ZiHIZvh7vGaNN0WM2XfVXq8";
		// $config['oauth_token_secret'] = "RpoJg9H3s3kYpwZqUOHtTZtIubUxVvlC3RQRCKheOJjQh";
		
		$twitteruser                  = "needforspeed";
		$hash						= 'nfsmovie';
		$numtweets                    = 30;
		$config['consumer_key']       = "L9DdhsaH4qEbiqjONrklpw";
		$config['consumer_secret']    = "yvmsrMPBVac13mDYs8UFTSqmOiEcGEvQKUC2E8cZG0";
		$config['oauth_token']        = "23135183-zlYk53bzFDWXw1JKsSReXMdSuqzJY7cEg3wNRVMQ4";
		$config['oauth_token_secret'] = "N9jYqXg0VFYeQdDJp08FI67GNlZG9SkTPpl7TbVNdZP1q";
		$this->load->library('twitteroauth/twitteroauth/twitteroauth',$config);
		$tweets = $this->twitteroauth->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=30");
		// $tweets = $this->twitteroauth->get("https://api.twitter.com/1.1/search/tweets.json?q=%23".$hash."%20from%3A".$twitteruser."&src=typd&count=15");
		
		
		if (count($tweets)>0) {
			$this->load->database();
			$data = array('response' => json_encode($tweets));
			$this->db->where('feed', 'twitter');
			$this->db->update('feeds', $data);
		}	
		// $curl = curl_init();
		// curl_setopt_array($curl, array(
		//     CURLOPT_RETURNTRANSFER => 1,
		//     CURLOPT_URL => 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=reesretuta&count=2&oauth_token=16383543-I4PIRfR2PUi2nhrHG3ZiHIZvh7vGaNN0WM2XfVXq8&oauth_token_secret=RpoJg9H3s3kYpwZqUOHtTZtIubUxVvlC3RQRCKheOJjQh',
		//     CURLOPT_USERAGENT => 'NFS Twitter Feed',
		// ));
		// $resp = curl_exec($curl);
		// curl_close($curl);
	}
}
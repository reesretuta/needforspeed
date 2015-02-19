<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/zebra_curl/Zebra_cURL.php');

class Notification extends CI_Controller {
	
	function __construct()
   {
		parent::__construct();
		$this->load->database();
   }
   
   function blast(){
	$week = $this->input->get('week');
	$message = $this->input->get('message');
	$password = $this->input->get('password');
	
	if ($week == false || $message == false)
		die('undefined');
	
	$template = array(
		'1' => array(
			'1' => 'Enter the Race To DeLeon for a chance to win a 2015 Ford Mustang. Need For Speed is in theaters March 14.',
			'2' => 'The finish line is coming up fast. Share the extended NFS look by today to take the checkered flag and possibly a PS4 and Need for Speed Rivals game. Monarch out.'
		),
		'2' => array(
			'1' => "Aside from a free car, free gas for a year is the next best thing. Share the Ford video 'Hero Mustang' for a chance to win!",
			'2' => 'Free Gas for a year is on the line. I mean c’mon - think of all the love you get out of just one tank. Share the ‘Mustang Hero’ video for a chance to win!',
		),
		'3' => array(
			'1' => 'Find out who’s responsible for the NFS movie stunts. Share the video for a chance to win a $250 Royal Purple Gift Certificate, leather racing jacket and other swag.',
			'2' => 'Lance Gilbert is a legend. You know he’s a third generation stunt man? Last chance to share this video for a chance to win $250 gift card from Royal Purple and other gear!'
		),
		'4' => array(
			'1' => 'MagnaFlow just paid us a visit (you can hear them coming from a mile away) & we have 10 prize packs to give away. Get in on this by sharing the Sound of Magnaflow video.',
			'2' => 'Hurry up and share the Sound of Magnaflow video. I can already hear the sound of this MagnaFlow prize pack passing you by. It sounds beautiful.'
		),
		'5' => array(
			'1' => 'Check out the soundtrack for Need for Speed for a chance to win an iPad mini.',
			'2' => 'Here’s your last chance to win an iPad mini! Share Need for Speed’s new video featuring heart-racing music and the cast from #NFSMovie, in theaters 3/14.'
		),
		'6' => array(
			'1' => 'Satisfy your need for speed with a $100 gift card and a movie poster signed by the cast. Enter the Race to DeLeon for a chance to win! Need for Speed is in theaters this Friday.',
			'2' => 'Need For Speed races into theaters TODAY! Don’t miss your chance to get a $100 Fandango gift card and cast-signed movie poster!'
		),
	);
	
	
	$tosend = $template[$week][$message];
	   
	   // instantiate the Zebra_cURL class
	   $curl = new Zebra_cURL();

	   
	   // cache results 60 seconds
	   // $curl->cache('cache', 60);
	   
	// $curlConfig = array( 
	// 	CURLOPT_URL            => "https://graph.facebook.com/2529208/notifications",
	//     CURLOPT_POST           => true,
	//     CURLOPT_RETURNTRANSFER => true,
	//     CURLOPT_POSTFIELDS     => array(
	//         'access_token' => APPTOKEN,
	//         'href' => SITEURL,
	// 		'template' => $tosend
	//     ),
	// );
	
	
	
	if ($password == 'blahblahblah' && ENVIRONMENT == 'stagingphase2') {
		
		$this->load->database();
		$result = $this->db->query('select fbid from users order by id asc')->result_array();
			
		$people = array();
		foreach ($result as $key => $value) {
			$people[] = 'https://graph.facebook.com/'.$value['fbid'].'/notifications';
		}
	}else{
		$people = array(
			'https://graph.facebook.com/1585354030/notifications', //allison
			'https://graph.facebook.com/2529208/notifications'
		);
	}

	$curl->post($people, array(
	    'access_token'   =>  '637534242965826|md3Xq65q3bbV1A7FVC4fEzSXaRo',
	    'href'   =>  'https://www.racetodeleon.com',
	    'template'    =>  $tosend,
	),'callback');
	
	   
   }
   
   
   
   
	// $ch = curl_init();
	// foreach ($result as $key => $value) {
	// 	$this->benchmark->mark('code_start');
	// 	// CURLOPT_URL            => "https://graph.facebook.com/".$value['fbid']."/notifications",
	// 	$curlConfig = array( 
	// 		CURLOPT_URL            => "https://graph.facebook.com/2529208/notifications",
	// 	    CURLOPT_POST           => true,
	// 	    CURLOPT_RETURNTRANSFER => true,
	// 	    CURLOPT_POSTFIELDS     => array(
	// 	        'access_token' => APPTOKEN,
	// 	        'href' => SITEURL,
	// 			'template' => $tosend
	// 	    ),
	// 	);
	// 	$this->benchmark->mark('code_end');
	// 	curl_setopt_array($ch, $curlConfig);
	// 	$result = curl_exec($ch);
	// 	echo "<pre>";
	// 	print_r('1 CURL completed in: '. $this->benchmark->elapsed_time('code_start', 'code_end'));
	// 	echo "</pre>";
	// 	echo "<pre>user: ".$value['fbid'] . "<br/>";
	// 	print_r($result);
	// 	echo "</pre>";
	// }
	// echo "<pre>";
	// print_r('total execution time:');
	// echo "</pre>";
	// echo "<pre>";
	// print_r($this->benchmark->elapsed_time());
	// echo "</pre>";
	// curl_close($ch);
   
}


function callback($result) {
       // results from twitter is json-encoded;
       // remember, the "body" property of $result is run through "htmlentities()" so we need to "html_entity_decode" it
       $result->body = json_decode(html_entity_decode($result->body));
       // show everything
       print_r('<pre>');
       print_r($result->info['original_url']);
	   print_r('</pre>');
   }
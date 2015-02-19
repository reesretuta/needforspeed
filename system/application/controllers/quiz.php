<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz extends CI_Controller {
	
	function __construct()
   {
       // Call the Model constructor
       parent::__construct();
       $this->load->database();
       $this->facebook = new Facebook(array('appId' => APPID, 'secret' => SECRET));

   }
	
   function answers_get(){
	   $this->this->get('at');
	   
   }
	
}
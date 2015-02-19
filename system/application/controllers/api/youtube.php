<?php

require(APPPATH.'libraries/REST_Controller.php');

class Youtube extends REST_Controller
{
	
	public $table = 'activity_quizzes';
	public $debugmode = true;
	
	public function __construct()
	{	
		parent::__construct();
		$this->load->database();
	}
	
	
	public function texttrivia_post(){
		$aid = $this->post('aid');
		$a1 = $this->post('a1');
		$a2 = $this->post('a2');
		$a3 = $this->post('a3');
		if ($aid == false || $a1 == false || $a2 == false || $a3 == false) {
			$this->response(array('error' => 'missing answer'), 400);
		}
		$this->load->Model('Record');
		$r = $this->Record->submitQuiz('1','123',$a1,$a2,$a3);
		$this->response($r, 400);
	}
	

}
?>
<?php

require(APPPATH.'libraries/Mobile_Detect.php');

class View_Controller extends Mobile_Detect {
	
	public function __construct()
	{
	    parent::__construct();
	}
	
	public function outputView($a){
		echo $a;
	}
	
}
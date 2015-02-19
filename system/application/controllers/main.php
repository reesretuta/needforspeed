<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_controller {
	
	public $fbid = null;
	public $user = null;
	public $ismobile = false;
	public $authorized = false;
	public $antiCache = null;
	
	public function __construct(){
		parent::__construct();
		$this->ismobile	= ($this->mobile_detect->isMobile() && !$this->mobile_detect->isTablet() || $this->input->get('mobile') != false) ? true:false;
		$this->antiCache = time();
	}
	
	public function scriptSrc($name) {
	    return ENVIRONMENT === 'development' ?  "/media/js/{$name}.js?v={$this->antiCache}" : "/media/js-min/{$name}.min.js";
	}

	public function rules(){
		$pagedata['content'] = $this->load->view('rules',null,true);
		$this->load->view('shell',$pagedata);
	}

    public function rules_challenge() {
        $pagedata['content'] = $this->load->view('rules-challenge',null,true);
        $this->load->view('shell',$pagedata);
    }
	
	public function canvasredirect() {
		$this->load->view('canvasredirect');
	}
	
	public function start_debug() {
		$data['dashboard']['user'] = array(
			'fbid' => '2529208',
			'firstname' => 'rees',
			'lastname' => 'retuta',
			'email' => 'rees.retuta@gmail.com'
		);
		$this->load->model('Activity');
		$data['dashboard']['points'] = 0;
		$data['dashboard']['activities'] = $this->Activity->getAll();
		$data['access_token'] = 'xxxxxxx';

        $pagedata['scripts'] = array(
            'libraries' => array(
                '/media/js/libs/underscore-min.js',
                '/media/js/libs/spinner.min.js'
            ),
            'jqueryLibraries' => array(
                $this->scriptSrc('helpers'),
                '/media/js/libs/bootstrap.min.js',
            ),
            'js' => array(
                $this->scriptSrc('animation'),
                $this->scriptSrc('dashboard'),
                $this->scriptSrc('activities'),
                $this->scriptSrc('customizer'),
                $this->scriptSrc('map'),
                $this->scriptSrc('quiz')
            )
        );

		$pagedata['content'] = $this->load->view('shell_dashboard',$data,true);
		$this->load->view('shell',$pagedata);
	}

	
	public function index($referer = null){
        $pagedata['scripts'] = array(
            'libraries' => array(
                '/media/js/libs/spinner.min.js',
            ),
            'jqueryLibraries' => array(
                $this->scriptSrc('helpers'),
                '/media/js/libs/bootstrap.min.js',
                '/media/js/libs/jquery.fancybox.min.js',
                '/media/js/libs/jquery.customSelect.min.js'
            ),
            'js' => array($this->scriptSrc('site'))
        );

        $data = array();
        if(isset($_GET['share'])) {
            $data['modals']['picture-public'] = $this->load->view('modals/picture-public',null,true);
            array_unshift($pagedata['scripts']['js'],$this->scriptSrc('picturePublic'));
        }


		if ($referer != null) {
			$newdata = array('referer' => $referer);
			$this->session->set_userdata($newdata);
		}
		if ($this->ismobile) {
            $data['ismobile'] = true;
            array_unshift($pagedata['scripts']['js'],$this->scriptSrc('mobile'));


			$pagedata['content'] = $this->load->view('mobile/shell_landing',$data,true);
			$this->load->view('mobile/shell',$pagedata);
		}else {
            $data['ismobile'] = false;
			$pagedata['content'] = $this->load->view('shell_landing',$data,true);
			$this->load->view('shell',$pagedata);
		}
		
		// $this->output->cache(1440); //cache for 24hours = 1440 minutes
	}

	
	public function start(){
		$at = $this->input->get('a');
		if ($at == false) {
			header('Location: /');
		}
		try {
            if(strpos($at,"mobile") !== false) {
                $at = str_replace("mobile","",$at);
                $mobile = true;
            } else {
                $mobile = false;
            }
			
			$this->facebook->setAccessToken($at);
			$this->facebook->setAppSecret(SECRET);
			$user_detail = $this->facebook->api('/me');
			
			//set session
			$newdata = array(
				'access_token' => $at,
				'fbid' => $user_detail['id']
			);
			$this->session->set_userdata($newdata);
			
			/* user is really logged into FB */
			$this->load->model('User');
			$this->load->model('Activity');
			$this->load->model('Record');
			$data['dashboard']['user'] = $this->User->getUserInfo($this->session->userdata('fbid'));
			$data['dashboard']['crew'] = $this->User->getCrewInfo($this->session->userdata('fbid'));
			$data['dashboard']['history'] = $this->Record->getRecentActivity();
			//need to get current week
			$data['dashboard']['activities'] = $this->Activity->getAll();
			$data['access_token'] = $at;

            $pagedata['scripts'] = array(
                'libraries' => array(
                    '/media/js/libs/underscore-min.js',
                    '/media/js/libs/spinner.min.js'
                ),
                'jqueryLibraries' => array(
                    $this->scriptSrc('helpers'),
                    '/media/js/libs/bootstrap.min.js',
                    '/media/js/libs/jquery.nicescroll.min.js'
                ),
                'js' => array(
                    $this->scriptSrc('animation'),
                    $this->scriptSrc('dashboard'),
                    $this->scriptSrc('activities'),
                    $this->scriptSrc('customizer'),
                    $this->scriptSrc('map'),
                    $this->scriptSrc('quiz')
                )
            );

            if ($data['dashboard']['user']['car'] == null) {
                array_unshift($pagedata['scripts']['js'],$this->scriptSrc('carselect'));
            }

			if ($this->ismobile) {
				$data['dashboard']['ismobile'] = true;
                array_unshift($pagedata['scripts']['js'],$this->scriptSrc('mobile'));

                if ($data['dashboard']['user']['car'] == null) {
                    $data['dashboard']['carselection'] = $this->load->view('mobile/carselection',$data,true);
                }

				$data['modals']['customize'] = $this->load->view('mobile/modals/customize',$data,true);
				$data['modals']['howtoplay'] = $this->load->view('mobile/modals/howtoplay',$data,true);
				$data['modals']['map'] = $this->load->view('mobile/modals/map',$data,true);
				$data['modals']['speedbump'] = $this->load->view('mobile/modals/speedbump',$data,true);
				$data['modals']['notifications'] = $this->load->view('mobile/modals/notifications',$data,true);

				$data['modals']['checkin'] = $this->load->view('mobile/modals/activities/checkin',$data,true);
				$data['modals']['picture'] = $this->load->view('mobile/modals/activities/picture',$data,true);
				$data['modals']['trivia'] = $this->load->view('mobile/modals/activities/trivia',$data,true);
				$data['modals']['youtube'] = $this->load->view('mobile/modals/activities/youtube',$data,true);
                $data['modals']['follow'] = $this->load->view('mobile/modals/activities/follow',$data,true);

				$pagedata['content'] = $this->load->view('mobile/shell_dashboard',$data,true);
				
				$this->load->view('mobile/shell',$pagedata);
				

			}else {
				//desktop
				if ($data['dashboard']['user']['car'] == null) {
					$data['dashboard']['carselection'] = $this->load->view('carselection',$data,true);
				}
				
				$data['modals']['howtoplay'] = $this->load->view('modals/howtoplay',$data,true);
				$data['modals']['map'] = $this->load->view('modals/map',$data,true);
				$data['modals']['customize'] = $this->load->view('modals/customize',$data,true);
				$data['modals']['follow'] = $this->load->view('modals/activities/follow',$data,true);
				$data['modals']['picture'] = $this->load->view('modals/activities/picture',$data,true);
				$data['modals']['youtube'] = $this->load->view('modals/activities/youtube',$data,true);
				$data['modals']['trivia'] = $this->load->view('modals/activities/trivia',$data,true);
				$data['modals']['checkin'] = $this->load->view('modals/activities/checkin',$data,true);
				
				$pagedata['content'] = $this->load->view('shell_dashboard',$data,true);
				$this->load->view('shell',$pagedata);
			}
			
			
			
		} catch (Exception $e) {
		   error_log(print_r('user is not currently logged into the FB or user trying to pass invalid FB access token. only valid FB tokens should work',true),0);
		   header('Location: /');
		}
	}
		

}
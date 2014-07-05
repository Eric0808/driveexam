<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends J_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('UserStatus');
	}
	
	/**
	 * user center
	 */
	public function index()
	{
		
	}
	
	
	// 登录
	public function login()
	{
		$box = array('class'=>'small login');
		if( $this->userstatus->isOnline() ){
			$content = "Hi! {$_SESSION['username']}, 您已经登录了";
			$content = $this->load->view('tool/message', array('message'=>$content), true);
			return $this->layout("您已经登录了", $content, $box);
		}else{
			if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
				$setting = array();
				$setting['class'] = 'small login';
				$setting['javascript'] = array('checkForm');
				$content = $this->load->view('user/login', null, true);
				return $this->layout('登录', $content, $setting);
			}else{
				$error = array();
				if( ! is_numeric($_POST['id']) ){
					$error[] = '身份证号码不正确';
				}
				if( preg_match('@[^a-zA-Z0-9]@', $_POST['password']) ){
					$error[] = '密码只能包含字母或数字';
				}
				if( !empty($error) ){
					$content = $this->load->view('account', null, true);
					return $this->layout('请重新登录', $content, array('error'=>$error, 'javascript' => array('checkForm')) );
				}
				
				$this->load->model('client/member_model', 'member');
				$result = $this->member->logIn($_POST);
				
				if( $result['code'] !== 0){
					$content = $this->load->view('account', array('id'=>$_POST['id']), true);
					return $this->layout('登录失败', $content, array('error'=>array($result['msg']), 'javascript' => array('checkForm')) );			
				}else{
					$this->userstatus->setOnline($result['name'], $result['id'],$result['sex']);
					header('Location: ./');
					return;
				}
			}
			
		}
	
	}
	
	// 注册
	public function singup()
	{
		$data = array();
		$data['class'] = 'small login';
		
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
			$data = array();
			$this->load->model('user/menu', 'menu');
			$data['menu'] = $this->menu->getMenu();
			$data['javascript'] = array('checkForm');
			
			$content = $this->load->view('user/singup', null, true);
			return $this->layout('注册', $content, $data);
		}else{
			$error = array();
			
			if( ! isset($_POST['sex']) )			$_POST['sex'] = '';
			
			if( ! is_numeric($_POST['IDCard']) ){
				$error[] = '身份证号码不正确';
			}else{
				$nlen = strlen($_POST['IDCard']);
				if( $nlen !== 15 && $nlen!==18 ){
					$error[] = '身份证号码需要是18位或15位的数字';
				}	
			}
			
			if( empty($_POST['username']) ){
				$error[] = '姓名不能为空';
			}
			if( empty($_POST['password']) ){
				$error[] = '密码不能为空';
			}else{
				if( preg_match('@[^a-zA-Z0-9]@', $_POST['password']) ){
					$error[] = '密码只能包含字母或数字';
				}
			}
			if( ! is_numeric($_POST['age']) ){
				$error[] = '年龄不正确';
			}
			if( empty($_POST['job']) ){
				$error[] = '请填写您当前的职务';
			}
			if( empty($_POST['record']) ){
				$error[] = '请填写您的学历';
			}
			if( $_POST['sex'] !== '1' && $_POST['sex'] !== '2' ){
				$error[] = '请选择性别';
			}

			if( is_array($_POST['subject']) ){
				foreach($_POST['subject'] as &$v){
					$v = intval($v);
				}
			}
			
			if( !empty($error) ){
				$data = array();
				$data['error'] = $error;
				$data['javascript'] = array('checkForm');
				$content = $this->load->view('user/singup', null, true);
				return $this->layout('请重新注册', $content, $data);
			}
			
			$_POST['job'] = substr($_POST['job'], 0, 200);
			$_POST['record'] = substr($_POST['record'], 0, 200);
			
			
			$this->load->model('user/member_model', 'member');
			$result = $this->member->createMember($_POST);
			
			
			if( $result['code'] !== 0 ){
				$data['error'] = array($result['msg']);
				$content = $this->load->view('tool/message', $data, true);
				$this->layout("注册失败", $content, $data);
			}else{
				$this->userstatus->setLoginStatus($result['id']);
				$this->userstatus->setOnline($_POST['username'], $result['id']);
				$this->layout('注册成功', '');
			}
		}
	}

}
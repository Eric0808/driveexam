<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends J_Controller 
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
		if( ! $this->userstatus->isOnline() ){
			header('Location: '.base_url().'user/login/');
			exit;
		}

		$this->load->model('member_model', 'member');
		$info = $this->member->getInfo($this->userstatus->getUserId());
		
		$content = $this->load->view('user/info', $info, true);
		$this->layout('我的信息', $content);
	}
	
	
	
	// 登录
	public function login()
	{
		$this->data['class'] = 'small login';
		$this->data['javascript'][] = 'checkForm';
		
		if( $this->userstatus->isOnline() ){
			$content = "Hi! {$_SESSION['username']}, 您已经登录了";
			return $this->layout("您已经登录了", $content);
		}else{
			if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
				$content = $this->load->view('user/login', null, true);
				return $this->layout('登录', $content);
			}else{
				$error = array();
				if( ! ($_POST['email']) ){
					$error[] = '请填写用户名或邮箱';
				}
				if( empty($_POST['password']) ){
					$error[] = '请填写密码';
				}else if( preg_match('@[^a-zA-Z0-9]@', $_POST['password']) ){
					$error[] = '密码只能包含字母或数字';
				}
				
				
				if( empty($error) ){
					$this->load->model('member_model', 'member');
					$result = $this->member->logIn($_POST);
					if( $result['code'] == 0 ){
						// login success!
						$this->userstatus->setOnline($result['name'], $result['id']);
						header('Location: '. base_url() .'user/');
						return;
					}else{
						$error[] = $result['msg'];
					}
				}
				
				$msg['email'] = $_POST['email'];
				$msg['error'] = $error;
				
				$content = $this->load->view('user/login', $msg, true);
				$this->layout('请重新登录', $content);		
			}
			
		}
	
	}
	
	// 注册
	public function signup()
	{
		$this->data['class'] = 'small login';
		$this->data['javascript'][] = 'checkForm';
		
		
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){			
			$content = $this->load->view('user/signup', null, true);
			return $this->layout('注册', $content);
		}else{
			$error = array();
			
			if( ! $_POST['email'] ){
				$error[] = '邮箱格式不正确';
			}else{
				
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
			
			if( !empty($error) ){
				$content = $this->load->view('user/signup', null, true);
				return $this->layout('请重新注册', $content);
			}

			$this->load->model('member_model', 'member');
			$result = $this->member->createMember($_POST);
			
			
			if( $result['code'] !== 0 ){
				$data['message'] = $result['msg'];
				$content = "注册失败，请尝试重新注册";
				$this->layout("注册失败", $content);
			}else{
				$this->userstatus->setLoginStatus($result['id']);
				$this->userstatus->setOnline($_POST['username'], $result['id']);
				$_SESSION['msg'] = '恭喜您注册成功，您今后可以直接用邮箱或用户名登录';
				header('Location: '.base_url().'user/');
			}
		}
	}
	
	
	public function logout()
	{
		session_destroy();
		setcookie('id', 'deleted', time()-3600*24, '/');
		setcookie('subjectid', 'deleted', time()-3600*24, '/');
		setcookie('ismember', 'deleted', time()-3600*24, '/');
		setcookie(session_name(), 'deleted', time()-3600*24, '/');
		header('Location: '.base_url());
	}
	
	
	public function change()
	{
		if( ! $this->userstatus->isOnline() ){
			$_SESSION['msg'] = '本次登录会话已经失效，请您重新登录';
			header('Location: '.base_url().'user/login/');
			exit;
		}
		
		$uid = $this->userstatus->getUserId();
		$this->load->model('member_model', 'member');
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
			$info = $this->member->getInfo($uid);
			$content = $this->load->view('user/change', $info, true);
			return $this->layout('修改我的信息', $content);
		}else{
			$this->load->model('member_model', 'member');
			$this->member->updateInfo($uid, @$_POST['qq'], @$_POST['phone'], @$_POST['sex']);
			header('Location: '.base_url().'user/change/');
			$_SESSION['msg'] = '修改成功';
		}
	}
	
	
	public function password()
	{
		if( ! $this->userstatus->isOnline() ){
			$_SESSION['msg'] = '本次登录会话已经失效，请您重新登录';
			header('Location: '.base_url().'user/login/');
			exit;
		}
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
			$content = $this->load->view('user/password', null, true);
			return $this->layout('修改密码', $content);
		}else{
			if( !isset($_POST['new']) || $_POST['new'] === '' ){
				$msg = '请输入新密码';
			}elseif( strlen($_POST['new']) < 5 ){
				$msg = '请输入长度至少为6位的密码';
			}elseif( preg_match('@[^a-zA-Z0-9]@', $_POST['new']) ){
				$msg = '密码只能包含字母或数字';
			}elseif( $_POST['new'] !== $_POST['renew'] ){
				$msg = '您两次输入的新密码不一致';
			}
			if( !isset($msg) || empty($msg) ){
				$uid = $this->userstatus->getUserId();
				$this->load->model('member_model', 'member');
				$result = $this->member->changepassword($uid, $_POST['old'], $_POST['new']);
				if( $result === true ){
					header('Location: '.base_url().'user/');
					$_SESSION['msg'] = '密码修改成功';
					exit;
				}else{
					$msg = '您输入的现有密码并不正确';
				}
			}
			
			$_SESSION['msg'] = $msg;
			$content = $this->load->view('user/password', null, true);
			return $this->layout('修改密码', $content);
		}
	}
	
	public function info()
	{
		if( isset($_COOKIE['id']) && isset($_COOKIE['ismember']) && $_COOKIE['ismember'] ){
			$uid = (int)$_COOKIE['id'];
			$username = $this->userstatus->getUserName($uid);
			if( is_null($username) ){
				$this->load->model('member_model', 'member');
				$info = $this->member->getInfo($uid, 'username');
				$username = $info['username'];
				
				$this->userstatus->setLoginStatus($uid);
				$this->userstatus->setOnline($username, $uid);
			}
			$response = '';
			$time = $this->userstatus->getTime();
			if( $time ){
				$response .= $time .'&nbsp;&nbsp;';
			}
			$response .= htmlspecialchars($username) .'&nbsp;&nbsp;&nbsp;';
			$response .= '<a href="'.base_url().'user/" >会员中心</a> | ';
			$response .= '<a href="'.base_url().'user/logout" >退出</a> ';
			
			echo $response;
		}
	}
	
	
	protected function loadViewBefore(&$data)
	{
		$this->load->model('menu_model', 'menu');
        $data['menu'] = $this->menu->getUserCenter();
	}	

}

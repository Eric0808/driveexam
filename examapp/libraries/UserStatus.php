<?php

final class UserStatus
{
	private $userid;

	// 会员登录cookie保留30天
	private $lifetime = 30;
	
	public function __construct()
	{
		if( ! isset($_SESSION) ){
			if( ! headers_sent() ){
				session_start();
			}else{
				exit('session has sent');
			}
		}
	}
	
	
	/**
	 * 是否正在在线
	 */
	public function isOnline()
	{
		return isset($_SESSION['username']) && !empty($_SESSION['username']);
	}
	
	/**
	 * 曾经是登录过
	 */
	public function hasLogin()
	{
		return isset($_COOKIE['id']) && !empty($_COOKIE['ID']);
	}
	
	
	public function setLoginStatus($id)
	{
		setCookie('ismember', '1', time()+3600*24*$this->lifetime, '/');
		setCookie('id', $id, time()+3600*24*$this->lifetime, '/');
		return true;
	}
	
	public function setOnline($name, $id, $sex)
	{
		$_SESSION['username'] = $name;
		$_SESSION['id']		  = $id;
		$_SESSION['sex']	  = $sex==0 ? '男' : '女';
		if( !is_null($id) ){
			$this->setLoginStatus($id);
		}
	}

	
	public function getUserID()
	{
		if( isset($_SESSION['id']) && is_numeric($_SESSION['id']) ){
			$this->userid = $_SESSION['id'];
		}elseif( isset($_COOKIE['id']) ){
			$this->userid = $_COOKIE['id'];
		}else{
			$CI =& get_instance();
			$CI->load->model('member_model', 'member');
			$this->userid = $CI->member->createGuest();
			setcookie('id', $this->userid, time()+3600*24*$this->lifetime, '/');
		}
		
		return $this->userid;
	}
	
	public function getUserSex()
	{
		if( isset($_SESSION['sex']) ){
			return $_SESSION['sex'];
		}
		else{
			return '未知';
		}
	}
	
	public function getUserName()
	{
		if( isset($_SESSION['username']) ){
			return $_SESSION['username'];
		}
	}
	
	
	public function getCode()
	{
		if( $this->isOnline() ){
			return 2;
		}else if( $this->hasLogin() ){
			return 1;
		}else{
			return 3;
		}
	
	}
	
	
	public function checkStatus($status)
	{
		$status = (int)$status;
		switch($status)
		{
			case 0:
				// 未审批
				$title = '申请还未批复';
				$message = '您的报名申请正在等待管理员批复，请稍等<br/>'.
						'您可以稍后刷新该页面，如果您已经通过审核，就可以在该页面选择要参加的考试';
				break;
			case 1:
				// 通过
				$message = false;
				break;
			case -1:
				$title = '账户被禁用';
				$message = '您的账户已经被管理员锁定';
				break;
		}
		
		if( empty($message) ){
			return true;
		}
		
		return array('message' => $message, 'title'=>$title, 'error'=>false);
	}
	
	public function getTime()
	{
		$strTimeToString = "000111222334455556666667";
		$strWenhou = array('夜深了,','夜深了,','早上好!','上午好!','中午好!','下午好!','晚上好!','夜深了,');
		return $strWenhou[(int)$strTimeToString[(int)date('H',time())]];
	}
	
}
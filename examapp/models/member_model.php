<?php

final class member_model extends CI_Model
{
	
	private $tname = 'member_info';
	private $tname1 = 'record_info';
	
	public function __construct()
	{
		parent::__construct();
	}

	public function createMember($info)
	{
		$data['email'] = $info['email'];
		if( $this->db->get_where($this->tname, $data)->num_rows !== 0 ){
			return array('code'=> 1, 'msg'=>'该邮箱地址已注册过，您是否忘记了密码？');
		}
		$data['username'] = htmlspecialchars($info['username']);
		$data['password'] = $this->passwordHash($info['password']);
		
		$data['regdate'] = $data['lastdate'] = time();
		$data['regip'] = $this->input->ip_address();
		$data['loginnum'] = 1;
		
		$result = $this->db->insert($this->tname, $data);
		return array('code'=>0, 'id'=>$this->db->insert_id(), 'name'=>$data['username']);
	}

	public function createGuest()
	{
		$data['regdate'] = time();
		$data['regip'] = $this->input->ip_address();
		
		$result = $this->db->insert($this->tname, $data);
		return $this->db->insert_id();
	}
	
	//根据条件获取所有用户信息列表
	public function Getallmember($page = 1, $pageSize = 20, $setPages = 10, $where='', $order=''){
		
		$sqlStr = "SELECT * FROM {$this->tname} AS m LEFT JOIN (SELECT DISTINCT userid AS id, COUNT( userid ) AS num FROM {$this->tname1} GROUP BY userid) AS l ON m.userid = l.id ";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->tname} as m {$where} ";
		$allnum=$this->getuser_num($sqlStr1);
		$page = max(intval($page), 1);
		$offset = $pageSize*($page-1);
		$query[0] =$this->globalfunc->pages($allnum, $page, $pageSize,$setPages);
		if($allnum >0){
			$sqlStr .= " $where $order LIMIT $offset, $pageSize";
			
			$query[1] = $this->db->query($sqlStr)->result();
			return $query;
		}		
		else
		return null;
		
	}
	//根据条件获取所有用户记录的数量
	public function getuser_num($sqlStr){
	
		$num = $this->db->query($sqlStr)->row_array();
		return $num['COUNT(*)'];
	}
	//根据ID删除用户信息包括考试记录
	public function deluser_byID($UID){
		$status = array();
		$status[0] = $this->db->delete($this->tname, array('userid' => $UID)); 
		$status[1] = $this->db->delete($this->tname1, array('userid' => $UID));
	    return $status;
	}

	public function logIn($info)
	{
		$info['email'] = $this->db->escape($info['email']);
		
		$sql = "SELECT * FROM `{$this->tname}` ";
		if( strpos($info['email'], '@') !== false ){
			$sql .= "WHERE `email`={$info['email']}";
		}else{
			$sql .= "WHERE `username`={$info['email']}";
		}

		$result = $this->db->query($sql);
		if( $result->num_rows === 0 ){
			return array('code'=> 1, 'msg'=>'用户不存在');
		}
		$data = $result->row_array();
		if( $data['password'] !== $this->passwordHash($info['password']) ){
			return array('code'=>2, 'msg'=>'密码或用户名错误');
		}
		$this->setLogin($data['userid']);
		return array('code'=>0, 'id'=> $data['userid'], 'name'=>$data['username']);
	}
	
	public function setLogin($uid)
	{
		$regip = $this->input->ip_address();
		$sql = "UPDATE {$this->tname} SET `loginnum`=`loginnum`+1, `regip`='{$regip}'";
		$sql .= " WHERE `userid` = '{$uid}'";
		$this->db->query($sql);
	}
	
	public function getInfo($uid, $select='*')
	{
		$uid = (int)$uid;
		$sql = "SELECT {$select} FROM `{$this->tname}` WHERE `userid` = '$uid'";
		return $this->db->query($sql)->row_array();
	}
	
	
	public function updateInfo($uid, $qq, $phone, $sex)
	{
		if( !empty($qq) && !is_numeric($qq) ){
			$qq = preg_replace('#\D#', '', $qq);
		}
		if( !empty($phone) && !is_numeric($phone) ){
			$phone = preg_replace('#\D#', '', $phone);
		}
		
		
		$update = array(
			'qq' => $qq,
			'phone' => $phone,
			'sex' => (int)$sex
			);
		$this->db->where('userid', $uid);
		return $this->db->update($this->tname, $update);
	}
	
	public function changepassword($uid, $old, $new)
	{
		$info = $this->getInfo($uid, 'password');
		$oldpass = $this->passwordHash($old);
		if( $oldpass === $info['password'] ){
			$this->db->where('userid', $uid);
			$newpass = $this->passwordHash($new);
			$this->db->update($this->tname, array('password'=>$newpass));
			return true;
		}else{
			return false;
		}
	}
	
	private function passwordHash($password)
	{
		return md5($password);
	}
}

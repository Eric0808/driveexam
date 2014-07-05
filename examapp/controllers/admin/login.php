<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('message');
		//$this->load->model('check');
		
	}
	function index()
	{
	
		$temp['xinxi']="";
		
		$this->load->view('admin/login',$temp);
		
	}
	
	function check()
	{
	
		$username=$this->input->post('user');
		$userpass=$this->input->post('pwd');
		
		$userinfo = array();
		$where['username']=$username;
		$where['password']=sha1($userpass);
		$table="admin_info";
		$query=$this->db->get_where($table,$where);
		$num=$query->num_rows();
		
		if($num==1)
		{
			$userinfo=$query->row_array();
			$this->session->set_userdata(array('manager_id'=>$userinfo['userid']));
			$this->session->set_userdata(array('manager'=>$username));
			redirect('admin/welcome');
		}
		else
		{
			$temp['xinxi']="用户名密码错误";
			$this->load->view('admin/login',$temp);
		}
	}
	/**
	 * 管理员退出
	 */
	function logout()
	{
		$this->session->unset_userdata('manager');
		redirect('admin/login');
	}
	function updatepass()
	{
		$userid = $this->session->userdata('manager_id');
		$oldpass = $this->input->post('old_password');
		$newpass = $this->input->post('new_password');
		if(isset($oldpass) && isset($newpass) && $this->input->post('old_password')!=''){
			$oldpass = $this->input->post('old_password');
		    $newpass = sha1($this->input->post('new_password'));
			$data = array(
               'password' => $newpass
            );

			$this->db->where('userid', $userid);
			$query = $this->db->update('admin_info', $data); 
			//$this->load->view('admin/updatepass');
			if($query){
				$this->message->showmessage('密码更新成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else{$this->message->showmessage('密码更新失败!',$this->input->server('HTTP_REFERER'));exit();}
			
		}
		else{
		//$this->message->showmessage('Update Error!','admin/updatepass/');exit();
		   //$this->message->showmessage('信息不完整!',$this->input->server('HTTP_REFERER'));exit();
		   $this->load->view('admin/updatepass');
		   //$this->message->showmessage('Update success!');
		}
		//
		
		
	}
	/**
	 * 异步检测密码
	 */
	function ajaxck_oldpass()
	{
		$userid = $this->session->userdata('manager_id');
		
		$r = array();
		$query = $this->db->get_where('admin_info',array('userid'=>$userid),1);
		
		//die($userid);
		$r = $query->row_array();
		
		if ( sha1($_GET['old_password']) == $r['password'] ) {
			exit('1');
		}
		exit('0');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
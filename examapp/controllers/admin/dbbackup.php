<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Dbbackup extends CI_Controller
{
	
	public function __construct()
	{
		//header('Content-type: text/html;charset=utf-8');
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		 //$this->config->load('database');
		$this->load->model('message');
		$this->load->library('Backupdatabade');
		
	}
	
	public function backup()
	{	
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$oldpass = $this->input->post('old_password');
			if($oldpass!=''){
			$host= $this->db->hostname;
			$username= $this->db->username;
			$pass= $this->db->password;
			$db= $this->db->database;
			
			$lnk = mysql_connect($host,$username,$pass) or die ('连接失败'.mysql_error());  
			  
			if (!mysql_select_db($db,$lnk)){  
			  exit();
				}
			$this->backupdatabade->populate_db( $db,'',dirname(__FILE__)."/../data/backup.sql" );
			echo '数据库清空完毕！';
			}
			else{
				$this->message->showmessage('您没有填写密码，无法操作!',$this->input->server('HTTP_REFERER'));exit();
			}
		}
	}
	public function index()
	{
		$this->load->view('admin/backup');
	}
	public function ajaxck_oldpass()
	{
		$userid = $this->session->userdata('manager_id');
		$r = array();
		$query = $this->db->get_where('admin',array('id'=>$userid),1);
		//die($userid);
		$r = $query->row_array();
		if ( sha1($_GET['old_password']) == $r['userpass'] ) {
		    exit('1');
		}
		exit('0');
	
		
	}
	
	
}
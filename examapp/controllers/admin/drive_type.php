<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Drive_type extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('subject_model');
		$this->load->model('message');
		

	}
	
	public function index()
	{
		if(isset($_GET['id']) && !empty($_GET['id']))
		{	
			$data['typeinfo'] = $this->subject_model->Detail_byID(intval($_GET['id']));
			$data['editid'] = $_GET['id'];
			$this->load->view('admin/drive_type/edit_type',$data);
		}
		else{
		    $this->load->view('admin/drive_type/drive_type');
		}
		
	}
	//添加车型、科目
	public function Addtype()
	{
		
		$sqlstr="";
		if(!empty($_POST['drivetype']) && !empty($_POST['subject1'])&& !empty($_POST['remark']) && !empty($_POST['bankid']) && !empty($_POST['chapterid'])) {
			
			$newvaluesql = "('".$_POST['drivetype']."','".$_POST['subject1']."','".$_POST['remark']."', '".intval(trim($_POST['bankid']))."','".$_POST['chapterid']."')";
			$sqlstr = 'INSERT INTO table_info'." (`drivetype`,`subject1`,`remark`,`bankid`, `chaperid`) VALUES ".$newvaluesql.";";
			
			if(!empty($newvaluesql) && $sqlstr!="") {
				
				$status = $this->subject_model->Adddrivetype($sqlstr);
				if($status)
				{$this->message->showmessage('添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
		else{
		$this->message->showmessage('信息不能为空!',$this->input->server('HTTP_REFERER'));exit();}
		
	}
	
	public function deleteby_id() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->subject_model->deltype_byID($id);
					if(!$result){
						$this->message->showmessage('删除出错，终止操作!',$this->input->server('HTTP_REFERER'));exit();
					}
				}
				$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else{
				$this->message->showmessage('你还没有选择任何项!',$this->input->server('HTTP_REFERER'));exit();
			}
		}
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['id']) && !empty($_GET['id'])){
				    $id = intval($_GET['id']);
					$result = $this->subject_model->deltype_byID($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	public function editby_id(){
		
		if(!empty($_POST['edit_id']) && !empty($_POST['drivetype']) && !empty($_POST['subject1'])&& !empty($_POST['remark'])  && !empty($_POST['chapterid'])) {
			
			$id = (int)$_POST['edit_id'];
			$updateArr = array(
						'drivetype'=>$_POST['drivetype'],
						'subject1'=>$_POST['subject1'],
						'remark'=>$_POST['remark'],
						'bankid'=>intval(trim($_POST['bankid'])),
						'chaperid'=>trim($_POST['chapterid'],',')
			             );
			
				
				$status = $this->subject_model->Updatetype_byid($updateArr, $id);
				if($status)
				{$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('更新失败!',$this->input->server('HTTP_REFERER'));exit();}
			
		}
		else{
		$this->message->showmessage('信息不能为空!',$this->input->server('HTTP_REFERER'));exit();}
		
	}
	
	//管理车型科目信息
	public function Managetype()
	{	
		$data['typelist'] = $this->subject_model->Getalltype();
		//var_dump($data['typelist']);exit;
		$this->load->view('admin/drive_type/typelist', $data);
	}
	
	
	
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Bank_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('bank_model');
		$this->load->model('cate_model');
		$this->load->model('message');
		

	}
	
	public function index()
	{
		//var_dump(get_included_files());exit();
		$data['catelist'] = $this->cate_model->Getcategory();
		if(isset($_GET['id']) && !empty($_GET['id'])){	
			$data['editid'] = (int)$_GET['id'];
			$data['bankinfo'] = $this->bank_model->Detail_byID(intval($_GET['id']));
			$this->load->view('admin/bank_info/edit_bank',$data);
		}
		else{
		    $this->load->view('admin/bank_info/add_bank',$data);
		}
		
	}
	//添加题库
	public function Addbank()
	{
		$sqlstr = "";
		if(!empty($_POST['cate_name'])){$cateids = serialize($_POST['cate_name']);}
		else{$cateids = null;}
		 
		if(!empty($_POST['bank_name']) && $_POST['year']!="-1") {
			
			    $newvaluesql = "('".$_POST['bank_name']."', '".$_POST['year']."','".$cateids."')";
				$sqlstr = 'INSERT INTO table_info'." (`name`,`year`,`cateids`) VALUES ".$newvaluesql.";";

				$status = $this->bank_model->Addbank($sqlstr);
				if($status)
				{$this->message->showmessage('添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			
		}
		else{
		$this->message->showmessage('信息不能为空!',$this->input->server('HTTP_REFERER'));exit();} 
		
	}
	
	//管理题库信息
	public function Managebank()
	{	
		$cPage = isset($_GET['page'])? intval($_GET['page']) : 1;
		$bankList = $this->bank_model->Getbank_bypage($cPage, 20, 10 , '', ' ORDER BY b.id DESC ');
		if(is_array($bankList)){
		$data['banklist'] = $bankList[1];
		$data['pagestr'] = $bankList[0];
		$this->load->view('admin/bank_info/banklist', $data);
	    }
	}
	
	public function Updatebank(){
		
		
		if(!empty($_POST['cate_name'])){$cateids = serialize($_POST['cate_name']);}
		else{$cateids = null;}
		 
		if(!empty($_POST['bank_name']) && $_POST['year']!="-1" && !empty($_POST['edit_id'])) {
				$id = (int)$_POST['edit_id'];
				$arrupdate = array('name'=>$_POST['bank_name'],
								   'year'=>$_POST['year'],
								   'cateids'=>$cateids
				                  );
				$status = $this->bank_model->Updatebank_byid($arrupdate, $id);
				if($status)
				{$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('更新失败!',$this->input->server('HTTP_REFERER'));exit();}
			
		}
		else{
		$this->message->showmessage('信息不能为空!',$this->input->server('HTTP_REFERER'));exit();} 
	}
	
	public function deleteby_id() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->bank_model->Delete_byid($id);
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
					$result = $this->bank_model->Delete_byid($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
}
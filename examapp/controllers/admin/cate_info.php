<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Cate_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('cate_model');
		$this->load->model('message');

	}
	
	public function index()
	{
		
		$data['catelist'] = $this->cate_model->Getcategory();
		$this->load->view('admin/topic_info/cate_info',$data);
		
	}
	
	
	public function Delcate(){
		$cateid=isset($_GET['cateid']) ? intval($_GET['cateid']) : -1;
		
		if($cateid>0){
		
			$status = $this->cate_model->Delete_bycatid($cateid);
			if($status)
			{
			    $this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else
			{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
		}
		else
		$this->message->showmessage('该试题类型不存在!',$this->input->server('HTTP_REFERER'));exit();
		
		
	}
	
	
	//更新试题类型信息和排序
	public function Newcategory(){
		
		$sqlstr=null;
		if(!empty($_POST['newcategory']) && !empty($_POST['newdisplay'])) {
			
			foreach($_POST['newcategory'] as $key=>$newname) {
			
			    $newvaluesql[] = "('".$_POST['newdisplay'][$key]."', '$newname')";
			}
			if(!empty($newvaluesql)) {
				$sqlstr = 'INSERT INTO table_info'." (`displayorder`, `name`) VALUES ".implode(", ", $newvaluesql).";";
				$status = $this->cate_model->Addcategory($sqlstr);
				if($status)
				{$this->message->showmessage('试题类型添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('试题类型添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
		else if(!empty($_POST['display']) && !empty($_POST['name'])){
				
				foreach($_POST['display'] as $key=>$neworder){
					
					$status = $this->cate_model->Updateorder(array('displayorder'=>intval($neworder), 'name'=>$_POST['name'][$key]), $key);
				}
				
				$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();
		
		}

	}
	
	
	
	
}
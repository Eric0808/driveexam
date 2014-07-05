<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Link_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('link_model');
		$this->load->model('message');

	}
	
	public function index()
	{
		
		$data['linklist'] = $this->link_model->Getlinks();
		$this->load->view('admin/link_info/link_info',$data);
		
	}
	
	
	public function Dellink(){
		$linkID=isset($_GET['linkid']) ? intval($_GET['linkid']) : -1;
		
		if($linkID>0){
		
			$status = $this->link_model->Delete_bylinkid($linkID);
			if($status)
			{
			    $this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else
			{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
		}
		else
		$this->message->showmessage('该友链不存在!',$this->input->server('HTTP_REFERER'));exit();
		
		
	}
	
	
	//更新友链信息和排序
	public function Newlinks(){
		
		$sqlstr=null;
		if(!empty($_POST['newlink']) && !empty($_POST['newdisplay']) && !empty($_POST['newurl'])) {
			
			foreach($_POST['newlink'] as $key=>$newname) {
				$url = strpos($_POST['newurl'][$key], 'http://')===FALSE ? 'http://'.$_POST['newurl'][$key] : $_POST['newurl'][$key];
			    $newvaluesql[] = "('".$_POST['newdisplay'][$key]."', '$newname', '".$url."', '".time()."')";
			}
			if(!empty($newvaluesql)) {
				$sqlstr = 'INSERT INTO table_info'." (`displayorder`, `name`, `url`, `addtime`) VALUES ".implode(", ", $newvaluesql).";";
				$status = $this->link_model->Addlink($sqlstr);
				if($status)
				{$this->message->showmessage('友情链接添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('友情链接添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
		else if(!empty($_POST['display']) && !empty($_POST['name']) && !empty($_POST['url']) ){
				
				foreach($_POST['display'] as $key=>$neworder){
					$url = strpos($_POST['url'][$key], 'http://')===FALSE ? 'http://'.$_POST['url'][$key] : $_POST['url'][$key];
					$status = $this->link_model->Updateorder(array('displayorder'=>intval($neworder), 'name'=>$_POST['name'][$key], 'url'=>$_POST['url'][$key]), $key);
				}
				
				$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();
		
		}

	}
	
	
	
	
}
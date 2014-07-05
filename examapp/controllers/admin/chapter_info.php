<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Chapter_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('chapter_model');
		$this->load->model('message');

	}
	
	public function index()
	{
		
		$data['chapterlist'] = $this->chapter_model->Getchapter();
		$this->load->view('admin/topic_info/chapter_info',$data);
		
	}
	
	
	public function Delchapter(){
		$cid=isset($_GET['id']) ? intval($_GET['id']) : -1;
		
		if($cid>0){
		
			$status = $this->chapter_model->Delete_bychapterid($cid);
			if($status)
			{
			    $this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else
			{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
		}
		else
		$this->message->showmessage('该章节不存在!',$this->input->server('HTTP_REFERER'));exit();
		
		
	}
	
	
	//更新试题类型信息和排序
	public function Newchapter(){
		
		$sqlstr=null;
		if(!empty($_POST['newchapter']) && !empty($_POST['newdisplay'])) {
			
			foreach($_POST['newchapter'] as $key=>$newname) {
			
			    $newvaluesql[] = "('".$_POST['newdisplay'][$key]."', '$newname')";
			}
			if(!empty($newvaluesql)) {
				$sqlstr = 'INSERT INTO table_info'." (`displayorder`, `name`) VALUES ".implode(", ", $newvaluesql).";";
				$status = $this->chapter_model->Addchapter($sqlstr);
				if($status)
				{$this->message->showmessage('章节添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('章节添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
		else if(!empty($_POST['display']) && !empty($_POST['name'])){
				
				foreach($_POST['display'] as $key=>$neworder){
					
					$status = $this->chapter_model->Updateorder(array('displayorder'=>intval($neworder), 'name'=>$_POST['name'][$key]), $key);
				}
				
				$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();
		
		}

	}
	
	
	
	
}
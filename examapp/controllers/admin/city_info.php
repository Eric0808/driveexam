<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class City_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('city_model');
		$this->load->model('message');

	}
	
	public function index()
	{
		
		$data['citylist'] = $this->city_model->Getcitys();
		$this->load->view('admin/drive_type/city_info',$data);
		
	}
	
	
	public function Delcity(){
		$id=isset($_GET['cityid']) ? intval($_GET['cityid']) : -1;
		
		if($id>0){
		
			$status = $this->city_model->Delete_byid($id);
			if($status)
			{
			    $this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else
			{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
		}
		else
		$this->message->showmessage('该城市不存在!',$this->input->server('HTTP_REFERER'));exit();
		
		
	}
	
	
	//更新试题类型信息和排序
	public function Newcity(){
		
		$sqlstr=null;
		if(!empty($_POST['newcity']) && !empty($_POST['newdisplay']) && !empty($_POST['newkey'])) {
			
			foreach($_POST['newcity'] as $key=>$newname) {
			
			    $newvaluesql[] = "('".$_POST['newdisplay'][$key]."', '$newname', '".$_POST['newkey'][$key]."')";
			}
			if(!empty($newvaluesql)) {
				$sqlstr = 'INSERT INTO table_info'." (`displayorder`, `name`, `key`) VALUES ".implode(", ", $newvaluesql).";";
				$status = $this->city_model->Addcity($sqlstr);
				if($status)
				{$this->message->showmessage('城市添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else
				{$this->message->showmessage('城市添加失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
		else if(!empty($_POST['display']) && !empty($_POST['name']) && !empty($_POST['keystr'])){
				
				foreach($_POST['display'] as $key=>$neworder){
					
					$status = $this->city_model->Updateorder(array('displayorder'=>intval($neworder), 'name'=>$_POST['name'][$key], 'key'=>$_POST['keystr'][$key]), $key);
				}
				
				$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));exit();
		
		}

	}
	
	
	
	
}
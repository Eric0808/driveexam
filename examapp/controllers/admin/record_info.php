<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Record_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('record_model');
		
		$this->load->model('message');
		
	}

	public function index()
	{
		
		$memberList = $this->member_model->Getallmember($_GET['page']);
		if(is_array($memberList)){
		$data['userlist'] = $memberList[1];
		$data['pagestr'] = $memberList[0];
		$this->load->view('admin/user_manger/userlists',$data);}
		
	}
	
	
	
	public function clearexam_id(){
	
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->exam_model->clear_byid($id);
					if(!$result){
						$this->message->showmessage('考试记录清空失败，终止操作!',$this->input->server('HTTP_REFERER'));exit();
					}
				}
				$this->message->showmessage('考试记录清空成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else{
				$this->message->showmessage('你还没有选择任何项!',$this->input->server('HTTP_REFERER'));exit();
			}
		}
	
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['id']) && !empty($_GET['id'])){
				$id=intval($_GET['id']);
				$result=$this->exam_model->clear_byid($id);
				if($result){
					$this->message->showmessage('考试记录清空成功!',$this->input->server('HTTP_REFERER'));exit();
				}
				else{
					$this->message->showmessage('未知错误!清空失败',$this->input->server('HTTP_REFERER'));exit();
				}
			}
		}
	}

	public function lookexam_id(){
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['uid']) && isset($_GET['cid']) && !empty($_GET['uid']) && !empty($_GET['cid'])){

		$this->load->model('exam_model');
		$uid=intval($_GET['uid']);

		$this->load->model('client/categorylist_model', 'categorylist');
		$id = intval($_GET['cid']);
		$cate = $this->categorylist->getByIdALevel($id, 0);
		
		
		$this->load->model('client/exam_info_model', 'exam_info');
		$info = $this->exam_info->getInfoByCid($uid, $id);
		
		$info['status'] = (int)$info['status'];
		if( $info['status'] < 3 ){
			switch($info['status'])
			{
				case 1:
					$msg = '它还没有开始这门考试';
					break;
				case 2:
					$msg = '这项考试并没有结束，因此还无法计算成绩';
					break;
				default:
					$msg = '未知的错误 #1';
					break;
			}
			$data = array();
			$this->message->showmessage($msg,$this->input->server('HTTP_REFERER'));exit();
		}
		
		
		$evaluation = unserialize($info['evaluation']);
		if( empty($evaluation) ){
			$msg = "虽然他已经完成了这个考试，但似乎数据库中并没有它的成绩";
			$this->message->showmessage($msg,$this->input->server('HTTP_REFERER'));exit();
		}
		
		if( ! is_array($evaluation) ){
			$msg = "未知错误";
			$this->message->showmessage($msg,$this->input->server('HTTP_REFERER'));exit();
		}
		
		
		
		$rows = array();
		foreach($evaluation as $cid=>$e)
		{
			if( ! isset($e['evaluation']) ){
				$e['evaluation'] = '';
			}
			if( ! isset($e['socres']) ){
				$e['socres'] = 0;
			}
			$row = array();
			$row['s'] = $e['socres']/10000;
			$row['e'] = htmlspecialchars($e['evaluation']);

			$rows[$cid] = $row;
		}
		
		$data['evaluation'] = json_encode($rows);

		$data['child'] = array();
		$data['child']['id'] = $id;
		$data['child']['name'] = $cate['name'];
		$data['child']['weight'] = $cate['weight'];
		$data['child']['child'] = $this->categorylist->getAllChildInfo($id);
		$data['child'] = json_encode($data['child']);
		
		$data['username'] = htmlspecialchars($_GET['uname']);
		
		
		$content = $this->load->view('account/result', $data, true);
		$this->load->view('admin/usermanger/user',array('content'=>$content));
							
					}
					else{$this->message->showmessage('该会员还没有参加测评的记录!',$this->input->server('HTTP_REFERER'));exit();}
			}
		
	}
	
	public function deleteby_id() {
		$qid=-1;
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->member_model->delete($id);
					$result1=$this->exam_model->delete_byuid($id);
					if(!$result || !$result1){
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
					$result = $this->user_model->delete($id);
					$result1=$this->exam_model->delete_byuid($id);
					if($result && $result1){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	
}
